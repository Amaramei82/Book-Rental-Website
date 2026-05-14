const express = require("express");
const mysql = require("mysql");
const cors = require("cors");
const md5 = require("md5");

const app = express();
app.use(cors());
app.use(express.json());

// Database Connection
const db = mysql.createConnection({
  host: "localhost",
  port: 3307, 
  user: "root",
  password: "",
  database: "book-rental-website" 
});

db.connect(err => {
  if (err) {
    console.error("DB Connection Error:", err.message);
  } else {
    console.log("Connected to the 'book-rental-website' database.");
  }
});

// ROOT ROUTE
app.get("/", (req, res) => {
  res.send("Book Rental API is running!");
});

// =======================
// 1. USER REGISTRATION
// =======================
app.post("/register", (req, res) => {
  const { name, email, mobile, password } = req.body;
  const hashedPassword = md5(password);
  
  // Maghimo og timestamp para sa DOJ sama sa gibuhat sa PHP
  const doj = new Date().toISOString().slice(0, 19).replace('T', ' ');

  const sql = "INSERT INTO users (name, email, mobile, password, doj) VALUES (?, ?, ?, ?, ?)";
  db.query(sql, [name, email, mobile, hashedPassword, doj], (err, result) => {
    if (err) return res.status(500).json({ success: false, error: err.message });
    res.json({ success: true, message: "User registered successfully" });
  });
});

// =======================
// 2. USER LOGIN
// =======================
app.post("/login", (req, res) => {
  let { email, password } = req.body;

  email = email.trim().toLowerCase();
  password = password.trim();

  const hashedPassword = md5(password);

  console.log("INPUT EMAIL:", email);
  console.log("INPUT PASSWORD:", password);
  console.log("HASHED PASSWORD:", hashedPassword);

  const sql = "SELECT * FROM users WHERE LOWER(TRIM(email)) = ?";

  db.query(sql, [email], (err, result) => {

    if (err) {
      console.log(err);
      return res.status(500).json({
        success: false,
        error: err.message
      });
    }

    console.log("DATABASE USER:", result);

    if (result.length > 0) {

      console.log("DB PASSWORD:", result[0].password);

      if (result[0].password === hashedPassword) {

        return res.json({
          success: true,
          user: {
            id: result[0].id,
            name: result[0].name,
            email: result[0].email,
            mobile: result[0].mobile
          }
        });

      } else {

        console.log("PASSWORD NOT MATCH");

        return res.json({
          success: false,
          message: "Invalid password"
        });
      }

    } else {

      console.log("EMAIL NOT FOUND");

      return res.json({
        success: false,
        message: "Email not found"
      });
    }
  });
});

// =======================
// 3. GET BOOKS BY CATEGORY
// =======================
app.get("/books/categories/:catId", (req, res) => {
  const catId = req.params.catId;
  const sql = "SELECT * FROM books WHERE category_id = ? AND status = 1";
  db.query(sql, [catId], (err, result) => {
    if (err) return res.status(500).json({ error: err.message });
    res.json(result);
  });
});

// =======================
// 4. PLACE NEW ORDER (The logic you were missing)
// =======================
app.post("/orders/place", (req, res) => {
  const { 
    user_id, address, address2, pin, 
    payment_method, total, duration, 
    book_id, price 
  } = req.body;
  
  // Create a MySQL compatible timestamp
  const orderDate = new Date().toISOString().slice(0, 19).replace('T', ' ');

  // Step A: Create the main order entry
  const orderSql = `
    INSERT INTO orders 
    (user_id, address, address2, pin, payment_method, total, payment_status, order_status, date, duration) 
    VALUES (?, ?, ?, ?, ?, ?, 'Pending', 1, ?, ?)`;

  db.query(orderSql, [user_id, address, address2, pin, payment_method, total, orderDate, duration], (err, result) => {
    if (err) return res.status(500).json({ success: false, error: err.message });

    const orderId = result.insertId;

    // Step B: Create the order details (mapping the book to the order)
    const detailSql = "INSERT INTO order_detail (order_id, book_id, price, time) VALUES (?, ?, ?, ?)";
    db.query(detailSql, [orderId, book_id, price, duration], (err2) => {
      if (err2) return res.status(500).json({ success: false, error: err2.message });
      
      res.json({ 
        success: true, 
        message: "Order recorded in database!", 
        order_id: orderId 
      });
    });
  });
});

// =======================
// 5. GET ALL DATA (FOR ADMIN/DEBUG)
// =======================
app.get("/books", (req, res) => {

  const sql = `
    SELECT 
      books.id,
      books.name,
      books.author,
      books.description,
      books.img,
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
        error: err.message
      });
    }

    const books = result.map((book) => {

      return {
        ...book,
        img_url:
            "http://192.168.1.114/book-rental-website/media/books/" +
            book.img
      };
    });

    res.json(books);
  });
});

app.get("/categories", (req, res) => {
  db.query("SELECT * FROM categories", (err, result) => {
    if (err) return res.status(500).json(err);
    res.json(result);
  });
});

app.get("/orders", (req, res) => {
  const sql = `
    SELECT o.*, u.name as customer_name, os.status_name 
    FROM orders o 
    JOIN users u ON o.user_id = u.id
    JOIN order_status os ON o.order_status = os.id
    ORDER BY o.date DESC`;
  db.query(sql, (err, result) => {
    if (err) return res.status(500).json(err);
    res.json(result);
  });
});

app.get("/users", (req, res) => {
  db.query("SELECT id, name, email, mobile FROM users", (err, result) => {
    if (err) return res.status(500).json(err);
    res.json(result);
  });
});

// Start Server
const PORT = 3001;
app.listen(PORT, "0.0.0.0", () => {
  console.log(`Server running on port ${PORT}`);
});