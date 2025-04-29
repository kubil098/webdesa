<?php
// Include the database connection file
require('koneksi.php');
// Initialize session
session_start();

$error = '';
$validate = '';

// Check if the session username is set and redirect if it is
if( isset($_SESSION['username']) ) header('Location: /WEBDESAABRIL/halamanlogin/admin/index.html');

// Check if the form is submitted
if( isset($_POST['submit']) ){
        
    // Sanitize input
    $username = stripslashes($_POST['username']);
    $username = mysqli_real_escape_string($con, $username);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($con, $password);

    // Check if input fields are not empty
    if(!empty(trim($username)) && !empty(trim($password))){

        // Query the database for the username
        $query      = "SELECT * FROM users WHERE username = '$username'";
        $result     = mysqli_query($con, $query);
        $rows       = mysqli_num_rows($result);

        if ($rows != 0) {
            $hash   = mysqli_fetch_assoc($result)['password'];
            if(password_verify($password, $hash)){
                $_SESSION['username'] = $username;
                header('Location: /WEBDESAABRIL/halamanlogin/admin/index.html');
                exit; // Make sure to exit after a redirect
            } else {
                $error = 'Password salah !!';
            }
        } else {
            $error = 'Username tidak ditemukan !!';
        }
    } else {
        $error = 'Data tidak boleh kosong !!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your existing head content -->
</head>
<body>
<div class="login-wrapper">
    <div class="login-container">
        <div class="row no-gutters">
            <div class="col-12 col-md-6">
                <form class="form-container" action="login.php" method="POST">
                    <h2 class="text-center">DESA PANAWANGAN</h2>
                    <!-- Display error if exists -->
                    <?php if($error != ''): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <div class="form-group">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Masukkan Password">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">LOGIN</button>
                    <a href="/WEBDESAABRIL/register/register.php" class="btn btn-register btn-block">REGISTER</a>
                    <div class="text-center mt-2">
                        <a href="forgot_password.php" class="text-secondary">Forgot Password?</a>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-6 d-none d-md-block">
                <div class="login-image">
                    <img src="apa.jpeg" class="img-fluid" alt="Jatinagara Image">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Your existing script tags -->
</body>
</html>