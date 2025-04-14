<!-- you page ko kam xaina -->
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="../styles/loginform.css">
  
 
</head>

<body>
    <div class="login-form-container">
    <h1>Login</h1>
<!--  If the login credentials are incorrect  it moves to same page  --->
    <?php if(isset($_SESSION['login_error'])): ?>
        <p style="color: red;"><?= $_SESSION['login_error'] ?></p>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?> 
<!--  End of login credentials section  --->



<!-- form--->
<form action="entering.php" method="POST">
        Email: <input type="email" name="email">
        Password: <input type="password" name="password">
        <input type="submit" name="submit" value="Login">
    </form>



    </div>
</body>
</html>