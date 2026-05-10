<?php require('header.php') ?>
<?php
$msg = '';
if (isset($_POST['submit'])) {
  $name = getSafeValue($con, $_POST['name']);
  $email = getSafeValue($con, $_POST['email']);
  $mobile = getSafeValue($con, $_POST['mobile']);
  $message = getSafeValue($con, $_POST['message']);
  date_default_timezone_set('Asia/Kolkata');
  $dateTime = date('Y-m-d H:i:s');
  $sql = "insert into contact_us(name, email, mobile, message, date)
            values('$name', '$email', '$mobile', '$message','$dateTime')";
  if (mysqli_query($con, $sql)) {
    $msg = "Message sent";
  } else {
    $msg = "error";
  }
}
if (isset($_SESSION['USER_LOGIN'])) {
  $userId = $_SESSION['USER_ID'];
  $res = mysqli_query($con, "select * from users where id='$userId'");
  $row = mysqli_fetch_assoc($res);
  $nameAuto = $row['name'];
  $emailAuto = $row['email'];
  $mobileAuto = $row['mobile'];
} else {
  $nameAuto = '';
  $emailAuto = '';
  $mobileAuto = '';
}
?>
<script>
document.title = "Contact Us | Book Rental";
</script>

<style>
  /* Enhanced Contact Page Styles */
  .contact-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
  }
  .contact-header {
    text-align: center;
    margin-bottom: 2.5rem;
  }
  .contact-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #1e293b, #2563eb);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    display: inline-block;
  }
  .contact-card {
    background: #ffffff;
    border-radius: 1.8rem;
    box-shadow: 0 12px 30px rgba(0,0,0,0.05);
    border: 1px solid #eef2ff;
    overflow: hidden;
    transition: transform 0.2s;
  }
  .contact-card:hover {
    transform: translateY(-3px);
  }
  .card-header-custom {
    background: linear-gradient(135deg, #f8fafc, #ffffff);
    padding: 1.2rem 1.8rem;
    border-bottom: 1px solid #eef2ff;
    font-weight: 700;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
  }
  .card-header-custom i {
    color: #2563eb;
    font-size: 1.3rem;
  }
  .form-container {
    padding: 1.8rem;
  }
  .form-group-custom {
    margin-bottom: 1.2rem;
  }
  .form-group-custom label {
    font-weight: 600;
    margin-bottom: 0.4rem;
    color: #1e293b;
    display: block;
  }
  .form-group-custom .required-star {
    color: #ef4444;
    margin-left: 3px;
  }
  .form-control-custom {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 1rem;
    transition: 0.2s;
    background: #f9fafb;
  }
  .form-control-custom:focus {
    border-color: #3b82f6;
    outline: none;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
    background: #ffffff;
  }
  textarea.form-control-custom {
    resize: vertical;
    min-height: 120px;
  }
  .btn-submit {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 2rem;
    font-weight: 600;
    font-size: 1rem;
    width: 100%;
    max-width: 250px;
    transition: 0.2s;
  }
  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37,99,235,0.3);
  }
  .success-message, .error-message {
    padding: 0.7rem;
    border-radius: 1rem;
    text-align: center;
    margin-bottom: 1.2rem;
    font-weight: 500;
  }
  .success-message {
    background: #d1fae5;
    color: #065f46;
  }
  .error-message {
    background: #fee2e2;
    color: #b91c1c;
  }
  .contact-info {
    background: #f8fafc;
    border-radius: 1.5rem;
    padding: 1.5rem;
    margin-top: 2rem;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 1rem;
    border: 1px solid #eef2ff;
  }
  .contact-info a {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 1.1rem;
    color: #1e293b;
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    transition: 0.2s;
  }
  .contact-info a i {
    font-size: 1.3rem;
    color: #2563eb;
  }
  .contact-info a:hover {
    background: #eef2ff;
    transform: translateX(3px);
  }
  /* Dark mode */
  body.dark-mode .contact-card {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .card-header-custom {
    background: #0f172a;
    border-bottom-color: #334155;
    color: #e2e8f0;
  }
  body.dark-mode .form-group-custom label {
    color: #e2e8f0;
  }
  body.dark-mode .form-control-custom {
    background: #0f172a;
    border-color: #475569;
    color: #e2e8f0;
  }
  body.dark-mode .contact-info {
    background: #0f172a;
    border-color: #334155;
  }
  body.dark-mode .contact-info a {
    color: #cbd5e1;
  }
  body.dark-mode .contact-info a:hover {
    background: #1e293b;
  }
  @media (max-width: 768px) {
    .contact-header h1 { font-size: 1.8rem; }
    .contact-info { flex-direction: column; align-items: center; text-align: center; }
    .btn-submit { max-width: 100%; }
    .form-container { padding: 1.2rem; }
  }
</style>

<div class="contact-wrapper">
  <div class="contact-header">
    <h1><i class="fas fa-envelope-open-text me-2"></i> Get in Touch</h1>
    <p class="text-muted mt-2">We'd love to hear from you! Send us a message and we'll respond as soon as possible.</p>
  </div>

  <div class="contact-card">
    <div class="card-header-custom">
      <i class="fas fa-comment-dots"></i> Send us a message
    </div>
    <div class="form-container">
      <?php if ($msg == "Message sent"): ?>
        <div class="success-message">
          <i class="fas fa-check-circle me-2"></i> <?php echo $msg; ?>! We'll get back to you shortly.
        </div>
      <?php elseif ($msg == "error"): ?>
        <div class="error-message">
          <i class="fas fa-exclamation-triangle me-2"></i> Something went wrong. Please try again.
        </div>
      <?php endif; ?>

      <form method="post" id="contactForm">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group-custom">
              <label>Full Name <span class="required-star">*</span></label>
              <input type="text" class="form-control-custom" name="name" value="<?php echo htmlspecialchars($nameAuto); ?>" required placeholder="John Doe">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group-custom">
              <label>Email Address <span class="required-star">*</span></label>
              <input type="email" class="form-control-custom" name="email" value="<?php echo htmlspecialchars($emailAuto); ?>" required placeholder="hello@example.com">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group-custom">
              <label>Mobile Number</label>
              <input type="tel" maxlength="12" class="form-control-custom" name="mobile" value="<?php echo htmlspecialchars($mobileAuto); ?>" placeholder="9876543210">
            </div>
          </div>
          <div class="col-12">
            <div class="form-group-custom">
              <label>Your Message <span class="required-star">*</span></label>
              <textarea maxlength="500" class="form-control-custom" name="message" required placeholder="Tell us how we can help..."></textarea>
            </div>
          </div>
        </div>

        <div class="text-center mt-4">
          <button class="btn-submit text-white" type="submit" name="submit">
            <i class="fas fa-paper-plane me-2"></i> Send Message
          </button>
        </div>
      </form>
    </div>
  </div>

  <div class="contact-info">
    <a href="mailto:contact@bookrental.com?subject=Contact%20us">
      <i class="fas fa-envelope"></i> contact@bookrental.com
    </a>
    <a href="tel:+911234567890">
      <i class="fas fa-phone-alt"></i> +91 1234567890
    </a>
    <a href="#" target="_blank">
      <i class="fab fa-whatsapp"></i> WhatsApp us
    </a>
  </div>
</div>

<?php require('footer.php') ?>