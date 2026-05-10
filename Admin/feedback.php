<?php
require('topNav.php');

if (isset($_GET['type']) && $_GET['type'] != ' ') {
  $type = getSafeValue($con, $_GET['type']);

  if ($type == 'delete') {
    $id = getSafeValue($con, $_GET['id']);
    $deleteSql = "delete from contact_us where id='$id'";
    mysqli_query($con, $deleteSql);
  }
}

$sql = "select * from contact_us order by id desc";
$res = mysqli_query($con, $sql);
?>

<style>
  /* Enhanced Admin Feedback Page Styles */
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
  .message-preview {
    max-width: 250px;
    white-space: normal;
    word-break: break-word;
  }
  .btn-table {
    padding: 0.3rem 0.8rem;
    border-radius: 1.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    margin: 0 0.2rem;
    display: inline-block;
    transition: 0.2s;
  }
  .btn-table:hover {
    transform: translateY(-1px);
  }
  .btn-danger-custom {
    background: #dc2626;
    color: white;
  }
  @media (max-width: 768px) {
    .admin-table th, .admin-table td {
      padding: 0.5rem;
      font-size: 0.75rem;
    }
    .message-preview {
      max-width: 150px;
    }
  }
</style>

<!--Main layout-->
<main>
  <div class="container pt-4">
    <div class="admin-header">
      <h4><i class="fas fa-comment-dots me-2"></i> Customer Feedback</h4>
    </div>

    <div class="table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Message</th>
            <th>Date</th>
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
            <td class="message-preview"><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
            <td><?php echo date('d-m-Y H:i', strtotime($row['date'])); ?></td>
            <td>
              <a class='btn-table btn-danger-custom' href='?type=delete&id=<?php echo $row['id']; ?>' onclick="return confirm('Are you sure you want to delete this feedback?')">
                <i class='fas fa-trash'></i> Delete
              </a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<!-- MDB -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<!-- Custom scripts -->
<script type="text/javascript" src="js/admin.js"></script>
</body>
</html>