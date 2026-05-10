<?php require('header.php') ?>
<?php
$search = mysqli_real_escape_string($con, $_GET['search']);
function getBook($con)
{
  $search = mysqli_real_escape_string($con, $_GET['search']);
  $sql = "SELECT * FROM books WHERE (`name` LIKE '%$search%') OR (`author` LIKE '%$search%')";
  $res = mysqli_query($con, $sql);
  $data = array();
  while ($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
  }
  return $data;
}

?>
<script>
document.title = "Search Results | Book Rental";
</script>

<style>
  /* Enhanced Search Page Styles */
  .search-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }
  .search-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #eef2ff;
  }
  .search-header h1 {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #1e293b, #2563eb);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    display: inline-block;
  }
  .search-query {
    margin-top: 0.5rem;
    color: #475569;
  }
  .search-query strong {
    color: #2563eb;
  }
  .results-count {
    margin-top: 1rem;
    font-size: 0.9rem;
    color: #64748b;
  }
  .book-card {
    background: #ffffff;
    border-radius: 1.25rem;
    overflow: hidden;
    transition: transform 0.25s, box-shadow 0.25s;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    border: 1px solid #edf2f7;
  }
  .book-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 25px -12px rgba(0,0,0,0.1);
    border-color: #cbdffc;
  }
  .book-img {
    background: #f8fafc;
    padding: 1rem;
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
  }
  .book-title {
    font-weight: 700;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
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
  .book-author {
    font-size: 0.8rem;
    color: #5b6e8c;
    margin: 0.25rem 0 0.5rem;
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
    margin-top: 0.5rem;
  }
  .btn-detail:hover {
    background: #2563eb;
    border-color: #2563eb;
    color: white;
  }
  .no-results {
    text-align: center;
    padding: 3rem;
    background: #ffffff;
    border-radius: 2rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    margin: 2rem 0;
  }
  .no-results i {
    font-size: 4rem;
    color: #94a3b8;
    margin-bottom: 1rem;
  }
  .no-results h3 {
    color: #1e293b;
    margin-bottom: 0.5rem;
  }
  /* Dark mode */
  body.dark-mode .book-card {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .book-title {
    color: #e2e8f0;
  }
  body.dark-mode .book-author {
    color: #94a3b8;
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
  body.dark-mode .no-results {
    background: #1e293b;
  }
  body.dark-mode .no-results h3 {
    color: #e2e8f0;
  }
  body.dark-mode .search-header {
    border-bottom-color: #334155;
  }
  @media (max-width: 768px) {
    .book-img {
      height: 180px;
    }
  }
</style>

<div class="search-wrapper">
  <div class="search-header">
    <h1><i class="fas fa-search me-2"></i> Search Results</h1>
    <div class="search-query">
      Showing results for: <strong>"<?php echo htmlspecialchars($search); ?>"</strong>
    </div>
  </div>

  <?php
  $getBook = getBook($con);
  if (count($getBook) > 0) {
  ?>
    <div class="results-count">
      <i class="fas fa-book-open me-1"></i> Found <?php echo count($getBook); ?> book(s)
    </div>
    <div class="row gy-4 gx-3 mt-2">
      <?php foreach ($getBook as $list) { ?>
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
          <div class="book-card">
            <div class="book-img">
              <img src="<?php echo BOOK_IMAGE_SITE_PATH . $list['img']; ?>" alt="<?php echo htmlspecialchars($list['name']); ?>">
            </div>
            <div class="book-info">
              <div class="book-title">
                <a href="book.php?id=<?php echo $list['id']; ?>"><?php echo htmlspecialchars($list['name']); ?></a>
              </div>
              <div class="book-author">
                <i class="fas fa-user-edit"></i> <?php echo htmlspecialchars($list['author']); ?>
              </div>
              <a href="book.php?id=<?php echo $list['id']; ?>" class="btn-detail">
                <i class="fas fa-info-circle"></i> View Details
              </a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } else { ?>
    <div class="no-results">
      <i class="fas fa-book-open"></i>
      <h3>No books found</h3>
      <p>We couldn't find any matches for "<strong><?php echo htmlspecialchars($search); ?></strong>".</p>
      <p class="text-muted">Try searching with different keywords or browse our categories.</p>
      <a href="index.php" class="btn btn-primary rounded-pill px-4 mt-2">Back to Home</a>
    </div>
  <?php } ?>
</div>

<?php require('footer.php') ?>