<?php require('header.php') ?>
<?php
if (!isset($_SESSION['USER_LOGIN'])) {
    echo "<script>window.top.location='SignIn.php';</script>";
    exit;
}
if (isset($_GET['type']) && $_GET['type'] != ' ') {
    $type = getSafeValue($con, $_GET['type']);
    if ($type == 'cancel') {
        $id = getSafeValue($con, $_GET['id']);
        $deleteSql = "update orders set order_status='4' where id='$id'";
        mysqli_query($con, $deleteSql);

        $qtyRes = mysqli_query($con, "SELECT books.qty,books.id FROM orders
                                            JOIN order_detail ON orders.id=order_detail.order_id
                                            JOIN books ON order_detail.book_id=books.id
                                            where order_detail.order_id='$id'");
        $qtyRow = mysqli_fetch_assoc($qtyRes);
        $newQty = $qtyRow['qty'] + 1;
        $bookId = $qtyRow['id'];
        mysqli_query($con, "UPDATE books SET qty = '$newQty' WHERE id='$bookId';");
    }
}
?>
<script>
document.title = "My Orders | Book Rental";
</script>

<style>
  /* Enhanced My Orders Page Styles */
  .orders-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }
  .page-header {
    text-align: center;
    margin-bottom: 2.5rem;
  }
  .page-header h1 {
    font-size: 2.2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #1e293b, #2563eb);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    display: inline-block;
  }
  /* Desktop table styling */
  .orders-table {
    background: #ffffff;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    border: 1px solid #eef2ff;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }
  .orders-table thead tr {
    background: linear-gradient(135deg, #f8fafc, #ffffff);
    border-bottom: 2px solid #eef2ff;
  }
  .orders-table th {
    padding: 1rem 0.8rem;
    font-weight: 700;
    color: #1e293b;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #eef2ff;
  }
  .orders-table td {
    padding: 1rem 0.8rem;
    vertical-align: middle;
    color: #334155;
    border-bottom: 1px solid #f1f5f9;
  }
  .orders-table tr:last-child td {
    border-bottom: none;
  }
  .orders-table tr:hover td {
    background: #f8fafc;
  }
  .badge-status {
    display: inline-block;
    padding: 0.3rem 0.8rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-align: center;
  }
  .badge-success {
    background: #d1fae5;
    color: #065f46;
  }
  .badge-pending {
    background: #fed7aa;
    color: #9a3412;
  }
  .badge-cancelled {
    background: #fee2e2;
    color: #b91c1c;
  }
  .btn-cancel {
    background: #ef4444;
    border: none;
    padding: 0.3rem 1rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
    transition: 0.2s;
    text-decoration: none;
    display: inline-block;
  }
  .btn-cancel:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(239,68,68,0.2);
    color: white;
  }
  /* Mobile card view (hide table on small screens) */
  .orders-cards {
    display: none;
  }
  .order-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    border: 1px solid #eef2ff;
    padding: 1.2rem;
    margin-bottom: 1rem;
    transition: 0.2s;
  }
  .order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 20px rgba(0,0,0,0.08);
  }
  .order-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #eef2ff;
    margin-bottom: 0.8rem;
    flex-wrap: wrap;
    gap: 0.5rem;
  }
  .order-id {
    font-weight: 800;
    color: #2563eb;
  }
  .order-date {
    font-size: 0.8rem;
    color: #64748b;
  }
  .order-detail-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px dashed #f1f5f9;
  }
  .order-detail-label {
    font-weight: 600;
    color: #475569;
  }
  .order-detail-value {
    color: #1e293b;
    text-align: right;
  }
  .order-card-actions {
    margin-top: 1rem;
    text-align: right;
  }
  @media (max-width: 768px) {
    .orders-table {
      display: none;
    }
    .orders-cards {
      display: block;
    }
  }
  /* Dark mode */
  body.dark-mode .orders-table {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .orders-table th {
    background: #0f172a;
    color: #e2e8f0;
    border-bottom-color: #334155;
  }
  body.dark-mode .orders-table td {
    color: #cbd5e1;
    border-bottom-color: #334155;
  }
  body.dark-mode .orders-table tr:hover td {
    background: #0f172a;
  }
  body.dark-mode .order-card {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .order-card-header {
    border-bottom-color: #334155;
  }
  body.dark-mode .order-detail-label {
    color: #94a3b8;
  }
  body.dark-mode .order-detail-value {
    color: #e2e8f0;
  }
  /* Scroll & dark buttons preserved but keep them in footer */
  #scrollBtn {
    position: fixed;
    bottom: 80px;
    right: 20px;
    z-index: 99;
  }
  #ScrollUpBtn {
    background: #2563eb;
    border: none;
    border-radius: 50px;
    width: 44px;
    height: 44px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: 0.2s;
    display: none;
  }
  #ScrollUpBtn:hover {
    background: #1d4ed8;
    transform: translateY(-3px);
  }
  #dark-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 99;
  }
  #dark-btn button {
    background: #1e293b;
    border: none;
    border-radius: 50px;
    width: 44px;
    height: 44px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    cursor: pointer;
    transition: 0.2s;
  }
  #dark-btn button:hover {
    transform: scale(1.05);
    background: #0f172a;
  }
  body.dark-mode #dark-btn button {
    background: #f1f5f9;
  }
  body.dark-mode #dark-btn button i {
    color: #0f172a;
  }
</style>

<div class="orders-wrapper">
  <div class="page-header">
    <h1><i class="fas fa-shopping-bag me-2"></i> My Orders</h1>
  </div>

  <?php
  $userId = $_SESSION['USER_ID'];
  $res = mysqli_query($con, "select orders.*,name,status_name from orders
                              JOIN order_detail ON orders.id=order_detail.order_id
                              JOIN books ON order_detail.book_id=books.id
                              JOIN order_status ON orders.order_status=order_status.id
                              where user_id = $userId order by orders.id desc");
  if (mysqli_num_rows($res) > 0) {
  ?>

  <!-- Desktop Table View -->
  <div class="table-responsive">
    <table class="orders-table">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Order Date</th>
          <th>Book Name</th>
          <th>Price</th>
          <th>Duration</th>
          <th>Address</th>
          <th>Payment Method</th>
          <th>Payment Status</th>
          <th>Order Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)) {
          $statusClass = '';
          if (strtolower($row['status_name']) == 'cancelled') $statusClass = 'badge-cancelled';
          elseif (strtolower($row['payment_status']) == 'pending') $statusClass = 'badge-pending';
          else $statusClass = 'badge-success';
        ?>
        <tr>
          <td>#<?php echo $row['id']; ?></td>
          <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td>₹<?php echo $row['total']; ?></td>
          <td><?php echo $row['duration']; ?> days</td>
          <td><?php echo htmlspecialchars($row['address'] . ', ' . $row['address2']); ?></td>
          <td><?php echo $row['payment_method']; ?></td>
          <td><span class="badge-status <?php echo $statusClass; ?>"><?php echo $row['payment_status']; ?></span></td>
          <td><span class="badge-status <?php echo $statusClass; ?>"><?php echo $row['status_name']; ?></span></td>
          <td>
            <?php if ($row['status_name'] !== 'Cancelled' && $row['status_name'] !== 'Returned') { ?>
              <a class="btn-cancel" href="?type=cancel&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to cancel this order?');">Cancel</a>
            <?php } else { echo '—'; } ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <!-- Mobile Cards View -->
  <div class="orders-cards">
    <?php 
    // Reset result pointer for mobile cards
    $res2 = mysqli_query($con, "select orders.*,name,status_name from orders
                                JOIN order_detail ON orders.id=order_detail.order_id
                                JOIN books ON order_detail.book_id=books.id
                                JOIN order_status ON orders.order_status=order_status.id
                                where user_id = $userId order by orders.id desc");
    while ($row = mysqli_fetch_assoc($res2)) { 
      $statusClass = '';
      if (strtolower($row['status_name']) == 'cancelled') $statusClass = 'badge-cancelled';
      elseif (strtolower($row['payment_status']) == 'pending') $statusClass = 'badge-pending';
      else $statusClass = 'badge-success';
    ?>
    <div class="order-card">
      <div class="order-card-header">
        <span class="order-id"><i class="fas fa-hashtag"></i> Order #<?php echo $row['id']; ?></span>
        <span class="order-date"><i class="far fa-calendar-alt"></i> <?php echo date('d-m-Y', strtotime($row['date'])); ?></span>
      </div>
      <div class="order-detail-row">
        <span class="order-detail-label">Book:</span>
        <span class="order-detail-value"><?php echo htmlspecialchars($row['name']); ?></span>
      </div>
      <div class="order-detail-row">
        <span class="order-detail-label">Total:</span>
        <span class="order-detail-value">₹<?php echo $row['total']; ?></span>
      </div>
      <div class="order-detail-row">
        <span class="order-detail-label">Duration:</span>
        <span class="order-detail-value"><?php echo $row['duration']; ?> days</span>
      </div>
      <div class="order-detail-row">
        <span class="order-detail-label">Address:</span>
        <span class="order-detail-value"><?php echo htmlspecialchars($row['address'] . ', ' . $row['address2']); ?></span>
      </div>
      <div class="order-detail-row">
        <span class="order-detail-label">Payment:</span>
        <span class="order-detail-value"><?php echo $row['payment_method']; ?> | <span class="badge-status <?php echo $statusClass; ?>"><?php echo $row['payment_status']; ?></span></span>
      </div>
      <div class="order-detail-row">
        <span class="order-detail-label">Order Status:</span>
        <span class="order-detail-value"><span class="badge-status <?php echo $statusClass; ?>"><?php echo $row['status_name']; ?></span></span>
      </div>
      <div class="order-card-actions">
        <?php if ($row['status_name'] !== 'Cancelled' && $row['status_name'] !== 'Returned') { ?>
          <a class="btn-cancel" href="?type=cancel&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to cancel this order?');">Cancel Order</a>
        <?php } else { echo '<span class="text-muted">No action</span>'; } ?>
      </div>
    </div>
    <?php } ?>
  </div>

  <?php } else { ?>
    <div class="text-center py-5" style="background: white; border-radius: 2rem; box-shadow: 0 8px 20px rgba(0,0,0,0.05);">
      <i class="fas fa-box-open fa-4x mb-3" style="color: #94a3b8;"></i>
      <h4>No orders yet</h4>
      <p class="text-muted">Start exploring our collection and place your first order!</p>
      <a href="index.php" class="btn btn-primary rounded-pill px-4">Browse Books</a>
    </div>
  <?php } ?>
</div>

<!-- Scroll Up Button (preserved) -->
<div id="scrollBtn">
  <button onclick="topFunction()" id="ScrollUpBtn" title="Go to top">
    <i class="fas fa-chevron-up text-white"></i>
  </button>
</div>

<!-- Dark Mode Toggle (preserved) -->
<div id="dark-btn">
  <button onclick="DarkMode()" title="Toggle Light/Dark Mode">
    <i class="fas fa-adjust fa-lg"></i>
  </button>
</div>

<script>
// Scroll up functionality
let mybutton = document.getElementById("ScrollUpBtn");
window.onscroll = function() { scrollFunction(); };
function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
// Dark Mode
function DarkMode() {
  let element = document.body;
  element.classList.toggle("dark-mode");
}
</script>

<?php require('footer.php') ?>