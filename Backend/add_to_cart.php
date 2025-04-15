<?php
session_start();
include '../DB/connect.php';
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(['success'=> false, 'message' => 'Please login first']);
    exit();
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $foodId = $_POST['foodid'];
    $price = $_POST['price'];
    $restaurantId = $_POST['restaurant_id'];
    $userId = $_SESSION['user_id'];

    try{
        $conn -> beginTransaction();
        ///for checking if the user has active carts or not
        $stmt = $conn -> prepare('SELECT order_id FROM order_tbl WHERE user_id = ? AND status ="cart" LIMIT 1');
        $stmt -> execute([$userId]);
        $order = $stmt -> fetch();
        ///order nai xaina bhaney
        if(!$order){
            $stmt = $conn -> prepare("INSERT INTO order_tbl (user_id, restaurant_id, total_price, status) VALUES(?,?,0,'cart')");
            $stmt -> execute([$userId, $restaurantId]);
            $orderId = $conn -> lastInsertId();
        }
        else{
            $orderId = $order['order_id'];
        }
        ///for checking if the item is already added in the order
        $stmt = $conn -> prepare('SELECT * FROM order_items WHERE order_id = ? AND food_id =?');
        $stmt -> execute([$orderId, $foodId]);
        $existingItem = $stmt -> fetch();
        if($existingItem){
            ///updating the quantity
            $stmt = $conn -> prepare('UPDATE order_items SET quantity = quantity + 1 WHERE order_item_id = ? ');
            $stmt -> execute([$existingItem['order_item_id']]);
        }
        else{
            /// adding new item
            $stmt = $conn -> prepare("INSERT INTO order_items(order_id, food_id, quantity,price) VALUES (?,?,1,?)");
            $stmt -> execute([$orderId, $foodId, $price]);
        }

        /// for updating total price

        $stmt = $conn -> prepare("UPDATE order_tbl SET total_price = (SELECT SUM(price*quantity) FROM order_items WHERE order_id = ?) WHERE order_id = ?");
        $stmt -> execute([$orderId, $orderId]);
        $conn -> commit();


        /// for updated cart count
        ///this is for order items
        /// this is for how many items are in the cart
        $stmt = $conn -> prepare("SELECT COUNT(*) FROM order_items WHERE order_id = ?");
        $stmt -> execute([$orderId]);
        $cartCount = $stmt -> fetchColumn();
        echo json_encode(['success' => true, 'cart_count' => $cartCount]);
    }
    catch(PDOException $e){
        $conn -> rollBack();
        echo json_encode(['success' => false, 'message' => 'Database error:'.$e->getMessage()]);
    }
    
}
else{
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
