<?php
session_start();

require('connection.php');
require('function.php');

$msg='';

if(isset($_POST['submit'])){

    $email=mysqli_real_escape_string($con,$_POST['email']);
    $password=md5($_POST['password']);

    $sql="SELECT * FROM admin WHERE email='$email' AND password='$password'";

    $res=mysqli_query($con,$sql);


    if(mysqli_num_rows($res)>0){

        $_SESSION['ADMIN_LOGIN']='yes';
        $_SESSION['ADMIN_email']=$email;

        header('location:categories.php');
        exit();

    }else{
        $msg="Invalid Username/Password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Icon -->
    <link rel="shortcut icon" href="../Img/icon.png" type="image/x-icon" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- Default CSS -->
    <link rel="stylesheet" href="../css/Style.css" />
    <!-- Bootstrap CSS -->
    <link id="theme" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome Fonts-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" />
    <!-- Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Default JS-->
    <script src="js/script.js"></script>
    <title>Admin Login | Book Rental</title>
    
    <style>
        /* Enhanced Admin Login Styles */
        body {
            background: linear-gradient(135deg, #eef2ff 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', sans-serif;
        }
        .login-wrapper {
            max-width: 500px;
            width: 100%;
            padding: 1rem;
        }
        .login-card {
            background: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: transform 0.2s;
        }
        .login-card:hover {
            transform: translateY(-4px);
        }
        .login-header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            padding: 2rem;
            text-align: center;
            color: white;
        }
        .login-header h1 {
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
            padding: 2rem;
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
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37,99,235,0.3);
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
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #eef2ff;
        }
        .back-link a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        @media (max-width: 576px) {
            .login-body {
                padding: 1.5rem;
            }
            .login-header {
                padding: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h1><i class="fas fa-user-shield me-2"></i> Admin Login</h1>
                <p>Access the administration panel</p>
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
                    <div class="back-link">
                        <a href="../index.php"><i class="fas fa-home me-1"></i> Back to Book Rental</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>