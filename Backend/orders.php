<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location: index.php');
    exit();
}
include '../DB/connect.php';
include 'header.php';
try{
$stmt = $conn -> prepare("SELECT order_tbl.*, restaurant.name as restaurant_name FROM order_tbl JOIN restaurant ON order_tbl.restaurant_id = restaurant.restaurant_id WHERE order_tbl.user_id =? AND order_tbl.status = 'cart'");
$stmt -> execute([$_SESSION['user_id']]);
$order = $stmt -> fetch();

$orderItems = [];
if($order){
    $stmt = $conn -> prepare(" SELECT order_items.*, food_item.name as food_name FROM order_items JOIN food_item ON order_items.food_id = food_item.food_id WHERE order_items.order_id =?");
    $stmt -> execute([$order['order_id']]);
    $orderItems = $stmt -> fetchAll();
}
}
catch(PDOException $e){
    error_log('database error:' .$e->getMessage());
    die('An error occured while loading your order. Please try again later');
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
                                    <div class="col-md-3 text-end">
                                        <p class="fw-bold">Rs.<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                                        <button class="btn btn-sm btn-outline-danger remove-item" data-item-id ="<?php echo $item['order_item_id'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order Summary</h5>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rs.<?php echo number_format($order['total_price'], 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Delivery Fee:</span>
                                <span>Rs.100</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold mb-4">
                                <span>Total:</span>
                                <span>Rs.<?php echo number_format($order['total_price'] + 100, 2) ?></span>
                            </div>
                            <button class="btn btn-primary w-100 btn-lg checkout-btn">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
</div>
<script>
    ///for updating the qunatities in orders.php 
    $(document).ready(function(){
        $('.update-quantity').click(function(){
            const itemId = $(this).data('item-id');
            const action = $(this).data('action');

            $.ajax({
                url: 'update_cart.php',
                method: 'POST',
                data: {
                    item_id: itemId,
                    action: action
                },
                success: function(response){
                    if(response.success){
                        location.reload();
                    }
                    else {
                    alert(response.message || 'Error updating quantity');
                }
                },
                error: function(xhr, status, error) {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            }
            });
        
    });
    $('.remove-item').click(function(){
        if(confirm('Are you sure you want to remove this item?')){
            const itemId = $(this).data('item-id');

            $.ajax({
                url: 'update_cart.php',
                method: 'POST',
                data: {
                    item_id: itemId,
                    action: 'remove'
                },
                success: function(response){
                    if(response.success){
                        location.reload();
                    }
                    else {
                        alert(response.message || 'Error removing item');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                }
            });
        }
    });
    $('.checkout-btn').click(function(){
        ///checkout process

    });
    });
</script>




<?php include 'footer.php'; ?>