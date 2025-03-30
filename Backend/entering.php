<?php
include '../DB/connect.php';
session_start();

if(isset($_POST['submit'])){
    $email= $_POST['email'];
    $password = $_POST['password'];
    try{
        $select_user = $conn -> prepare("SELECT * FROM `user` WHERE email = ? ");
    $select_user -> execute([$email]);

    if($select_user -> rowCount()>0){
        $fetch_user = $select_user -> fetch(PDO::FETCH_ASSOC);
        if($password === $fetch_user['password']){
            echo"successfully connected";
        $_SESSION['user_id'] = $fetch_user['user_id'];
        header('location:index.php');
        exit();

        }
        else{
            $_SESSION['login_error'] = 'Incorrect email or password';
            header('location: index.php');
            exit();
        }
    }
    else{
        $_SESSION['login_error'] = 'Incorrect email or password';

        header('location: index.php');
            exit();
    }
}
catch(PDOException $e){
    echo('Login failed try again later'). $e -> getMessage();
}

    }
    
    
  




?>
