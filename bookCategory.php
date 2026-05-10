<?php require('header.php');
$categoryId = '';
if (isset($_GET['id'])) {
    $categoryId = mysqli_real_escape_string($con, $_GET['id']);
}
$getProduct = getProduct($con, '', $categoryId);
$catRes = mysqli_query($con, "select id, category from categories where status=1 order by category asc");
$catArr = array();
while ($row = mysqli_fetch_assoc($catRes)) {
    $catArr[] = $row;
}
?>
<script>
document.title = "Book Categories | Book Rental";
</script>

<style>
  /* Enhanced Category Page Styles - Design Only */
  .category-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 1.5rem 1rem;
  }
  .mobile-category-toggle {
    display: none;
    margin-bottom: 1rem;
  }
  .category-toggle-btn {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    border: none;
    border-radius: 2rem;
    padding: 0.6rem 1.2rem;
    width: 100%;
    text-align: center;
    font-weight: 500;
  }
  .sidebar-card {
    background: #ffffff;
    border-radius: 1.5rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    border: 1px solid #eef2ff;
    overflow: hidden;
    position: sticky;
    top: 90px;
  }
  .sidebar-header {
    background: linear-gradient(135deg, #f8fafc, #ffffff);
    padding: 1rem 1.2rem;
    border-bottom: 1px solid #eef2ff;
    font-weight: 700;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #1e293b;
  }
  .sidebar-header i {
    color: #2563eb;
  }
  .category-list {
    list-style: none;
    padding: 0.5rem 0;
    margin: 0;
  }
  .category-list li a {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.7rem 1.2rem;
    color: #334155;
    text-decoration: none;
    font-weight: 500;
    transition: 0.2s;
    border-left: 3px solid transparent;
  }
  .category-list li a i {
    width: 1.5rem;
    color: #3b82f6;
  }
  .category-list li a:hover,
  .category-list li a.active {
    background: #eff6ff;
    border-left-color: #2563eb;
    color: #1e40af;
  }
  /* Book Cards */
  .books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.5rem;
  }
  .book-card {
    background: #ffffff;
    border-radius: 1.25rem;
    overflow: hidden;
    transition: transform 0.25s, box-shadow 0.25s;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    border: 1px solid #edf2f7;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  .book-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 25px -12px rgba(0,0,0,0.1);
    border-color: #cbdffc;
  }
  .book-img {
    background: #f8fafc;
    padding: 1.5rem;
    text-align: center;
    height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .book-img img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.3s;
  }
  .book-card:hover .book-img img {
    transform: scale(1.02);
  }
  .book-info {
    padding: 1rem 1rem 1.2rem;
    text-align: center;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }
  .book-title {
    font-weight: 700;
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
    color: #0f172a;
    line-height: 1.3;
  }
  .book-title a {
    color: inherit;
    text-decoration: none;
  }
  .book-title a:hover {
    color: #2563eb;
  }
  .btn-detail {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 2rem;
    padding: 0.4rem 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #1e293b;
    transition: 0.2s;
    display: inline-block;
    text-decoration: none;
    margin-top: 0.75rem;
  }
  .btn-detail:hover {
    background: #2563eb;
    border-color: #2563eb;
    color: white;
  }
  .no-books {
    background: #f8fafc;
    border-radius: 1.5rem;
    padding: 3rem;
    text-align: center;
    color: #475569;
  }
  @media (max-width: 768px) {
    .category-wrapper {
      padding: 1rem;
    }
    .mobile-category-toggle {
      display: block;
    }
    .sidebar-card.desktop-sidebar {
      display: none;
    }
    .sidebar-card.mobile-sidebar {
      margin-bottom: 1.5rem;
    }
    .books-grid {
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 1rem;
    }
    .book-img {
      height: 170px;
    }
  }
  /* Dark Mode */
  body.dark-mode .sidebar-card {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .sidebar-header {
    background: #0f172a;
    border-bottom-color: #334155;
    color: #e2e8f0;
  }
  body.dark-mode .category-list li a {
    color: #cbd5e1;
  }
  body.dark-mode .category-list li a:hover,
  body.dark-mode .category-list li a.active {
    background: #0f172a;
    color: #60a5fa;
  }
  body.dark-mode .book-card {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .book-title {
    color: #e2e8f0;
  }
  body.dark-mode .btn-detail {
    background: #0f172a;
    border-color: #475569;
    color: #cbd5e1;
  }
  body.dark-mode .btn-detail:hover {
    background: #2563eb;
    color: white;
  }
  body.dark-mode .no-books {
    background: #0f172a;
    color: #94a3b8;
  }
</style>

<div class="category-wrapper">
  <div class="row g-4">
    <!-- Sidebar - Desktop (always visible) -->
    <div class="col-md-4 col-lg-3">
      <div class="sidebar-card desktop-sidebar">
        <div class="sidebar-header">
          <i class="fas fa-bookmark"></i> Categories
        </div>
        <ul class="category-list">
          <?php foreach ($catArr as $list) {
            $activeClass = ($categoryId == $list['id']) ? 'active' : '';
          ?>
          <li>
            <a href="bookCategory.php?id=<?php echo $list['id']; ?>" class="<?php echo $activeClass; ?>">
              <i class="fas fa-folder-open"></i> <?php echo htmlspecialchars($list['category']); ?>
            </a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>

    <!-- Mobile Category Toggle (hidden on desktop) -->
    <div class="col-12 mobile-category-toggle">
      <button class="category-toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#mobileCategoryMenu">
        <i class="fas fa-bars me-2"></i> Browse Categories
      </button>
      <div class="collapse mt-2" id="mobileCategoryMenu">
        <div class="sidebar-card mobile-sidebar">
          <div class="sidebar-header">
            <i class="fas fa-bookmark"></i> Categories
          </div>
          <ul class="category-list">
            <?php foreach ($catArr as $list) {
              $activeClass = ($categoryId == $list['id']) ? 'active' : '';
            ?>
            <li>
              <a href="bookCategory.php?id=<?php echo $list['id']; ?>" class="<?php echo $activeClass; ?>">
                <i class="fas fa-folder-open"></i> <?php echo htmlspecialchars($list['category']); ?>
              </a>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>

    <!-- Main Books Grid -->
    <main class="col-md-8 col-lg-9">
      <?php if (count($getProduct) > 0) { ?>
        <div class="books-grid">
          <?php foreach ($getProduct as $list) { ?>
            <div class="book-card">
              <div class="book-img">
                <img src="<?php echo BOOK_IMAGE_SITE_PATH . $list['img']; ?>" alt="<?php echo htmlspecialchars($list['name']); ?>">
              </div>
              <div class="book-info">
                <div class="book-title">
                  <a href="book.php?id=<?php echo $list['id']; ?>"><?php echo htmlspecialchars($list['name']); ?></a>
                </div>
                <a href="book.php?id=<?php echo $list['id']; ?>" class="btn-detail">
                  <i class="fas fa-info-circle"></i> View Details
                </a>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } else { ?>
        <div class="no-books">
          <i class="fas fa-book-open fa-3x mb-3"></i>
          <h5>No Books Found</h5>
          <p>There are no books available in this category. Please try another category.</p>
        </div>
      <?php } ?>
    </main>
  </div>
</div>

<?php require('footer.php') ?>