<?php require('header.php') ?>
<script>
document.title = "About Us | Book Rental";
</script>

<style>
  /* Enhanced About Us Page Styles */
  .about-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }
  .hero-section {
    background: linear-gradient(135deg, #eef2ff 0%, #ffffff 100%);
    border-radius: 2rem;
    padding: 3rem 2rem;
    text-align: center;
    margin-bottom: 2.5rem;
  }
  .hero-section h1 {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    margin-bottom: 1rem;
  }
  .hero-section .subtitle {
    font-size: 1.1rem;
    color: #475569;
    max-width: 700px;
    margin: 0 auto;
  }
  .stats-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.5rem;
    margin: 2rem 0 3rem;
  }
  .stat-card {
    background: #ffffff;
    border-radius: 1.5rem;
    padding: 1.5rem;
    text-align: center;
    flex: 1;
    min-width: 140px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    border: 1px solid #eef2ff;
    transition: 0.2s;
  }
  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.1);
  }
  .stat-card i {
    font-size: 2rem;
    color: #3b82f6;
    margin-bottom: 0.75rem;
  }
  .stat-card .number {
    font-size: 1.8rem;
    font-weight: 800;
    color: #0f172a;
  }
  .stat-card .label {
    color: #64748b;
    font-weight: 500;
  }
  .content-card {
    background: #ffffff;
    border-radius: 1.5rem;
    padding: 1.8rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.03);
    border: 1px solid #eef2ff;
  }
  .content-card h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .content-card h2 i {
    color: #3b82f6;
  }
  .content-card p {
    font-size: 1rem;
    line-height: 1.6;
    color: #334155;
    margin-bottom: 1rem;
  }
  .highlight-box {
    background: #f8fafc;
    padding: 1.2rem 1.5rem;
    border-radius: 1rem;
    border-left: 4px solid #3b82f6;
    margin: 1rem 0;
  }
  .quote {
    text-align: center;
    font-style: italic;
    font-size: 1.1rem;
    color: #1e293b;
    padding: 1rem;
    background: #eef2ff;
    border-radius: 1rem;
    margin-top: 1rem;
  }
  /* Dark mode compatibility */
  body.dark-mode .hero-section {
    background: linear-gradient(135deg, #0f172a, #1e293b);
  }
  body.dark-mode .hero-section .subtitle {
    color: #94a3b8;
  }
  body.dark-mode .stat-card {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .stat-card .number {
    color: #e2e8f0;
  }
  body.dark-mode .content-card {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .content-card h2 {
    color: #e2e8f0;
  }
  body.dark-mode .content-card p {
    color: #cbd5e1;
  }
  body.dark-mode .highlight-box {
    background: #0f172a;
  }
  body.dark-mode .quote {
    background: #0f172a;
    color: #cbd5e1;
  }
  @media (max-width: 768px) {
    .hero-section h1 { font-size: 1.8rem; }
    .hero-section { padding: 2rem 1rem; }
    .stats-row { gap: 1rem; }
    .stat-card { min-width: 120px; padding: 1rem; }
    .stat-card .number { font-size: 1.4rem; }
    .content-card { padding: 1.2rem; }
  }
</style>

<div class="about-wrapper">
  <!-- Hero Section -->
  <div class="hero-section">
    <h1>About Us</h1>
    <div class="subtitle">
      We make it easy to access and afford the learning experiences you need, anytime, anywhere.
    </div>
  </div>

  <!-- Stats / Highlights (derived from content) -->
  <div class="stats-row">
    <div class="stat-card">
      <i class="fas fa-calendar-alt"></i>
      <div class="number">2021</div>
      <div class="label">Founded</div>
    </div>
    <div class="stat-card">
      <i class="fas fa-book-open"></i>
      <div class="number">10k+</div>
      <div class="label">Books Available</div>
    </div>
    <div class="stat-card">
      <i class="fas fa-smile"></i>
      <div class="number">15k+</div>
      <div class="label">Happy Readers</div>
    </div>
    <div class="stat-card">
      <i class="fas fa-map-marker-alt"></i>
      <div class="number">Dehradun</div>
      <div class="label">Based Out of</div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="content-card">
    <h2><i class="fas fa-seedling"></i> Our Journey</h2>
    <p>
      Book Rental is a platform operating since 2021. It aims to provide quality literature to the enthusiasts at
      affordable prices and promote a culture of reading among different generations in India.
    </p>
  </div>

  <div class="content-card">
    <h2><i class="fas fa-hand-holding-heart"></i> Why rent books from Book Rental?</h2>
    <p>
      Buying books online can be really expensive, especially if you like to read a lot. And that is why, at Book
      Rental, we are committed to provide you a huge collection of books at amazing discounted prices. We are not a
      profit hungry online book renter, but a small book store at the corner of your street.
    </p>
    <div class="highlight-box">
      <i class="fas fa-quote-left me-2"></i> Based out of Dehradun, Book Rental was started with an aim to promote reading culture in India, to make reading cool again. Main aim is to bring down the cost of books which suits your budget.
    </div>
    <p>
      As we grew, we diversified from just renting books online to a platform, where you can find all type of books – e.g. children books, academic and non-academic books and everything bookish under the sun. We pivoted from an online bookstore from where you buy books to a platform, which celebrates books and literature. Every pre-loved book is carefully inspected to ensure that you get value for money for your purchases.
    </p>
    <div class="quote">
      <i class="fas fa-gem me-2"></i> Learn More. Save More!!!
    </div>
  </div>
</div>

<?php require('footer.php') ?>