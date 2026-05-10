<?php require('header.php') ?>
<?php
$bookId = '';
if (isset($_GET['id'])) {
    $bookId = mysqli_real_escape_string($con, $_GET['id']);
}
$getProduct = getProduct($con, '', '', $bookId);

if (isset($_GET['submit'])) {
    $duration = getSafeValue($con, $_GET['duration']);
    $id = getSafeValue($con, $_GET['bookId']);
    $_SESSION['BeforeCheckoutLogin'] = 'checkout.php?id=' . $id . '&duration=' . $duration;
?>
<script>
window.top.location = "checkout.php?id=<?php echo $id ?>&duration=<?php echo $duration ?>";
</script>
<?php
}
?>
<script>
document.title = "<?php echo $getProduct['0']['name'] ?> | Book Rental";
</script>

<style>
  /* Enhanced Book Detail Page Styles */
  .book-detail-wrapper {
    max-width: 1280px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
  }
  .book-cover {
    background: #f8fafc;
    border-radius: 1.5rem;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    transition: transform 0.2s;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .book-cover img {
    max-width: 100%;
    height: auto;
    border-radius: 1rem;
    object-fit: contain;
  }
  .book-cover:hover {
    transform: translateY(-5px);
  }
  .book-info-card {
    background: white;
    border-radius: 1.5rem;
    padding: 1.8rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    height: 100%;
  }
  .book-title {
    font-size: 2rem;
    font-weight: 800;
    letter-spacing: -0.02em;
    background: linear-gradient(135deg, #1e293b, #2563eb);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    margin-bottom: 0.5rem;
  }
  .book-meta {
    margin: 1rem 0;
    padding: 0.75rem 0;
    border-top: 1px solid #eef2ff;
    border-bottom: 1px solid #eef2ff;
  }
  .price-tag {
    font-size: 1.8rem;
    font-weight: 800;
    color: #2563eb;
    display: inline-flex;
    align-items: baseline;
    gap: 0.5rem;
  }
  .price-tag small {
    font-size: 1rem;
    font-weight: 500;
    color: #475569;
  }
  .btn-rent {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
    padding: 0.7rem 1.8rem;
    border-radius: 2rem;
    font-weight: 600;
    font-size: 1rem;
    color: white;
    transition: 0.2s;
    margin: 1rem 0;
  }
  .btn-rent:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37,99,235,0.3);
  }
  .out-of-stock {
    background: #fee2e2;
    color: #b91c1c;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    display: inline-block;
    font-weight: 600;
  }
  .rent-form-group {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 1rem;
    margin-top: 1rem;
  }
  .rent-form-group .input-group-custom {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
  }
  .rent-form-group input[type="number"] {
    flex: 1;
    min-width: 140px;
    padding: 0.6rem 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 2rem;
    outline: none;
  }
  .accordion-button:not(.collapsed) {
    background: #eff6ff;
    color: #1e40af;
  }
  .accordion-button:focus {
    box-shadow: none;
    border-color: #3b82f6;
  }
  /* Dark Mode */
  body.dark-mode .book-cover,
  body.dark-mode .book-info-card {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .book-meta {
    border-color: #334155;
  }
  body.dark-mode .book-title {
    background: linear-gradient(135deg, #e2e8f0, #60a5fa);
    background-clip: text;
    -webkit-background-clip: text;
  }
  body.dark-mode .rent-form-group {
    background: #0f172a;
  }
  body.dark-mode .accordion-button {
    background: #1e293b;
    color: #e2e8f0;
  }
  body.dark-mode .accordion-button:not(.collapsed) {
    background: #0f172a;
    color: #60a5fa;
  }
  body.dark-mode .accordion-body {
    background: #1e293b;
    color: #cbd5e1;
  }
  @media (max-width: 768px) {
    .book-title {
      font-size: 1.5rem;
    }
    .price-tag {
      font-size: 1.4rem;
    }
    .book-detail-wrapper {
      padding: 1rem;
    }
  }
</style>

<div class="book-detail-wrapper">
  <div class="row g-4">
    <!-- Book Cover Column -->
    <div class="col-md-5 col-lg-4">
      <div class="book-cover">
        <img src="<?php echo BOOK_IMAGE_SITE_PATH . $getProduct['0']['img']; ?>" alt="<?php echo htmlspecialchars($getProduct['0']['name']); ?>" class="img-fluid">
      </div>
    </div>

    <!-- Book Info Column -->
    <div class="col-md-7 col-lg-8">
      <div class="book-info-card">
        <h1 class="book-title"><?php echo htmlspecialchars($getProduct['0']['name']); ?></h1>
        <div class="book-meta">
          <div><strong>ISBN:</strong> <?php echo htmlspecialchars($getProduct['0']['ISBN']); ?></div>
          <div><strong>Author:</strong> <?php echo htmlspecialchars($getProduct['0']['author']); ?></div>
        </div>

        <div class="price-tag">
          ₹<?php echo htmlspecialchars($getProduct['0']['rent']); ?> <small>(Per Day)</small>
        </div>

        <?php
        $qtySql = mysqli_query($con, "select qty from books where id='$bookId'");
        $row = mysqli_fetch_assoc($qtySql);
        $qtyArr = array();
        $qtyArr[] = $row;
        if ($qtyArr['0']['qty'] == 0) {
          echo '<div class="out-of-stock mt-3"><i class="fas fa-exclamation-circle me-2"></i>Sorry currently the book is out of stock</div>';
        } else {
          echo '<button id="toggle" class="btn-rent" onclick="showDiv()"><i class="fas fa-calendar-alt me-2"></i>Rent this book</button>';
        }
        ?>

        <div id="after-rent" style="display: none;" class="rent-form-group">
          <form method="get">
            <input type="hidden" name="bookId" value="<?php echo $getProduct['0']['id']; ?>">
            <h5><i class="fas fa-clock me-2"></i>Enter duration (in days)</h5>
            <div class="input-group-custom">
              <input type="number" name="duration" min="1" max="365" placeholder="Number of days" required>
              <input type="submit" name="submit" value="Proceed to Rent" class="btn-rent" style="margin:0;">
            </div>
          </form>
        </div>

        <script>
        function showDiv() {
          document.getElementById("after-rent").style.display = "block";
          document.getElementById("toggle").style.display = "none";
        }
        </script>
      </div>
    </div>
  </div>

  <!-- Short Description & Full Description Accordion -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="book-info-card">
        <h5 class="fw-bold mb-3"><i class="fas fa-align-left me-2"></i>Short Description</h5>
        <p class="text-justify"><?php echo nl2br(htmlspecialchars($getProduct['0']['short_desc'])); ?></p>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-12">
      <div class="accordion" id="accordion">
        <div class="accordion-item border-0 shadow-sm rounded overflow-hidden">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              <i class="fas fa-file-alt me-2"></i> Full Description
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
            <div class="accordion-body">
              <p class="mb-0 text-justify"><?php echo nl2br(htmlspecialchars($getProduct['0']['description'])); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require('footer.php') ?>