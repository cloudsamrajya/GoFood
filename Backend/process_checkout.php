<?php 
session_start();
include '..//DB/connect.php';

///checking if the user is logged in or not
if(!isset($_SESSION['user_id']))
{
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Please log in to continue'
    ]);
    exit();
}

/// for checking if the order_id is provided or not
if(!isset($_POST['order_id']) || empty($_POST['order_id'])){
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Invalid order'
    ]);
    exit();
}

$order_id = $_POST['order_id'];
try{
    $conn -> beginTransaction();

    ///verifying if the order belongs to current user and is in cart status
    $stmt = $conn -> prepare("SELECT * FROM order_tbl WHERE order_id = ? AND user_id = ? AND status = 'cart'");
    $stmt -> execute([$order_id, $_SESSION['user_id']]);
    $order = $stmt -> fetch();

    if(!$order){
        throw new Exception('Order not found or already processed');
    }

    ///updating the order status to pending

    $stmt = $conn -> prepare("UPDATE order_tbl SET status ='pending', order_date = NOW() WHERE order_id = ?");
    $stmt -> execute([$order_id]);

    ///commit transaction
    $conn -> commit();

    ///for returing the success response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'order_id' => $order_id,
        'message' => 'Order placed successfully'
    ]);
}
catch(Exception $e)
{
    $conn -> rollBack();
    error_log('Checkout error: '.$e->getMessage());
    ///returning the error reponse
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>