<?php
session_start();
include '../DB/connect.php';
include 'header.php';

$stmt = $conn -> prepare("SELECT order_tbl.*, restaurant.name as restaurant_name FROM order_tbl JOIN restaurant ON order_tbl.restaurant_id = restaurant.restaurant_id WHERE order_tbl.user_id =? AND order_tbl.status = 'cart'");
$stmt -> execute([$_SESSION['user_id']]);
$order = $stmt -> fetch();

$orderItems = [];
if($order){
    $stmt = $conn -> prepare(" SELECT order_items.*, food_item.name as food_name FROM order_items JOIN food_item ON order_items.food_id = food_item.food_id WHERE order_items.order_id = ?  ");
    $stmt -> execute([$order['order_id']]);
    $orderItems = $stmt -> fetchAll();
}
?>
<div class="container py-5">
    <h1 class="mb-5">Your Order</h1>
    <?php if(!$order): ?>
        <div class="alert alert-info">Your cart is empty</div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4><?php echo htmlspecialchars($order['restaurant_name']); ?></h4>
                        </div>
                        <div class="card-body">
                            <?php foreach($orderItems as $item): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="col-md-6">
                                        <h5><?php echo htmlspecialchars($item['food_name']); ?></h5>
                                        <p class="text-muted">
                                            Rs.<?php echo number_format($item['price'],2);
                                            ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary btn-sm update-quantity" data-item-id="<?php echo $item['order_item_id'] ?>" data-action="decrease">-</button>
                                            <input type="text" class="form-control form-control-sm text-center" value="<?php echo $item['quantity'] ?>" readonly>
                                            <button class="btn btn-outline-secondary btn-sm update-quantity" data-item-id="<?php echo $item['order_item_id'] ?>" data-action="increase">+</button>
                                            
                                        </div>
                                    </div>
                                </div>
                        </div>
                        

                    </div>
                </div>
            </div>
</div>




<?php include 'footer.php'; ?>