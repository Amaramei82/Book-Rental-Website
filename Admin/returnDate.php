<?php require('topNav.php'); ?>
<?php
if (isset($_POST['status_id'])) {
    $order_Id = $_POST['orderId'];
    $status_id = $_POST['status_id'];
    if ($status_id === 6 || $status_id === 4) {
        $qtyRes = mysqli_query($con, "SELECT books.qty,books.id FROM orders
                                            JOIN order_detail ON orders.id=order_detail.order_id
                                            JOIN books ON order_detail.book_id=books.id
                                            where order_detail.order_id='$order_Id'");
        $qtyRow = mysqli_fetch_assoc($qtyRes);
        $newQty = $qtyRow['qty'] + 1;
        $bookId = $qtyRow['id'];
        mysqli_query($con, "UPDATE books SET qty = '$newQty' WHERE id='$bookId';");
    }

    mysqli_query($con, "update orders set order_status='$status_id' where id='$order_Id'");
}

?>
<style>
  /* Enhanced Return/Orders Page Styles */
  .admin-header {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
  }
  .admin-header h4 {
    color: white;
    margin: 0;
    font-weight: 700;
  }
  .table-wrapper {
    background: #ffffff;
    border-radius: 1.5rem;
    padding: 1rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    overflow-x: auto;
  }
  .admin-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.85rem;
  }
  .admin-table thead tr {
    background: #f8fafc;
  }
  .admin-table th {
    padding: 1rem 0.8rem;
    font-weight: 700;
    color: #1e293b;
    border-bottom: 2px solid #eef2ff;
    white-space: nowrap;
  }
  .admin-table td {
    padding: 0.8rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
  }
  .admin-table tr:hover td {
    background: #f8fafc;
  }
  .badge-status {
    display: inline-block;
    padding: 0.25rem 0.7rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
  }
  .badge-return {
    background: #fed7aa;
    color: #9a3412;
  }
  /* Mobile card view */
  .orders-cards {
    display: none;
  }
  .order-card {
    background: white;
    border-radius: 1.2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    border: 1px solid #eef2ff;
    padding: 1rem;
    margin-bottom: 1rem;
  }
  .order-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #eef2ff;
    flex-wrap: wrap;
    gap: 0.5rem;
  }
  .order-id {
    font-weight: 800;
    font-size: 1rem;
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
  @media (max-width: 768px) {
    .admin-table {
      display: none;
    }
    .orders-cards {
      display: block;
    }
  }
  /* Dark mode compatibility */
  body.dark-mode .table-wrapper {
    background: #1e293b;
  }
  body.dark-mode .admin-table th {
    background: #0f172a;
    color: #e2e8f0;
    border-bottom-color: #334155;
  }
  body.dark-mode .admin-table td {
    color: #cbd5e1;
    border-bottom-color: #334155;
  }
  body.dark-mode .admin-table tr:hover td {
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
</style>

<!--Main layout-->
<main>
  <div class="container pt-4">
    <div class="admin-header">
      <h4><i class="fas fa-calendar-alt me-2"></i> Return / Order Status</h4>
    </div>

    <div class="table-wrapper">
      <!-- Desktop Table -->
      <table class="admin-table">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Return Date</th>
            <th>Book Name</th>
            <th>Price</th>
            <th>Duration</th>
            <th>Address</th>
            <th>Order Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT orders.*, books.name, order_status.status_name 
                  FROM orders
                  JOIN order_detail ON orders.id = order_detail.order_id
                  JOIN books ON order_detail.book_id = books.id
                  JOIN order_status ON orders.order_status = order_status.id
                  WHERE order_status.status_name LIKE '%Cancelled%'
                  ORDER BY orders.date DESC";
          $res=mysqli_query($con,$sql);
          while ($row = mysqli_fetch_assoc($res)) { ?>
          <tr>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo date('d-m-Y H:i', strtotime($row['date'])); ?></td>
            <td><span class="badge-status badge-return"><?php echo "haha"; ?></span></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td>₹<?php echo $row['total']; ?></td>
            <td><?php echo $row['duration']; ?> days</td>
            <td><?php echo htmlspecialchars($row['address'] . ', ' . $row['address2']); ?></td>
            <td><span class="badge-status badge-return"><?php echo $row['status_name']; ?></span></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Mobile cards (same data) -->
    <div class="orders-cards">
      <?php
      $res2 = mysqli_query($con, $sql); // re-run same query
      while ($row = mysqli_fetch_assoc($res2)) { ?>
      <div class="order-card">
        <div class="order-card-header">
          <span class="order-id"><i class="fas fa-hashtag"></i> Order #<?php echo $row['id']; ?></span>
          <span class="order-date"><i class="far fa-calendar-alt"></i> <?php echo date('d-m-Y H:i', strtotime($row['date'])); ?></span>
        </div>
        <div class="order-detail-row">
          <span class="order-detail-label">Return Date:</span>
          <span class="order-detail-value"><span class="badge-status badge-return">haha</span></span>
        </div>
        <div class="order-detail-row">
          <span class="order-detail-label">Book:</span>
          <span class="order-detail-value"><?php echo htmlspecialchars($row['name']); ?></span>
        </div>
        <div class="order-detail-row">
          <span class="order-detail-label">Price:</span>
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
          <span class="order-detail-label">Order Status:</span>
          <span class="order-detail-value"><span class="badge-status badge-return"><?php echo $row['status_name']; ?></span></span>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</main>

<!-- MDB -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<!-- Custom scripts -->
<script type="text/javascript" src="js/admin.js"></script>
</body>
</html>