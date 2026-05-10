<?php
require('topNav.php');

if (isset($_GET['type']) && $_GET['type'] != ' ') {
  $type = getSafeValue($con, $_GET['type']);
  if ($type == 'status') {
    $operation = getSafeValue($con, $_GET['operation']);
    $id = getSafeValue($con, $_GET['id']);
    if ($operation == 'active') {
      $status = '1';
    } else {
      $status = '0';
    }
    $updateStatusSql = "update books set status='$status' where id='$id'";
    mysqli_query($con, $updateStatusSql);
  }

  if ($type == 'best_seller') {
    $operation = getSafeValue($con, $_GET['operation']);
    $id = getSafeValue($con, $_GET['id']);
    if ($operation == 'active') {
      $bestSeller = '1';
    } else {
      $bestSeller = '0';
    }
    $updateStatusSql = "update books set best_seller='$bestSeller' where id='$id'";
    mysqli_query($con, $updateStatusSql);
  }

  if ($type == 'delete') {
    $id = getSafeValue($con, $_GET['id']);
    $deleteSql = "delete from books where id='$id'";
    mysqli_query($con, $deleteSql);
  }
}

$sql = "select books.*, categories.category from books left join categories on books.category_id=categories.id order by books.name asc";
$res = mysqli_query($con, $sql);
?>

<style>
  /* Enhanced Admin Books Page Styles */
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
  .btn-add-book {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
    padding: 0.5rem 1.2rem;
    border-radius: 2rem;
    font-weight: 600;
    transition: 0.2s;
  }
  .btn-add-book:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(37,99,235,0.3);
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
    white-space: nowrap;
  }
  .admin-table tr:hover td {
    background: #f8fafc;
  }
  .book-thumb {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 0.5rem;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }
  .badge-status {
    display: inline-block;
    padding: 0.25rem 0.6rem;
    border-radius: 2rem;
    font-size: 0.7rem;
    font-weight: 600;
  }
  .badge-active {
    background: #d1fae5;
    color: #065f46;
  }
  .badge-inactive {
    background: #fee2e2;
    color: #b91c1c;
  }
  .btn-table {
    padding: 0.25rem 0.7rem;
    border-radius: 1.5rem;
    font-size: 0.7rem;
    font-weight: 600;
    text-decoration: none;
    margin: 0 0.2rem;
    display: inline-block;
    transition: 0.2s;
  }
  .btn-table:hover {
    transform: translateY(-1px);
  }
  .btn-primary-custom {
    background: #2563eb;
    color: white;
  }
  .btn-success-custom {
    background: #16a34a;
    color: white;
  }
  .btn-danger-custom {
    background: #dc2626;
    color: white;
  }
  .btn-warning-custom {
    background: #f59e0b;
    color: white;
  }
  @media (max-width: 768px) {
    .admin-table th, .admin-table td {
      padding: 0.5rem;
      font-size: 0.75rem;
    }
    .btn-table {
      padding: 0.2rem 0.5rem;
      font-size: 0.65rem;
    }
  }
</style>

<!--Main layout-->
<main>
  <div class="container pt-4">
    <div class="admin-header d-flex justify-content-between align-items-center flex-wrap">
      <h4><i class="fas fa-book me-2"></i> Books Management</h4>
      <a href="manageBooks.php" class="btn btn-add-book text-white">
        <i class="fas fa-plus me-1"></i> Add New Book
      </a>
    </div>

    <div class="table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ISBN</th>
            <th>Category</th>
            <th>Image</th>
            <th>Name</th>
            <th>Author</th>
            <th>MRP</th>
            <th>Security</th>
            <th>Rent</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Status</th>
            <th>Best Seller</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($res)) { ?>
          <tr>
            <td><?php echo htmlspecialchars($row['ISBN']); ?></td>
            <td><?php echo htmlspecialchars($row['category']); ?></td>
            <td><img src="<?php echo BOOK_IMAGE_SITE_PATH . $row['img']; ?>" class="book-thumb" alt="book"></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['author']); ?></td>
            <td>₹<?php echo $row['mrp']; ?></td>
            <td>₹<?php echo $row['security']; ?></td>
            <td>₹<?php echo $row['rent']; ?></td>
            <td>₹<?php echo $row['price']; ?></td>
            <td><?php echo $row['qty']; ?></td>
            <td>
              <?php 
                if ($row['status'] == 1) {
                  echo '<span class="badge-status badge-active"><i class="fas fa-check-circle me-1"></i>Active</span>';
                } else {
                  echo '<span class="badge-status badge-inactive"><i class="fas fa-times-circle me-1"></i>Inactive</span>';
                }
              ?>
            </td>
            <td>
              <?php
                if ($row['best_seller'] == 1) {
                  echo "<a class='btn-table btn-warning-custom' href='?type=best_seller&operation=deactive&id=" . $row['id'] . "'><i class='fas fa-star'></i> Most Viewed</a>";
                } else {
                  echo "<a class='btn-table btn-success-custom' href='?type=best_seller&operation=active&id=" . $row['id'] . "'><i class='fas fa-eye'></i> Normal</a>";
                }
              ?>
            </td>
            <td>
              <a class='btn-table btn-primary-custom' href='manageBooks.php?id=<?php echo $row['id']; ?>'><i class='fas fa-edit'></i> Edit</a>
              <a class='btn-table btn-danger-custom' href='?type=delete&id=<?php echo $row['id']; ?>' onclick="return confirm('Are you sure you want to delete this book?')"><i class='fas fa-trash'></i> Del</a>
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