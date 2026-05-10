<?php
require('header.php');
if (isset($_SESSION['USER_LOGIN'])) {
  echo "<script>window.top.location='index.php';</script>";
  exit;
}
?>
<?php
$msg = '';
$nameErr = $emailErr = $mobileErr = $passwordErr = "";
$nameTemp = $emailTemp = $mobileTemp = $passwordTemp = "";
if (isset($_POST['submit'])) {
  //validation for name
  if (empty($_POST["name"])) {
    $nameErr = "Please enter a name";
  } else {
    $nameTemp = getSafeValue($con, $_POST['name']);
    if (preg_match("/^[a-zA-Z-' ]*$/", $nameTemp)) {
      $name = getSafeValue($con, $_POST['name']);
      //validation for email
      if (empty($_POST["email"])) {
        $emailErr = "Please enter Email address";
      } else {
        $emailTemp = getSafeValue($con, $_POST['email']);
        if (filter_var($emailTemp, FILTER_VALIDATE_EMAIL)) {
          $email = getSafeValue($con, $_POST['email']);
          $mobile = getSafeValue($con, $_POST['mobile']);
          //Validation for password
          if (empty($_POST["password"])) {
            $passwordErr = "Please enter a password";
          } else {
            $passwordTemp = getSafeValue($con, $_POST['password']);
          }
          $password = md5($passwordTemp);
          date_default_timezone_set('Asia/Kolkata');
          $doj = date('Y-m-d H:i:s');
          $check_user = mysqli_num_rows(mysqli_query($con, "select * from users where email='$email'"));
          if ($check_user > 0) {
            $msg = "Email ID already exists please login";
          } else {
            $sql = "insert into users(name, email, mobile, password ,doj)
            values('$name', '$email', '$mobile', '$password', '$doj')";
            if (mysqli_query($con, $sql)) {
              echo "<script>window.top.location='SignIn.php';</script>";
            } else {
              $msg = "error";
            }
          }
        } else {
          $emailErr = "Please enter valid Email address";
        }
      }
    } else {
      $nameErr = "Only letters and white space allowed in Name";
    }
  }
}
?>
<script>
document.title = "Register | Book Rental";
</script>

<style>
  /* Enhanced Registration Page Styles */
  .register-wrapper {
    max-width: 800px;
    margin: 2rem auto;
    padding: 1rem;
  }
  .register-card {
    background: #ffffff;
    border-radius: 2rem;
    box-shadow: 0 20px 35px -12px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s;
  }
  .register-card:hover {
    transform: translateY(-4px);
  }
  .register-header {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    padding: 2rem;
    text-align: center;
    color: white;
  }
  .register-header h2 {
    font-weight: 700;
    margin: 0;
    font-size: 1.8rem;
  }
  .register-header p {
    margin: 0.5rem 0 0;
    opacity: 0.9;
  }
  .register-body {
    padding: 2rem;
  }
  .input-group-custom {
    margin-bottom: 1.2rem;
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
  .error-text {
    color: #ef4444;
    font-size: 0.8rem;
    margin-top: 0.3rem;
    margin-left: 2.8rem;
  }
  .error-message {
    background: #fee2e2;
    color: #b91c1c;
    padding: 0.7rem 1rem;
    border-radius: 1rem;
    margin: 1rem 0;
    text-align: center;
  }
  .btn-register {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 2rem;
    font-weight: 600;
    font-size: 1rem;
    color: white;
    transition: 0.2s;
    cursor: pointer;
    margin-top: 0.5rem;
  }
  .btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(37,99,235,0.3);
  }
  .login-link {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid #eef2ff;
  }
  .login-link a {
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
  }
  .login-link a:hover {
    text-decoration: underline;
  }
  /* Dark mode */
  body.dark-mode .register-card {
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
  body.dark-mode .error-text {
    color: #f87171;
  }
  body.dark-mode .login-link {
    border-top-color: #334155;
  }
  body.dark-mode .login-link a {
    color: #60a5fa;
  }
  @media (max-width: 576px) {
    .register-body {
      padding: 1.5rem;
    }
    .register-header {
      padding: 1.5rem;
    }
  }
</style>

<div class="register-wrapper">
  <div class="register-card">
    <div class="register-header">
      <h2><i class="fas fa-user-plus me-2"></i> Create Account</h2>
      <p>Join our reading community</p>
    </div>
    <div class="register-body">
      <form method="post">
        <div class="input-group-custom">
          <i class="fas fa-user"></i>
          <input type="text" name="name" id="name" placeholder="Full Name" required>
        </div>
        <?php if ($nameErr) echo '<div class="error-text"><i class="fas fa-exclamation-circle me-1"></i>' . $nameErr . '</div>'; ?>

        <div class="input-group-custom">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" id="email" placeholder="Email Address" required>
        </div>
        <?php if ($emailErr) echo '<div class="error-text"><i class="fas fa-exclamation-circle me-1"></i>' . $emailErr . '</div>'; ?>

        <div class="input-group-custom">
          <i class="fas fa-phone-alt"></i>
          <input type="number" min="1111111111" max="9999999999" name="mobile" id="mobile" placeholder="Mobile Number (without +91)" required>
        </div>

        <div class="input-group-custom">
          <i class="fas fa-key"></i>
          <input type="password" name="password" id="password" placeholder="Password" required>
        </div>

        <?php
        // Display combined errors (from original logic)
        if ($msg && $msg != '') {
          echo '<div class="error-message"><i class="fas fa-exclamation-triangle me-2"></i>' . $msg . '</div>';
        }
        if ($passwordErr) {
          echo '<div class="error-text"><i class="fas fa-exclamation-circle me-1"></i>' . $passwordErr . '</div>';
        }
        ?>

        <div class="text-center mt-4">
          <button type="submit" name="submit" id="submit" class="btn-register">
            <i class="fas fa-user-check me-2"></i> Register
          </button>
        </div>

        <div class="login-link">
          Already have an account? <a href="SignIn.php">Login here</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Dark Mode Toggle (preserved) -->
<div id="dark-btn">
    <button onclick="DarkMode()" id="dark-btn" title="Toggle Light/Dark Mode">
        <span><i class="fas fa-adjust fa-lg text-white"></i></span>
    </button>
    <script>
    //Dark Mode
    function DarkMode() {
        let element = document.body;
        element.classList.toggle("dark-mode");
    }
    </script>
</div>

<?php require('footer.php'); ?>