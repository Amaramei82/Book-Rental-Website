<?php
require('topNav.php');
$res = '';
$categories = '';
$msg = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
  $id = getSafeValue($con, $_GET['id']);
  $sql = mysqli_query($con, "select * from categories where id='$id'");
  $check = mysqli_num_rows($sql);
  if ($check > 0) {
    $row = mysqli_fetch_assoc($sql);
    $categories = $row['category'];
  } else {
    echo "<script>window.location.href='categories.php';</script>";
    exit;
  }
}

if (isset($_POST['submit'])) {
  $category = getSafeValue($con, $_POST['category']);
  $sql = mysqli_query($con, "select * from categories where category='$category'");
  $check = mysqli_num_rows($sql);
  if ($check > 0) {
    if (isset($_GET['id']) && $_GET['id'] != '') {
      $getData = mysqli_fetch_assoc($sql);
      if ($id == $getData['id']) {
      } else {
        $msg = "Category already exist";
      }
    } else {
      $msg = "Category already exist";
    }
  }
  if ($msg == '') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
      $sql = "update categories set category='$category' where id='$id' ";
    } else {
      $sql = "insert into categories(category, status) values('$category', '1')";
    }
    if (mysqli_query($con, $sql)) {
      echo "<script>window.location.href='categories.php';</script>";
      exit;
    } else {
      $res = "Error";
    }
  }
}

?>

<style>
  /* Enhanced Admin Manage Categories Page Styles */
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
  .form-card {
    background: #ffffff;
    border-radius: 1.5rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    padding: 2rem;
    max-width: 600px;
    margin: 0 auto;
  }
  .form-group {
    margin-bottom: 1.5rem;
  }
  .form-group label {
    font-weight: 600;
    margin-bottom: 0.4rem;
    display: block;
    color: #1e293b;
  }
  .form-group input {
    width: 100%;
    padding: 0.7rem 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 0.8rem;
    transition: 0.2s;
    background: #f8fafc;
  }
  .form-group input:focus {
    border-color: #3b82f6;
    outline: none;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
    background: #ffffff;
  }
  .btn-submit {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 2rem;
    font-weight: 600;
    font-size: 1rem;
    color: white;
    cursor: pointer;
    transition: 0.2s;
    width: 100%;
  }
  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(37,99,235,0.3);
  }
  .error-message, .success-message {
    padding: 0.6rem;
    border-radius: 1rem;
    text-align: center;
    margin-bottom: 1rem;
  }
  .error-message {
    background: #fee2e2;
    color: #b91c1c;
  }
  .success-message {
    background: #d1fae5;
    color: #065f46;
  }
  .btn-cancel {
    display: inline-block;
    margin-top: 1rem;
    text-align: center;
    width: 100%;
    color: #64748b;
    text-decoration: none;
  }
  .btn-cancel:hover {
    color: #dc2626;
    text-decoration: underline;
  }
  @media (max-width: 768px) {
    .form-card {
      padding: 1.5rem;
    }
  }
</style>

<main>
  <div class="container pt-4">
    <div class="admin-header">
      <h4><i class="fas fa-tag me-2"></i> <?php echo isset($_GET['id']) ? 'Edit Category' : 'Add New Category'; ?></h4>
    </div>

    <div class="form-card">
      <form method="post">
        <div class="form-group">
          <label>Category Name <span class="text-danger">*</span></label>
          <input type="text" name="category" value="<?php echo htmlspecialchars($categories); ?>" placeholder="e.g., Fiction, Mystery, Biography" required>
        </div>

        <?php if ($msg): ?>
          <div class="error-message"><i class="fas fa-exclamation-triangle me-2"></i><?php echo $msg; ?></div>
        <?php endif; ?>
        <?php if ($res): ?>
          <div class="error-message"><i class="fas fa-exclamation-circle me-2"></i><?php echo $res; ?></div>
        <?php endif; ?>

        <button type="submit" name="submit" class="btn-submit">
          <i class="fas fa-save me-2"></i> <?php echo isset($_GET['id']) ? 'Update Category' : 'Add Category'; ?>
        </button>
        <a href="categories.php" class="btn-cancel"><i class="fas fa-arrow-left me-1"></i> Back to Categories</a>
      </form>
    </div>
  </div>
</main>

<!-- MDB -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<!-- Custom scripts -->
<script type="text/javascript" src="js/admin.js"></script>
</body>
</html>