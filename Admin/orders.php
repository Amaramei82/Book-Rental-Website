<?php require('topNav.php'); 
require('api_check.php');
?>
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
  /* Enhanced Admin Orders Page Styles */
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
  .status-select {
    padding: 0.4rem 0.6rem;
    border-radius: 0.6rem;
    border: 1px solid #cbd5e1;
    font-size: 0.8rem;
    width: 140px;
  }
  .btn-submit-status {
    background: #2563eb;
    border: none;
    padding: 0.3rem 0.8rem;
    border-radius: 1.5rem;
    font-size: 0.7rem;
    font-weight: 600;
    color: white;
    margin-top: 0.3rem;
    transition: 0.2s;
  }
  .btn-submit-status:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
  }
  /* Mobile cards view */
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
  .card-status-form {
    margin-top: 0.8rem;
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: wrap;
  }
  @media (max-width: 768px) {
    .admin-table {
      display: none;
    }
    .orders-cards {
      display: block;
    }
  }
  /* Dark mode compatibility (optional, retains existing) */
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
      <h4><i class="fas fa-shopping-cart me-2"></i> Orders Management</h4>
    </div>

    <div class="table-wrapper">
      <!-- Desktop Table View -->
      <table class="admin-table">
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
            <th>Change Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $res = mysqli_query($con, "select orders.*,name,status_name from orders
                                      JOIN order_detail ON orders.id=order_detail.order_id
                                      JOIN books ON order_detail.book_id=books.id
                                      JOIN order_status ON orders.order_status=order_status.id order by date desc ");
          while ($row = mysqli_fetch_assoc($res)) {
            $orderId = $row['id'];
            $paymentStatusClass = ($row['payment_status'] == 'success') ? 'badge-success' : 'badge-pending';
            $orderStatusClass = '';
            if (strtolower($row['status_name']) == 'cancelled') $orderStatusClass = 'badge-cancelled';
            elseif (strtolower($row['status_name']) == 'returned') $orderStatusClass = 'badge-cancelled';
            else $orderStatusClass = 'badge-success';
          ?>
          <tr>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo date('d-m-Y H:i', strtotime($row['date'])); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td>₹<?php echo $row['total']; ?></td>
            <td><?php echo $row['duration']; ?> days</td>
            <td><?php echo htmlspecialchars($row['address'] . ', ' . $row['address2']); ?></td>
            <td><?php echo $row['payment_method']; ?></td>
            <td><span class="badge-status <?php echo $paymentStatusClass; ?>"><?php echo $row['payment_status']; ?></span></td>
            <td><span class="badge-status <?php echo $orderStatusClass; ?>"><?php echo $row['status_name']; ?></span></td>
            <td>
              <?php
              $statusName = $row['status_name'];
              if ($statusName === 'Returned' || $statusName === 'Cancelled') {
                echo '<span class="text-muted">—</span>';
              } else {
              ?>
                <form method="post" style="display: inline-block;">
                  <input type="hidden" name="orderId" value="<?php echo $orderId; ?>">
                  <select name="status_id" class="status-select">
                    <option value="">Select Status</option>
                    <?php
                    $sql = mysqli_query($con, "select * from order_status order by status_name");
                    while ($statusRow = mysqli_fetch_assoc($sql)) {
                      echo "<option value='" . $statusRow['id'] . "'>" . $statusRow['status_name'] . "</option>";
                    }
                    ?>
                  </select>
                  <button type="submit" class="btn-submit-status">Update</button>
                </form>
              <?php } ?>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Mobile Cards View (same data, restructured) -->
    <div class="orders-cards">
      <?php
      // Reset query result for mobile cards
      $res2 = mysqli_query($con, "select orders.*,name,status_name from orders
                                    JOIN order_detail ON orders.id=order_detail.order_id
                                    JOIN books ON order_detail.book_id=books.id
                                    JOIN order_status ON orders.order_status=order_status.id order by date desc ");
      while ($row = mysqli_fetch_assoc($res2)) {
        $orderId = $row['id'];
        $paymentStatusClass = ($row['payment_status'] == 'success') ? 'badge-success' : 'badge-pending';
        $orderStatusClass = '';
        if (strtolower($row['status_name']) == 'cancelled') $orderStatusClass = 'badge-cancelled';
        elseif (strtolower($row['status_name']) == 'returned') $orderStatusClass = 'badge-cancelled';
        else $orderStatusClass = 'badge-success';
      ?>
      <div class="order-card">
        <div class="order-card-header">
          <span class="order-id"><i class="fas fa-hashtag"></i> Order #<?php echo $orderId; ?></span>
          <span class="order-date"><i class="far fa-calendar-alt"></i> <?php echo date('d-m-Y H:i', strtotime($row['date'])); ?></span>
        </div>
        <div class="order-detail-row">
          <span class="order-detail-label">Book:</span>
          <span class="order-detail-value"><?php echo htmlspecialchars($row['name']); ?></span>
        </div>
        <div class="order-detail-row">
          <span class="order-detail-label">Amount:</span>
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
          <span class="order-detail-value"><?php echo $row['payment_method']; ?> | <span class="badge-status <?php echo $paymentStatusClass; ?>"><?php echo $row['payment_status']; ?></span></span>
        </div>
        <div class="order-detail-row">
          <span class="order-detail-label">Order Status:</span>
          <span class="order-detail-value"><span class="badge-status <?php echo $orderStatusClass; ?>"><?php echo $row['status_name']; ?></span></span>
        </div>
        <?php if ($row['status_name'] !== 'Returned' && $row['status_name'] !== 'Cancelled') { ?>
          <form method="post" class="card-status-form">
            <input type="hidden" name="orderId" value="<?php echo $orderId; ?>">
            <select name="status_id" class="status-select">
              <option value="">Change Status</option>
              <?php
              $sql = mysqli_query($con, "select * from order_status order by status_name");
              while ($statusRow = mysqli_fetch_assoc($sql)) {
                echo "<option value='" . $statusRow['id'] . "'>" . $statusRow['status_name'] . "</option>";
              }
              ?>
            </select>
            <button type="submit" class="btn-submit-status">Update</button>
          </form>
        <?php } else { ?>
          <div class="text-muted mt-2">No action available</div>
        <?php } ?>
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