<?php
include '../DB/connect.php';
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$password = $_POST['password'];
if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($password)) {
    echo "All fields are required.";
    exit();
}
try{

$insert_user =  $conn -> prepare("INSERT INTO `user`(name, email, phone, address, password) VALUES(?,?,?,?,?)");
$success = $insert_user -> execute([$name, $email, $phone, $address, $password]);
if($success){
header('location: index.php');}

}

catch(PDOException $e){
    echo "Error on inserting data".$e->getMessage();
}



?>