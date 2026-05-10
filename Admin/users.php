<?php
require('topNav.php');

if (isset($_GET['type']) && $_GET['type'] != ' ') {
  $type = getSafeValue($con, $_GET['type']);

  if ($type == 'delete') {
    $id = getSafeValue($con, $_GET['id']);
    $deleteSql = "delete from users where id='$id'";
    mysqli_query($con, $deleteSql);
  }
}

$sql = "select * from users order by id desc";
$res = mysqli_query($con, $sql);
?>

<style>
  /* Enhanced Admin Users Page Styles */
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
    border-radius: 1rem;
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
  .btn-delete {
    background: #dc2626;
    color: white;
    border: none;
    padding: 0.3rem 0.8rem;
    border-radius: 1.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s;
    display: inline-block;
  }
  .btn-delete:hover {
    background: #b91c1c;
    transform: translateY(-1px);
    color: white;
  }
  /* Mobile cards view */
  .users-cards {
    display: none;
  }
  .user-card {
    background: white;
    border-radius: 1.2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    border: 1px solid #eef2ff;
    padding: 1rem;
    margin-bottom: 1rem;
  }
  .user-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #eef2ff;
    flex-wrap: wrap;
    gap: 0.5rem;
  }
  .user-id {
    font-weight: 800;
    font-size: 1rem;
    color: #2563eb;
  }
  .user-detail-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px dashed #f1f5f9;
  }
  .user-detail-label {
    font-weight: 600;
    color: #475569;
  }
  .user-detail-value {
    color: #1e293b;
    text-align: right;
  }
  .card-actions {
    margin-top: 0.8rem;
    text-align: right;
  }
  @media (max-width: 768px) {
    .admin-table {
      display: none;
    }
    .users-cards {
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
  body.dark-mode .user-card {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .user-card-header {
    border-bottom-color: #334155;
  }
  body.dark-mode .user-detail-label {
    color: #94a3b8;
  }
  body.dark-mode .user-detail-value {
    color: #e2e8f0;
  }
</style>

<!--Main layout-->
<main>
  <div class="container pt-4">
    <div class="admin-header">
      <h4><i class="fas fa-users me-2"></i> Registered Users</h4>
    </div>

    <div class="table-wrapper">
      <!-- Desktop Table View -->
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Date of Joining</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($res)) { ?>
          <tr>
            <td>#<?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['mobile']); ?></td>
            <td><?php echo date('d-m-Y H:i', strtotime($row['doj'])); ?></td>
            <td>
              <a class="btn-delete" href="?type=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">
                <i class="fas fa-trash me-1"></i> Delete
              </a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Mobile Cards View (same data) -->
    <div class="users-cards">
      <?php
      // Re-run query for mobile cards (or reset pointer, but simple re-run is fine)
      $res2 = mysqli_query($con, "select * from users order by id desc");
      while ($row = mysqli_fetch_assoc($res2)) { ?>
      <div class="user-card">
        <div class="user-card-header">
          <span class="user-id"><i class="fas fa-hashtag"></i> User #<?php echo $row['id']; ?></span>
        </div>
        <div class="user-detail-row">
          <span class="user-detail-label">Name:</span>
          <span class="user-detail-value"><?php echo htmlspecialchars($row['name']); ?></span>
        </div>
        <div class="user-detail-row">
          <span class="user-detail-label">Email:</span>
          <span class="user-detail-value"><?php echo htmlspecialchars($row['email']); ?></span>
        </div>
        <div class="user-detail-row">
          <span class="user-detail-label">Mobile:</span>
          <span class="user-detail-value"><?php echo htmlspecialchars($row['mobile']); ?></span>
        </div>
        <div class="user-detail-row">
          <span class="user-detail-label">Joined:</span>
          <span class="user-detail-value"><?php echo date('d-m-Y H:i', strtotime($row['doj'])); ?></span>
        </div>
        <div class="card-actions">
          <a class="btn-delete" href="?type=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">
            <i class="fas fa-trash me-1"></i> Delete
          </a>
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