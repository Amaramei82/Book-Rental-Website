const express = require("express");
const mysql = require("mysql");
const cors = require("cors");
const md5 = require("md5");
const path = require("path");

const app = express();

// =======================
// MIDDLEWARE
// =======================
app.use(cors());
app.use(express.json());

// =======================
// STATIC IMAGE FOLDER
// =======================
app.use(
  "/Img/books",
  express.static(
    path.join(__dirname, "..", "Img", "books")
  )
);

// =======================
// DATABASE CONNECTION
// =======================
const db = mysql.createConnection({
  host: "localhost",
  port: 3307,
  user: "root",
  password: "",
  database: "book-rental-website",
});

db.connect((err) => {
  if (err) {
    console.log("DB Connection Error:", err.message);
  } else {
    console.log("Connected to database successfully!");
  }
});

// =======================
// ROOT ROUTE
// =======================
app.get("/", (req, res) => {
  res.send("Book Rental API is running!");
});

// =======================
// USER REGISTRATION
// =======================
app.post("/register", (req, res) => {
  let { name, email, mobile, password } = req.body;

  if (!name || !email || !mobile || !password) {
    return res.status(400).json({
      success: false,
      message: "All fields are required.",
    });
  }
  name = name.trim();
  email = email.trim().toLowerCase(); 
  mobile = mobile.trim();
  const hashedPassword = md5(password.trim());

  const doj = new Date()
    .toISOString()
    .slice(0, 19)
    .replace("T", " ");

  const sql = `
    INSERT INTO users 
    (name, email, mobile, password, doj) 
    VALUES (?, ?, ?, ?, ?)
  `;

  db.query(
    sql,
    [name, email, mobile, hashedPassword, doj],
    (err, result) => {
      if (err) {
        console.error("Registration DB Error:", err.message);
        
        const errorMsg = err.code === 'ER_DUP_ENTRY' 
          ? "This email address is already registered." 
          : err.message;

        return res.status(500).json({
          success: false,
          message: errorMsg,
        });
      }

      res.json({
        success: true,
        message: "User registered successfully",
      });
    }
  );
});

// =======================
// USER LOGIN
// =======================
app.post("/login", (req, res) => {
  let { email, password } = req.body;

  email = email.trim().toLowerCase();
  password = password.trim();

  const hashedPassword = md5(password);

  console.log("INPUT EMAIL:", email);
  console.log("INPUT PASSWORD:", password);
  console.log("HASHED PASSWORD:", hashedPassword);

  const sql = `
    SELECT *
    FROM users
    WHERE LOWER(TRIM(email)) = ?
  `;

  db.query(sql, [email], (err, result) => {
    if (err) {
      console.log(err);

      return res.status(500).json({
        success: false,
        error: err.message,
      });
    }

    console.log("DATABASE USER:", result);

    if (result.length === 0) {
      console.log("EMAIL NOT FOUND");

      return res.json({
        success: false,
        message: "Email not found",
      });
    }

    const user = result[0];

    console.log("DB PASSWORD:", user.password);

    if (user.password !== hashedPassword) {
      console.log("PASSWORD NOT MATCH");

      return res.json({
        success: false,
        message: "Invalid password",
      });
    }

    res.json({
      success: true,
      user: {
        id: user.id,
        name: user.name,
        email: user.email,
        mobile: user.mobile,
      },
    });
  });
});

// =======================
// GET ALL USERS
// =======================
app.get("/users", (req, res) => {
  const sql = `
    SELECT
      id,
      name,
      email,
      mobile
    FROM users
  `;

  db.query(sql, (err, result) => {
    if (err) {
      return res.status(500).json({
        error: err.message,
      });
    }

    res.json(result);
  });
});

// =======================
// GET ALL BOOKS
// =======================
app.get("/books", (req, res) => {
  const sql = `
    SELECT
      books.id,
      books.name,
      books.author,
      books.description,
      books.img,
      books.category_id,
      categories.category

    FROM books

    LEFT JOIN categories
    ON books.category_id = categories.id

    WHERE books.status = 1

    ORDER BY books.name ASC
  `;

  db.query(sql, (err, result) => {
    if (err) {
      return res.status(500).json({
        error: err.message,
      });
    }

    const books = result.map((book) => ({
      id: book.id,
      name: book.name || "",
      author: book.author || "",
      description:
        book.description &&
        book.description.toString().trim() !== ""
          ? book.description
          : "No description available",

      category: book.category || "Unknown",
      category_id: book.category_id,

      img: book.img || "",

      img_url:
        `http://10.152.173.210:3001/Img/books/${book.img}`,
    }));

    res.json(books);
  });
});

// =======================
// GET BOOKS BY CATEGORY
// =======================
app.get("/books/categories/:catId", (req, res) => {
  const catId = req.params.catId;

  const sql = `
    SELECT
      books.id,
      books.name,
      books.author,
      books.description,
      books.img,
      books.category_id,
      categories.category

    FROM books

    LEFT JOIN categories
    ON books.category_id = categories.id

    WHERE books.category_id = ?
    AND books.status = 1
  `;

  db.query(sql, [catId], (err, result) => {
    if (err) {
      return res.status(500).json({
        error: err.message,
      });
    }

    const books = result.map((book) => ({
      id: book.id,
      name: book.name || "",
      author: book.author || "",
      description:
        book.description &&
        book.description.toString().trim() !== ""
          ? book.description
          : "No description available",

      category: book.category || "Unknown",
      category_id: book.category_id,

      img: book.img || "",

      img_url:
        `http://10.152.173.210:3001/Img/books/${book.img}`,
    }));

    res.json(books);
  });
});

// =======================
// GET CATEGORIES
// =======================
app.get("/categories", (req, res) => {
  const sql = `
    SELECT
      id,
      category

    FROM categories

    WHERE status = 1

    ORDER BY category ASC
  `;

  db.query(sql, (err, result) => {
    if (err) {
      return res.status(500).json({
        error: err.message,
      });
    }

    res.json(result);
  });
});

// =======================
// PLACE ORDER
// =======================
app.post("/orders/place", (req, res) => {
  const {
    user_id,
    address,
    address2,
    pin,
    payment_method,
    total,
    duration,
    book_id,
    price,
  } = req.body;

  console.log("ORDER DATA:", req.body);

  const orderDate = new Date()
    .toISOString()
    .slice(0, 19)
    .replace("T", " ");

  const orderSql = `
    INSERT INTO orders
    (
      user_id,
      address,
      address2,
      pin,
      payment_method,
      total,
      payment_status,
      order_status,
      date,
      duration
    )
    VALUES (?, ?, ?, ?, ?, ?, 'Pending', 1, ?, ?)
  `;

  db.query(
    orderSql,
    [
      user_id,
      address,
      address2,
      pin,
      payment_method,
      total,
      orderDate,
      duration,
    ],
    (err, result) => {
      if (err) {
        console.log("ORDER INSERT ERROR:", err);

        return res.status(500).json({
          success: false,
          error: err.message,
        });
      }

      const orderId = result.insertId;

      const detailSql = `
        INSERT INTO order_detail
        (
          order_id,
          book_id,
          price,
          time
        )
        VALUES (?, ?, ?, ?)
      `;

      db.query(
        detailSql,
        [
          orderId,
          book_id,
          price,
          duration,
        ],
        (err2) => {
          if (err2) {
            console.log("ORDER DETAIL ERROR:", err2);

            return res.status(500).json({
              success: false,
              error: err2.message,
            });
          }

          res.json({
            success: true,
            message: "Order placed successfully!",
            order_id: orderId,
          });
        }
      );
    }
  );
});

// =======================
// GET ORDERS BY USER ID
// =======================
app.get("/orders/user/:id", (req, res) => {
  const userId = req.params.id;

  const sql = `
    SELECT
      o.id,
      o.date,
      o.address,
      o.payment_method,
      o.payment_status,
      o.duration,

      os.status_name,

      b.name AS book_name,

      od.price

    FROM orders o

    LEFT JOIN order_detail od
    ON o.id = od.order_id

    LEFT JOIN books b
    ON od.book_id = b.id

    LEFT JOIN order_status os
    ON o.order_status = os.id

    WHERE o.user_id = ?

    ORDER BY o.date DESC
  `;

  db.query(sql, [userId], (err, result) => {
    if (err) {
      return res.status(500).json({
        error: err.message,
      });
    }

    res.json(result);
  });
});

// =======================
// GET ALL ORDERS
// =======================
app.get("/orders", (req, res) => {
  const sql = `
    SELECT
      o.id,
      o.address,
      o.payment_method,
      o.payment_status,
      o.duration,
      o.date,
      od.price,
      b.name AS book_name,
      u.name AS customer_name,
      os.status_name
    FROM orders o
    LEFT JOIN users u
    ON o.user_id = u.id
    LEFT JOIN order_status os
    ON o.order_status = os.id
    LEFT JOIN order_detail od
    ON o.id = od.order_id
    LEFT JOIN books b
    ON od.book_id = b.id
    ORDER BY o.date DESC
  `;

  db.query(sql, (err, result) => {
    if (err) {
      return res.status(500).json({
        error: err.message,
      });
    }

    res.json(result);
  });
});

// =======================
// START SERVER
// =======================
const PORT = 3001;

app.listen(PORT, "0.0.0.0", () => {
  console.log(`Server running on port ${PORT}`);
});