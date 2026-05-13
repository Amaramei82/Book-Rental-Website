const express = require("express");
const mysql = require("mysql");
const cors = require("cors");
const md5 = require("md5");

const app = express();
app.use(cors());
app.use(express.json());

const db = mysql.createConnection({
  host: "localhost",
  port: 3307,
  user: "root",
  password: "",
  database: "book-rental-website" 
});

db.connect(err => {
  if (err) console.log("DB Error:", err);
  else console.log("DB Connected to mini_project");
});

// LOGIN
app.post("/login", (req, res) => {
  const { email, password } = req.body;
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

// GET USER ORDERS
app.get("/users/orders/:id", (req, res) => {
  const userId = req.params.id;
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

// GET BOOKS BY CATEGORY
app.get("/books/categories/:catId", (req, res) => {
  const catId = req.params.catId;
  // In mini_project.sql, the column is category_id
  db.query("SELECT * FROM books WHERE category_id = ? AND status = 1", [catId], (err, result) => {
    if (err) return res.status(500).json(err);
    res.json(result);
  });
});

// PLACE NEW ORDER
app.post("/orders/place", (req, res) => {
  // Extract all necessary fields including book_id and price for details
  const { user_id, address, address2, pin, payment_method, total, duration, book_id, price } = req.body;
  const orderDate = new Date().toISOString().slice(0, 19).replace('T', ' ');

  // 1. Insert into 'orders' table
  const orderSql = `INSERT INTO orders (user_id, address, address2, pin, payment_method, total, payment_status, order_status, date, duration) 
                    VALUES (?, ?, ?, ?, ?, ?, 'success', 1, ?, ?)`;

  db.query(orderSql, [user_id, address, address2, pin, payment_method, total, orderDate, duration], (err, result) => {
    if (err) return res.status(500).json({ success: false, message: err.message });

    const orderId = result.insertId;

    // 2. Insert into 'order_detail' table
    const detailSql = `INSERT INTO order_detail (order_id, book_id, price, time) VALUES (?, ?, ?, ?)`;
    db.query(detailSql, [orderId, book_id, price, duration], (err2) => {
      if (err2) return res.status(500).json({ success: false, message: err2.message });
      res.json({ success: true, message: "Order placed successfully", order_id: orderId });
    });
  });
});

app.listen(3000, () => console.log("Book Rental API running on port 3000"));