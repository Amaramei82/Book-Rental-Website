<?php require('header.php') ?>
<?php
if (!isset($_SESSION['USER_LOGIN'])) {
    echo "<script>window.top.location='SignIn.php';</script>";
    exit;
}

$bookId = '';
$duration = '';
if (isset($_GET['id'])) {
    $bookId = mysqli_real_escape_string($con, $_GET['id']);
}
if (isset($_GET['duration'])) {
    $duration = mysqli_real_escape_string($con, $_GET['duration']);
}
$getProduct = getProduct($con, '', '', $bookId);
$totalRent = $getProduct['0']['rent'] * $duration;
$totalPrice = $totalRent + $getProduct['0']['security'];


if (isset($_POST['submit'])) {
    $address = getSafeValue($con, $_POST['address']);
    $address2 = getSafeValue($con, $_POST['address2']);
    $pin = getSafeValue($con, $_POST['pin']);
    $paymentMethod = getSafeValue($con, $_POST['paymentMethod']);
    $userId = $_SESSION['USER_ID'];
    $paymentStatus = 'pending';
    if ($paymentMethod == 'COD') {
        $paymentStatus = 'success';
    }
    $orderStatus = '1';
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO orders(user_id, address, address2, pin, payment_method, total, payment_status, order_status, date, duration)
            VALUES ('$userId', '$address', '$address2', '$pin','$paymentMethod','$totalPrice','$paymentStatus','$orderStatus','$date','$duration')";
    mysqli_query($con, $sql);

    $orderId = mysqli_insert_id($con);
    $productId = $getProduct['0']['id'];
    mysqli_query($con, "INSERT INTO order_detail(order_id,book_id,price,time)
                                VALUES ('$orderId', '$productId', '$totalPrice', '$duration')");

    $newQty = $getProduct['0']['qty'] - 1;
    mysqli_query($con, "UPDATE books SET qty = '$newQty' WHERE id='$bookId';");
?>
<script>
window.top.location = 'thankYou.php?orderId=<?php echo $orderId ?>';
</script>
<?php
}
?>
<script>
document.title = "Checkout | Book Rental";
</script>

<style>
  /* Enhanced Checkout Page Styles */
  .checkout-wrapper {
    max-width: 1280px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }
  .checkout-header {
    text-align: center;
    margin-bottom: 2rem;
  }
  .checkout-header h2 {
    font-size: 2.2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #1e293b, #2563eb);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    display: inline-block;
  }
  .order-summary-card, .shipping-card, .deposit-card {
    background: #ffffff;
    border-radius: 1.5rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    border: 1px solid #eef2ff;
    overflow: hidden;
    margin-bottom: 1.5rem;
    transition: transform 0.2s;
  }
  .order-summary-card:hover, .shipping-card:hover {
    transform: translateY(-2px);
  }
  .card-header-custom {
    background: linear-gradient(135deg, #f8fafc, #ffffff);
    padding: 1.2rem 1.5rem;
    border-bottom: 1px solid #eef2ff;
    font-weight: 700;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  .card-header-custom i {
    color: #2563eb;
  }
  .book-detail-item {
    display: flex;
    justify-content: space-between;
    padding: 0.6rem 0;
    border-bottom: 1px dashed #eef2ff;
  }
  .book-detail-item:last-child {
    border-bottom: none;
  }
  .total-row {
    font-weight: 800;
    font-size: 1.1rem;
    color: #1e40af;
    border-top: 2px solid #e2e8f0;
    margin-top: 0.5rem;
    padding-top: 0.8rem;
  }
  .deposit-terms {
    padding: 1rem 1.5rem 1.2rem;
  }
  .deposit-terms ol {
    padding-left: 1.2rem;
    margin-bottom: 0;
  }
  .deposit-terms li {
    margin-bottom: 0.5rem;
    color: #334155;
  }
  .form-group-custom {
    margin-bottom: 1.2rem;
  }
  .form-group-custom label {
    font-weight: 600;
    margin-bottom: 0.4rem;
    color: #1e293b;
  }
  .form-control-custom {
    width: 100%;
    padding: 0.7rem 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 0.8rem;
    transition: 0.2s;
  }
  .form-control-custom:focus {
    border-color: #3b82f6;
    outline: none;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
  }
  .btn-place-order {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
    padding: 0.9rem;
    border-radius: 2rem;
    font-weight: 700;
    font-size: 1rem;
    width: 100%;
    transition: 0.2s;
  }
  .btn-place-order:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37,99,235,0.3);
  }
  /* Dark mode */
  body.dark-mode .order-summary-card,
  body.dark-mode .shipping-card,
  body.dark-mode .deposit-card {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .card-header-custom {
    background: #0f172a;
    border-bottom-color: #334155;
    color: #e2e8f0;
  }
  body.dark-mode .book-detail-item {
    border-bottom-color: #334155;
    color: #cbd5e1;
  }
  body.dark-mode .total-row {
    border-top-color: #475569;
    color: #60a5fa;
  }
  body.dark-mode .deposit-terms li {
    color: #cbd5e1;
  }
  body.dark-mode .form-group-custom label {
    color: #e2e8f0;
  }
  body.dark-mode .form-control-custom {
    background: #0f172a;
    border-color: #475569;
    color: #e2e8f0;
  }
  @media (max-width: 768px) {
    .checkout-header h2 {
      font-size: 1.6rem;
    }
    .card-header-custom {
      font-size: 1rem;
    }
  }
</style>

<div class="checkout-wrapper">
  <div class="checkout-header">
    <h2><i class="fas fa-shopping-cart me-2"></i> Checkout</h2>
  </div>

  <div class="row g-4">
    <!-- Order Summary Column (Right on desktop) -->
    <div class="col-md-5 col-lg-4 order-md-last">
      <!-- Book Summary Card -->
      <div class="order-summary-card">
        <div class="card-header-custom">
          <i class="fas fa-book"></i> Your Book
        </div>
        <div style="padding: 1.2rem 1.5rem;">
          <div class="book-detail-item">
            <span><strong><?php echo htmlspecialchars($getProduct['0']['name']); ?></strong></span>
          </div>
          <div class="book-detail-item">
            <span>MRP</span>
            <span class="text-decoration-line-through text-muted">₹<?php echo $getProduct['0']['mrp']; ?></span>
          </div>
          <div class="book-detail-item">
            <span>Rent Price</span>
            <span>₹<?php echo $getProduct['0']['rent']; ?> <small class="text-muted">/ day</small></span>
          </div>
          <div class="book-detail-item">
            <span>Duration</span>
            <span><?php echo $duration; ?> days</span>
          </div>
          <div class="book-detail-item">
            <span>Total Rent</span>
            <span>₹<?php echo $totalRent; ?></span>
          </div>
          <div class="book-detail-item">
            <span>Security Deposit <span class="text-danger">*</span></span>
            <span>₹<?php echo $getProduct['0']['security']; ?></span>
          </div>
          <div class="total-row d-flex justify-content-between">
            <span>Total Amount</span>
            <span><strong>₹<?php echo $totalPrice; ?></strong></span>
          </div>
        </div>
      </div>

      <!-- Deposit Terms Card -->
      <div class="deposit-card">
        <div class="card-header-custom">
          <i class="fas fa-shield-alt"></i> Deposit Terms
        </div>
        <div class="deposit-terms">
          <ol>
            <li>You need to submit a photocopy and show Aadhar Card in original to the delivery person.</li>
            <li>Security Deposit is refundable once we receive the book in proper condition.</li>
          </ol>
        </div>
      </div>
    </div>

    <!-- Shipping Form Column -->
    <div class="col-md-7 col-lg-8">
      <div class="shipping-card">
        <div class="card-header-custom">
          <i class="fas fa-truck"></i> Shipping Address
        </div>
        <form class="needs-validation" method="post" novalidate style="padding: 1.5rem;">
          <div class="form-group-custom">
            <label for="address">Address Line 1</label>
            <input type="text" class="form-control-custom" name="address" id="address" placeholder="Street, House No., Area" required>
            <div class="invalid-feedback">
              Please enter your address.
            </div>
          </div>

          <div class="form-group-custom">
            <label for="address2">Address Line 2 <span class="text-muted">(Optional)</span></label>
            <input type="text" class="form-control-custom" name="address2" id="address2" placeholder="Landmark, Near by">
          </div>

          <div class="form-group-custom">
            <label for="pin">Pin Code</label>
            <input type="number" maxlength="6" class="form-control-custom" name="pin" id="pin" placeholder="246401" required>
            <div class="invalid-feedback">
              Pin code required.
            </div>
          </div>

          <hr class="my-4">

          <div class="form-group-custom">
            <label>Payment Method</label>
            <div class="form-check mb-2">
              <input id="cod" name="paymentMethod" type="radio" value="COD" class="form-check-input" checked required>
              <label class="form-check-label" for="cod">Cash on Delivery (COD)</label>
            </div>
            <div class="form-check">
              <input id="payU" name="paymentMethod" type="radio" value="payU" class="form-check-input" required disabled>
              <label class="form-check-label text-muted" for="payU">Online Payment (coming soon)</label>
            </div>
          </div>

          <hr class="my-4">

          <button class="btn-place-order" type="submit" name="submit">
            <i class="fas fa-check-circle me-2"></i> Place Your Order
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
(function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    let forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()
</script>
<?php require('footer.php') ?>