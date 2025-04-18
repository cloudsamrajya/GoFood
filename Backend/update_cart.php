
<?php 
session_start();
include '../DB/connect.php';
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
    
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $itemId = $_POST['item_id'] ?? null ;
    $action = $_POST['action'] ?? null;

    if(!$itemId || !$action){
       echo json_encode(['success'=> false, 'message' => 'Invalid request']);
       exit();
    }
    
    try{
        $conn -> beginTransaction();

        ///now for getting the order_id for this item
        $stmt = $conn -> prepare("SELECT order_id FROM order_items WHERE order_item_id =?");
        $stmt -> execute([$itemId]);
        $orderId = $stmt -> fetchColumn();
        if(!$orderId){
            throw new Exception('Item not found');
        }

        ///verifying if the order belongs to the current user or not
        $stmt = $conn -> prepare("SELECT order_id FROM order_tbl WHERE order_id =? AND user_id =?");
        $stmt -> execute([$orderId, $_SESSION['user_id']]);
        if(!$stmt -> fetch()){
            throw new Exception('Unauthorized access');
        }
        switch($action){

            case 'increase':
                $stmt = $conn -> prepare("UPDATE order_items SET quantity = quantity + 1 WHERE order_item_id =?");
                $stmt -> execute([$itemId]);
                break;

            case 'decrease':
                ///before decrease we have to check if it is already 0 or not
                $stmt = $conn -> prepare("SELECT quantity FROM order_items WHERE order_item_id =?");
                $stmt -> execute([$itemId]);
                $quantity = $stmt -> fetchColumn();

                if($quantity <=1){
                    $stmt = $conn -> prepare("DELETE FROM order_items WHERE order_item_id =?");
                    $stmt -> execute([$itemId]);
                }
                else{
                    $stmt = $conn -> prepare("UPDATE order_items SET quantity = quantity - 1 WHERE order_item_id =?");
                    $stmt -> execute([$itemId]);
                }
                break;

            case 'remove':
                $stmt = $conn -> prepare("DELETE FROM order_items WHERE order_item_id =?");
                $stmt -> execute([$itemId]);
                break;
                
            default:
                throw new Exception('Invalid action');
        }
        /// for updating the total price
        $stmt = $conn -> prepare("UPDATE order_tbl SET total_price = (
        SELECT SUM(price*quantity) from order_items WHERE order_id =?
        ) WHERE order_id =?");
        $stmt -> execute([$orderId, $orderId]);

        ///now checking if the order is empty or not
        $stmt = $conn -> prepare("SELECT COUNT(*) FROM order_items WHERE order_id=?");
        $stmt -> execute([$orderId]);
        if($stmt -> fetchColumn() == 0){
            $stmt = $conn->prepare("DELETE FROM order_tbl WHERE order_id =?");
            $stmt->execute([$orderId]);
        }
        $conn -> commit();
        echo json_encode(['success'=> true]);
    }
    catch(Exception $e){
        $conn -> rollBack();
        echo json_encode(['success'=>false, 'message' => $e->getMessage()]);
    }
}
else{
    echo json_encode(['success'=> false, 'message'=> 'Invalid request method']);
}

?>