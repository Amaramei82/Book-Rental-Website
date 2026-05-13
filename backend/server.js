const express = require("express");
const mysql = require("mysql");
const cors = require("cors");
const md5 = require("md5"); // Database uses MD5 for passwords

const app = express();
app.use(cors());
app.use(express.json());

// DB Connection - Updated to match your database name
const db = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "book-rental-website" 
});

db.connect(err => {
  if (err) console.log("DB Error:", err);
  else console.log("DB Connected to mini_project");
});

// =======================
// LOGIN (Updated for MD5)
// =======================
app.post("/login", (req, res) => {
  const { email, password } = req.body;
  // Your DB stores passwords in MD5
  const hashedPassword = md5(password);

  const sql = "SELECT id, name, email, mobile FROM users WHERE email=? AND password=?";
  db.query(sql, [email, hashedPassword], (err, result) => {
    if (err) return res.status(500).json({ success: false, message: err.message });

    if (result.length > 0) {
      res.json({ success: true, user: result[0] });
    } else {
      res.json({ success: false, message: "Invalid email or password" });
    }
  });
});

// =======================
// GET USER ORDERS
// =======================
app.get("/user/orders/:id", (req, res) => {
  const userId = req.params.id;
  // Joins orders with order_status table from your SQL
  const sql = `
    SELECT o.*, os.status_name 
    FROM orders o 
    JOIN order_status os ON o.order_status = os.id 
    WHERE o.user_id = ? 
    ORDER BY o.date DESC`;

  db.query(sql, [userId], (err, result) => {
    if (err) return res.status(500).json({ success: false, message: err.message });
    res.json(result);
  });
});

// =======================
// GET BOOKS BY CATEGORY
// =======================
app.get("/books/category/:catId", (req, res) => {
  const catId = req.params.catId;
  // Filters books by category_id and status=1 (Active)
  db.query("SELECT * FROM books WHERE category_id = ? AND status = 1", [catId], (err, result) => {
    if (err) return res.status(500).json(err);
    res.json(result);
  });
});

// =======================
// PLACE NEW ORDER
// =======================
app.post("/orders/place", (req, res) => {
  const { user_id, address, pin, total, duration, book_id, price } = req.body;
  const date = new Date().toISOString().slice(0, 19).replace('T', ' ');

  // 1. Insert into 'orders' table
  const orderSql = `INSERT INTO orders (user_id, address, pin, total, payment_status, order_status, date, duration, payment_method) 
                    VALUES (?, ?, ?, ?, 'pending', 1, ?, ?, 'COD')`;

  db.query(orderSql, [user_id, address, pin, total, date, duration], (err, result) => {
    if (err) return res.status(500).json({ success: false, message: err.message });

    const orderId = result.insertId;

    // 2. Insert into 'order_detail' table
    const detailSql = `INSERT INTO order_detail (order_id, book_id, price, time) VALUES (?, ?, ?, ?)`;
    db.query(detailSql, [orderId, book_id, price, duration], (err2) => {
      if (err2) return res.status(500).json({ success: false });
      res.json({ success: true, message: "Order placed successfully", order_id: orderId });
    });
  });
});

app.listen(3000, () => console.log("Book Rental API running on port 3000"));