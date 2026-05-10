<?php
require('header.php');
if (!isset($_SESSION['USER_LOGIN'])) {
  echo "<script>window.top.location='SignIn.php';</script>";
  exit;
}
$userId = $_SESSION['USER_ID'];
$res = mysqli_query($con, "select * from users where id='$userId'");
$row = mysqli_fetch_assoc($res);
$nameAuto = $row['name'];
$emailAuto = $row['email'];
$mobileAuto = $row['mobile'];
$passwordCheck = $row['password'];
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
          if ($password == $passwordCheck) {
            $sql = "UPDATE users SET name='$name', email='$email', mobile='$mobile' WHERE id='$userId'";
            if (mysqli_query($con, $sql)) {
              $msg = 'Updated Succesfully --> Changes will be visible next time you login';
            } else {
              $msg = "error";
            }
          } else {
            $msg = 'Please Enter Correct Password';
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
document.title = "Profile | Book Rental";
</script>

<style>
  /* Enhanced Profile Page Styles */
  .profile-wrapper {
    max-width: 800px;
    margin: 2rem auto;
    padding: 1rem;
  }
  .profile-card {
    background: #ffffff;
    border-radius: 2rem;
    box-shadow: 0 20px 35px -12px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s;
  }
  .profile-card:hover {
    transform: translateY(-4px);
  }
  .profile-header {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    padding: 2rem;
    text-align: center;
    color: white;
  }
  .profile-header h2 {
    font-weight: 700;
    margin: 0;
    font-size: 1.8rem;
  }
  .profile-header p {
    margin: 0.5rem 0 0;
    opacity: 0.9;
  }
  .profile-body {
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
  .success-message {
    background: #d1fae5;
    color: #065f46;
    padding: 0.7rem 1rem;
    border-radius: 1rem;
    margin: 1rem 0;
    text-align: center;
  }
  .error-message {
    background: #fee2e2;
    color: #b91c1c;
    padding: 0.7rem 1rem;
    border-radius: 1rem;
    margin: 1rem 0;
    text-align: center;
  }
  .btn-submit {
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
  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(37,99,235,0.3);
  }
  /* Dark mode */
  body.dark-mode .profile-card {
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
  @media (max-width: 576px) {
    .profile-body {
      padding: 1.5rem;
    }
    .profile-header {
      padding: 1.5rem;
    }
  }
</style>

<div class="profile-wrapper">
  <div class="profile-card">
    <div class="profile-header">
      <h2><i class="fas fa-user-edit me-2"></i> Edit Profile</h2>
      <p>Update your personal information</p>
    </div>
    <div class="profile-body">
      <form method="post" autocomplete="off">
        <div class="input-group-custom">
          <i class="fas fa-user"></i>
          <input type="text" name="name" id="name" placeholder="Full Name" value="<?php echo htmlspecialchars($nameAuto); ?>" required>
        </div>
        <?php if ($nameErr) echo '<div class="error-text"><i class="fas fa-exclamation-circle me-1"></i>' . $nameErr . '</div>'; ?>

        <div class="input-group-custom">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" id="email" placeholder="Email Address" value="<?php echo htmlspecialchars($emailAuto); ?>" required>
        </div>
        <?php if ($emailErr) echo '<div class="error-text"><i class="fas fa-exclamation-circle me-1"></i>' . $emailErr . '</div>'; ?>

        <div class="input-group-custom">
          <i class="fas fa-phone-alt"></i>
          <input type="number" min="1111111111" max="9999999999" name="mobile" id="mobile" placeholder="Mobile Number (without +91)" value="<?php echo htmlspecialchars($mobileAuto); ?>" required>
        </div>

        <div class="input-group-custom">
          <i class="fas fa-key"></i>
          <input type="password" name="password" id="password" placeholder="Current Password" required>
        </div>

        <?php if ($msg == 'Updated Succesfully --> Changes will be visible next time you login'): ?>
          <div class="success-message"><i class="fas fa-check-circle me-2"></i><?php echo $msg; ?></div>
        <?php elseif ($msg == 'error'): ?>
          <div class="error-message"><i class="fas fa-exclamation-triangle me-2"></i>Something went wrong. Please try again.</div>
        <?php elseif ($msg && $msg != ''): ?>
          <div class="error-message"><i class="fas fa-exclamation-circle me-2"></i><?php echo $msg; ?></div>
        <?php endif; ?>

        <div class="text-center mt-4">
          <button type="submit" name="submit" class="btn-submit">
            <i class="fas fa-save me-2"></i> Update Profile
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require('footer.php'); ?>