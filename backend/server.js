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

app.get("/", (req, res) => {
  res.send("Book Rental API is running!");
});

// =======================
// 1. USER LOGIN
// =======================
app.post("/login", (req, res) => {
  const { email, password } = req.body;
  const hashedPassword = md5(password);

  // Schema check: users table has name, email, mobile, password
  const sql = "SELECT id, name, email, mobile FROM users WHERE email = ? AND password = ?";
  db.query(sql, [email, hashedPassword], (err, result) => {
    if (err) return res.status(500).json({ success: false, error: err.message });

    if (result.length > 0) {
      res.json({ success: true, user: result[0] });
    } else {
      res.json({ success: false, message: "Invalid email or password" });
    }
  });
});

// =======================
// 2. GET BOOKS BY CATEGORY
// =======================
app.get("/books/categories/:catId", (req, res) => {
  const catId = req.params.catId;
  // Schema check: books table uses category_id and status (1 for active)
  const sql = "SELECT * FROM books WHERE category_id = ? AND status = 1";
  db.query(sql, [catId], (err, result) => {
    if (err) return res.status(500).json({ error: err.message });
    res.json(result);
  });
});

// =======================
// 3. GET USER ORDERS
// =======================
app.get("/users/orders/:id", (req, res) => {
  const userId = req.params.id;
  // Schema check: joins orders with order_status for descriptive status names
  const sql = `
    SELECT o.*, os.status_name 
    FROM orders o 
    JOIN order_status os ON o.order_status = os.id 
    WHERE o.user_id = ? 
    ORDER BY o.date DESC`;

  db.query(sql, [userId], (err, result) => {
    if (err) return res.status(500).json({ success: false, error: err.message });
    res.json(result);
  });
});

// =======================
// 4. PLACE NEW ORDER
// =======================
app.post("/orders/place", (req, res) => {
  const { 
    user_id, address, address2, pin, 
    payment_method, total, duration, 
    book_id, price 
  } = req.body;
  
  const orderDate = new Date().toISOString().slice(0, 19).replace('T', ' ');

  // Step A: Insert into 'orders' table
  // Columns per SQL: user_id, address, address2, pin, payment_method, total, payment_status, order_status, date, duration
  const orderSql = `
    INSERT INTO orders 
    (user_id, address, address2, pin, payment_method, total, payment_status, order_status, date, duration) 
    VALUES (?, ?, ?, ?, ?, ?, 'success', 1, ?, ?)`;

  db.query(orderSql, [user_id, address, address2, pin, payment_method, total, orderDate, duration], (err, result) => {
    if (err) return res.status(500).json({ success: false, error: err.message });

    const orderId = result.insertId;

    // Step B: Insert into 'order_detail' table
    // Columns per SQL: order_id, book_id, price, time
    const detailSql = "INSERT INTO order_detail (order_id, book_id, price, time) VALUES (?, ?, ?, ?)";
    db.query(detailSql, [orderId, book_id, price, duration], (err2) => {
      if (err2) return res.status(500).json({ success: false, error: err2.message });
      
      res.json({ 
        success: true, 
        message: "Order placed successfully", 
        order_id: orderId 
      });
    });
  });
});

// Start Server
const PORT = 3001;
app.listen(PORT, () => {
  console.log(`Book Rental API is running on http://localhost:${PORT}`);
});