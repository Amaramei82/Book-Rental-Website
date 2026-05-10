<?php require('header.php') ?>
<?php
  $orderId = '';
  if (isset($_GET['orderId'])) {
    $orderId = mysqli_real_escape_string($con, $_GET['orderId']);
  }
?>

<style>
  /* Enhanced Thank You Page Styles */
  .thankyou-wrapper {
    max-width: 800px;
    margin: 2rem auto;
    padding: 1rem;
  }
  .thankyou-card {
    background: #ffffff;
    border-radius: 2rem;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
    overflow: hidden;
    transition: transform 0.2s;
    text-align: center;
  }
  .thankyou-card:hover {
    transform: translateY(-4px);
  }
  .thankyou-header {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    padding: 2rem;
    color: white;
  }
  .thankyou-header i {
    font-size: 4rem;
    margin-bottom: 1rem;
  }
  .thankyou-header h2 {
    font-weight: 800;
    margin: 0;
    font-size: 1.8rem;
  }
  .thankyou-body {
    padding: 2rem;
  }
  .order-id {
    background: #f1f5f9;
    display: inline-block;
    padding: 0.5rem 1.5rem;
    border-radius: 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: #1e40af;
    margin: 1rem 0;
  }
  .thankyou-message {
    font-size: 1rem;
    line-height: 1.6;
    color: #334155;
    margin-bottom: 1.5rem;
  }
  .thankyou-message strong {
    color: #2563eb;
  }
  .btn-home {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 2rem;
    font-weight: 600;
    font-size: 1rem;
    color: white;
    transition: 0.2s;
    display: inline-block;
    text-decoration: none;
    margin-top: 1rem;
  }
  .btn-home:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37,99,235,0.3);
    color: white;
  }
  /* Dark mode */
  body.dark-mode .thankyou-card {
    background: #1e293b;
  }
  body.dark-mode .order-id {
    background: #0f172a;
    color: #60a5fa;
  }
  body.dark-mode .thankyou-message {
    color: #cbd5e1;
  }
  @media (max-width: 576px) {
    .thankyou-header h2 { font-size: 1.4rem; }
    .thankyou-body { padding: 1.5rem; }
  }
</style>

<div class="thankyou-wrapper">
  <div class="thankyou-card">
    <div class="thankyou-header">
      <i class="fas fa-check-circle"></i>
      <h2>Order Confirmed!</h2>
    </div>
    <div class="thankyou-body">
      <div class="order-id">
        <i class="fas fa-hashtag me-1"></i> Order #<?php echo htmlspecialchars($orderId); ?>
      </div>
      <div class="thankyou-message">
        <strong>Thank You <?php 
          $userName = $_SESSION['USER_NAME'];
          echo htmlspecialchars($userName); 
        ?>!</strong> for shopping with us!<br>
        We are delivering your order.
      </div>
      <div class="thankyou-message">
        <i class="fas fa-envelope me-2"></i> We will send a shipping confirmation email when the item is shipped successfully.
      </div>
      <p class="mt-3" style="color: #64748b;">– Team Book Rental</p>
      <a href="index.php" class="btn-home"><i class="fas fa-home me-2"></i> Continue Shopping</a>
    </div>
  </div>
</div>

<?php require('footer.php') ?>