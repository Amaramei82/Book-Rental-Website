<?php
require('topNav.php');
$category_id = '';
$ISBN = '';
$name = '';
$author = '';
$mrp = '';
$security = '';
$rent = '';
$qty = '';
$img = '';
$description = '';
$short_desc = '';
$error = '';
$msg = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
  $id = getSafeValue($con, $_GET['id']);
  $sql = mysqli_query($con, "select * from books where id='$id'");
  $check = mysqli_num_rows($sql);
  if ($check > 0) {
    $row = mysqli_fetch_assoc($sql);
    $category_id = $row['category_id'];
    $ISBN = $row['ISBN'];
    $name = $row['name'];
    //      $img = $row['img'];
    $author = $row['author'];
    $mrp = $row['mrp'];
    $security = $row['security'];
    $rent = $row['rent'];
    $qty = $row['qty'];
    $short_desc = $row['short_desc'];
    $description = $row['description'];
  } else {
    echo "<script>window.location.href='books.php';</script>";
    exit;
  }
}

if (isset($_POST['submit'])) {
  $category_id = getSafeValue($con, $_POST['category_id']);
  $ISBN = getSafeValue($con, $_POST['ISBN']);
  $name = getSafeValue($con, $_POST['name']);
  $img = getSafeValue($con, $_POST['img']);
  $author = getSafeValue($con, $_POST['author']);
  $mrp = getSafeValue($con, $_POST['mrp']);
  $security = getSafeValue($con, $_POST['security']);
  $rent = getSafeValue($con, $_POST['rent']);
  $qty = getSafeValue($con, $_POST['qty']);
  $short_desc = getSafeValue($con, $_POST['short_desc']);
  $description = getSafeValue($con, $_POST['description']);
  $sql = mysqli_query($con, "select * from books where name='$name'");
  $check = mysqli_num_rows($sql);
  if ($check > 0) {
    if (isset($_GET['id']) && $_GET['id'] != '') {
      $getData = mysqli_fetch_assoc($sql);
      if ($id == $getData['id']) {
      } else {
        $msg = "Book already exist";
      }
    } else {
      $msg = "Book already exist";
    }
  }

  if ($msg == '') {
    if (isset($_GET['id']) && $_GET['id'] != '') {
      $sql = "update books set category_id='$category_id', ISBN='$ISBN', name='$name', author='$author', mrp='$mrp',
                 security='$security', rent='$rent', qty='$qty', short_desc='$short_desc', description='$description',
                 where id='$id' ";
    } else {
      $img = rand(1111111111, 2147483647) . '_' . $_FILES['img']['name'];
      move_uploaded_file($_FILES['img']['tmp_name'], BOOK_IMAGE_SERVER_PATH . $img);
      $sql = "insert into books(category_id, ISBN, name, author, mrp, security, rent, qty, short_desc, description,
                                    status, img)
                values('$category_id', '$ISBN', '$name', '$author', '$mrp', '$security', '$rent', '$qty', '$short_desc',
                       '$description', '1', '$img')";
    }
    if (mysqli_query($con, $sql)) {
      echo "<script>window.location.href='books.php';</script>";
      exit;
    } else {
      $error = "Error";
    }
  }
}
?>

<style>
  /* Enhanced Admin Manage Books Page Styles */
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
    margin-bottom: 2rem;
  }
  .form-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }
  .form-group {
    flex: 1;
    min-width: 200px;
  }
  .form-group.full-width {
    flex: 1 1 100%;
  }
  .form-group label {
    font-weight: 600;
    margin-bottom: 0.4rem;
    display: block;
    color: #1e293b;
  }
  .form-group input, 
  .form-group select, 
  .form-group textarea {
    width: 100%;
    padding: 0.7rem 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 0.8rem;
    transition: 0.2s;
    background: #f8fafc;
  }
  .form-group input:focus, 
  .form-group select:focus, 
  .form-group textarea:focus {
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
  @media (max-width: 768px) {
    .form-card {
      padding: 1.2rem;
    }
    .form-grid {
      gap: 1rem;
    }
  }
</style>

<main>
  <div class="container pt-4">
    <div class="admin-header">
      <h4><i class="fas fa-book me-2"></i> <?php echo isset($_GET['id']) ? 'Edit Book' : 'Add New Book'; ?></h4>
    </div>

    <div class="form-card">
      <form method="post" enctype="multipart/form-data">
        <div class="form-grid">
          <div class="form-group">
            <label>ISBN <span class="text-danger">*</span></label>
            <input type="text" name="ISBN" value="<?php echo htmlspecialchars($ISBN); ?>" required>
          </div>
          <div class="form-group">
            <label>Category <span class="text-danger">*</span></label>
            <select name="category_id" required>
              <option value="">Select Category</option>
              <?php
              $categorySql = mysqli_query($con, "select id, category from categories order by category asc");
              while ($row = mysqli_fetch_assoc($categorySql)) {
                $selected = ($row['id'] == $category_id) ? 'selected' : '';
                echo "<option value='{$row['id']}' $selected>" . htmlspecialchars($row['category']) . "</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="form-grid">
          <div class="form-group">
            <label>Book Name <span class="text-danger">*</span></label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
          </div>
          <div class="form-group">
            <label>Author <span class="text-danger">*</span></label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($author); ?>" required>
          </div>
        </div>

        <div class="form-grid">
          <div class="form-group">
            <label>MRP (₹) <span class="text-danger">*</span></label>
            <input type="number" name="mrp" value="<?php echo $mrp; ?>" required>
          </div>
          <div class="form-group">
            <label>Security Deposit (₹) <span class="text-danger">*</span></label>
            <input type="number" name="security" value="<?php echo $security; ?>" required>
          </div>
          <div class="form-group">
            <label>Rent per Day (₹) <span class="text-danger">*</span></label>
            <input type="number" name="rent" value="<?php echo $rent; ?>" required>
          </div>
          <div class="form-group">
            <label>Quantity <span class="text-danger">*</span></label>
            <input type="number" name="qty" value="<?php echo $qty; ?>" required>
          </div>
        </div>

        <div class="form-grid">
          <div class="form-group">
            <label>Book Image <?php if(!isset($_GET['id'])) echo '<span class="text-danger">*</span>'; ?></label>
            <input type="file" name="img" <?php if(!isset($_GET['id'])) echo 'required'; ?>>
            <?php if(isset($_GET['id']) && $img): ?>
              <small class="text-muted">Leave empty to keep current image</small>
            <?php endif; ?>
          </div>
        </div>

        <div class="form-group full-width">
          <label>Short Description <span class="text-danger">*</span></label>
          <textarea name="short_desc" rows="3" required><?php echo htmlspecialchars($short_desc); ?></textarea>
        </div>

        <div class="form-group full-width">
          <label>Full Description <span class="text-danger">*</span></label>
          <textarea name="description" rows="5" required><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <?php if ($msg): ?>
          <div class="error-message"><i class="fas fa-exclamation-triangle me-2"></i><?php echo $msg; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
          <div class="error-message"><i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="text-center mt-4">
          <button type="submit" name="submit" class="btn-submit">
            <i class="fas fa-save me-2"></i> <?php echo isset($_GET['id']) ? 'Update Book' : 'Add Book'; ?>
          </button>
          <a href="books.php" class="btn btn-secondary ms-2" style="border-radius: 2rem;">Cancel</a>
        </div>
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