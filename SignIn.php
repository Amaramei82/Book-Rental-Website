<?php
require('header.php');
if (isset($_SESSION['USER_LOGIN'])) {
    echo "<script>window.top.location='index.php';</script>";
    exit;
}
?>
<?php
$msg = $passwordTemp = '';
if (isset($_POST['submit'])) {
    $email = getSafeValue($con, $_POST['email']);
    $passwordTemp = getSafeValue($con, $_POST['password']);
    $password = md5($passwordTemp);
    $sql = "select * from users where email='$email' and password='$password'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    $count = mysqli_num_rows($res);
    if ($count > 0) {
        $_SESSION['USER_LOGIN'] = 'yes';
        $_SESSION['USER_ID'] = $row['id'];
        $_SESSION['USER_NAME'] = $row['name'];
        if (isset($_SESSION['BeforeCheckoutLogin'])) {
            $checkoutAfterLogin = $_SESSION['BeforeCheckoutLogin'];
            echo "<script>window.top.location='$checkoutAfterLogin';</script>";
        } else {
            echo "<script>window.top.location='index.php';</script>";
            exit;
        }
    } else {
        $msg = "Invalid Username/Password";
    }
}
?>
<script>
document.title = "Login | Book Rental";
</script>

<style>
  /* Enhanced Login Page Styles (Design Only) */
  .login-wrapper {
    min-height: calc(100vh - 140px);
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f5f7fc 0%, #eef2ff 100%);
    padding: 2rem 1rem;
  }
  .login-card {
    background: #ffffff;
    border-radius: 2rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
    max-width: 500px;
    width: 100%;
  }
  .login-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 30px 50px -12px rgba(0, 0, 0, 0.2);
  }
  .login-header {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    padding: 1.8rem;
    text-align: center;
    color: white;
  }
  .login-header h2 {
    font-weight: 700;
    margin: 0;
    font-size: 1.8rem;
    letter-spacing: -0.3px;
  }
  .login-header p {
    margin: 0.5rem 0 0;
    opacity: 0.9;
    font-size: 0.9rem;
  }
  .login-body {
    padding: 2rem 2rem 1.8rem;
  }
  .input-group-custom {
    margin-bottom: 1.5rem;
    position: relative;
  }
  .input-group-custom i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 1.1rem;
    z-index: 10;
  }
  .input-group-custom input {
    width: 100%;
    padding: 0.9rem 1rem 0.9rem 2.8rem;
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    font-size: 1rem;
    transition: all 0.2s;
    background: #f8fafc;
  }
  .input-group-custom input:focus {
    border-color: #3b82f6;
    outline: none;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
    background: #ffffff;
  }
  .btn-login {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
    width: 100%;
    padding: 0.9rem;
    border-radius: 1rem;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.2s;
    color: white;
    cursor: pointer;
  }
  .btn-login:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37,99,235,0.3);
  }
  .register-link {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid #eef2ff;
  }
  .register-link a {
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
  }
  .register-link a:hover {
    text-decoration: underline;
  }
  .error-message {
    background: #fee2e2;
    color: #b91c1c;
    padding: 0.6rem;
    border-radius: 1rem;
    text-align: center;
    font-size: 0.85rem;
    margin-bottom: 1rem;
  }
  /* Dark mode compatibility */
  body.dark-mode .login-wrapper {
    background: linear-gradient(135deg, #0f172a, #1e293b);
  }
  body.dark-mode .login-card {
    background: #1e293b;
  }
  body.dark-mode .input-group-custom input {
    background: #0f172a;
    border-color: #334155;
    color: #e2e8f0;
  }
  body.dark-mode .input-group-custom i {
    color: #94a3b8;
  }
  body.dark-mode .register-link {
    border-top-color: #334155;
  }
  body.dark-mode .register-link a {
    color: #60a5fa;
  }
  /* Responsive */
  @media (max-width: 576px) {
    .login-body {
      padding: 1.5rem;
    }
    .login-header {
      padding: 1.2rem;
    }
  }
  /* The dark mode button is kept as is, just repositioned slightly */
  #dark-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 99;
  }
  #dark-btn button {
    background: #1e293b;
    border: none;
    border-radius: 50px;
    width: 44px;
    height: 44px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    cursor: pointer;
    transition: 0.2s;
  }
  #dark-btn button:hover {
    transform: scale(1.05);
    background: #0f172a;
  }
  body.dark-mode #dark-btn button {
    background: #f1f5f9;
  }
  body.dark-mode #dark-btn button i {
    color: #0f172a;
  }
</style>

<div class="login-wrapper">
  <div class="login-card">
    <div class="login-header">
      <h2><i class="fas fa-book-open me-2"></i> Welcome Back</h2>
      <p>Sign in to continue your reading journey</p>
    </div>
    <div class="login-body">
      <?php if ($msg != '') { ?>
        <div class="error-message">
          <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $msg; ?>
        </div>
      <?php } ?>
      <form method="post">
        <div class="input-group-custom">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" id="email" placeholder="Email address" required autocomplete="email">
        </div>
        <div class="input-group-custom">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" id="password" placeholder="Password" required autocomplete="current-password">
        </div>
        <button type="submit" name="submit" class="btn-login">
          <i class="fas fa-arrow-right-to-bracket me-2"></i> Login
        </button>
        <div class="register-link">
          New to Book Rental? <a href="register.php">Create an account</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Dark Mode Toggle (preserved exactly as original) -->
<div id="dark-btn">
    <button onclick="DarkMode()" id="dark-btn" title="Toggle Light/Dark Mode">
        <span><i class="fas fa-adjust fa-lg text-white"></i></span>
    </button>

    <script>
    //Dark Mode (unchanged)
    function DarkMode() {
        let element = document.body;
        element.classList.toggle("dark-mode");
    }
    </script>
</div>

<?php require('footer.php'); ?>