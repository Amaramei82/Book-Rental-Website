<?php
  require('header.php')
?>
<script>
    document.title = "Terms And Conditions | Book Rental";
</script>

<style>
  /* Enhanced Terms & Conditions Page Styles */
  .terms-wrapper {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 1rem;
  }
  .terms-card {
    background: #ffffff;
    border-radius: 2rem;
    box-shadow: 0 20px 35px -12px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s;
  }
  .terms-card:hover {
    transform: translateY(-4px);
  }
  .terms-header {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    padding: 2rem;
    text-align: center;
    color: white;
  }
  .terms-header h1 {
    font-weight: 800;
    margin: 0;
    font-size: 2rem;
    letter-spacing: -0.3px;
  }
  .terms-header p {
    margin: 0.5rem 0 0;
    opacity: 0.9;
    font-size: 0.9rem;
  }
  .terms-body {
    padding: 2rem;
  }
  .terms-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #eef2ff;
  }
  .terms-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
  }
  .terms-section h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .terms-section h2 i {
    color: #2563eb;
    font-size: 1.4rem;
  }
  .terms-section p {
    font-size: 1rem;
    line-height: 1.6;
    color: #334155;
    margin-left: 1.8rem;
    padding-left: 0.5rem;
    border-left: 3px solid #e2e8f0;
  }
  /* Dark mode */
  body.dark-mode .terms-card {
    background: #1e293b;
  }
  body.dark-mode .terms-section {
    border-bottom-color: #334155;
  }
  body.dark-mode .terms-section h2 {
    color: #e2e8f0;
  }
  body.dark-mode .terms-section p {
    color: #cbd5e1;
    border-left-color: #475569;
  }
  @media (max-width: 768px) {
    .terms-header h1 { font-size: 1.6rem; }
    .terms-body { padding: 1.5rem; }
    .terms-section h2 { font-size: 1.3rem; }
    .terms-section p { margin-left: 0.5rem; }
  }
</style>

<div class="terms-wrapper">
  <div class="terms-card">
    <div class="terms-header">
      <h1><i class="fas fa-file-contract me-2"></i> Terms & Conditions</h1>
      <p>Please read these terms carefully before renting books</p>
    </div>
    <div class="terms-body">
      <div class="terms-section">
        <h2><i class="fas fa-book"></i> If the book is returned damaged</h2>
        <p>The damage cost will be evaluated and will be deducted from security deposit. If the damage is more than security deposit then further amount will be collected from the renter.</p>
      </div>
      <div class="terms-section">
        <h2><i class="fas fa-clock"></i> If the book is returned late</h2>
        <p>Late fee will be charged on the basis of rent per day and will be deducted from security deposit.</p>
      </div>
    </div>
  </div>
</div>

<?php require('footer.php') ?>