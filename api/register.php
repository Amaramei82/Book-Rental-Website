<?php
// Include your existing database connection ($con) and security functions
require('connection.php'); // or wherever your $con and getSafeValue are defined

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Getting data from Flutter (it sends data via POST)
    $name = isset($_POST['name']) ? getSafeValue($con, $_POST['name']) : '';
    $email = isset($_POST['email']) ? getSafeValue($con, $_POST['email']) : '';
    $mobile = isset($_POST['mobile']) ? getSafeValue($con, $_POST['mobile']) : '';
    $password = isset($_POST['password']) ? getSafeValue($con, $_POST['password']) : '';

    // Basic Validation (Matching your Web Logic)
    if (empty($name) || empty($email) || empty($password)) {
        $response['status'] = 'error';
        $response['message'] = 'Please fill all required fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid email format';
    } else {
        // Check if user exists
        $check_user = mysqli_num_rows(mysqli_query($con, "SELECT * FROM users WHERE email='$email'"));
        
        if ($check_user > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Email ID already exists';
        } else {
            $secure_password = md5($password); // Matching your web hashing
            date_default_timezone_set('Asia/Kolkata');
            $doj = date('Y-m-d H:i:s');

            $sql = "INSERT INTO users(name, email, mobile, password, doj) 
                    VALUES('$name', '$email', '$mobile', '$secure_password', '$doj')";
            
            if (mysqli_query($con, $sql)) {
                $response['status'] = 'success';
                $response['message'] = 'Registration Successful';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Database Error';
            }
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid Request Method';
}

echo json_encode($response);
?>