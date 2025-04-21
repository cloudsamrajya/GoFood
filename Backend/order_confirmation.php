<?php 
session_start();
if(!isset($_SESSION['user_id'])){
    header('location: index.php');
    exit();
}
include '../DB/connect.php';
include 'header.php';

/// checking if the order_id is provided or not
if(!isset($_GET['order_id']) || empty($_GET['order_id'])){
    echo '<div class = "container py-5"><div class = "alert alert-danger"> Invalid order </div></div>';
    include 'footer.php';
    exit();
}
$order_id = $_GET['order_id'];

try{
    ///getting the order details
    $stmt = $conn -> prepare("SELECT order_tbl.*, restaurant.name as restaurant_name, user.address as user_address FROM order_tbl JOIN restaurant ON order_tbl.restaurant_id = restaurant.restaurant_id JOIN user ON order_tbl.user_id = user.user_id WHERE order_tbl.order_id = ? AND order_tbl.user_id = ? AND order_tbl.status ='pending'");
    $stmt -> execute([$order_id, $_SESSION['user_id']]);
    $order = $stmt -> fetch();

    

    if(!$order){
        echo '<div class="container py-5"><div class ="alert alert-danger">Order not found</div></div>';
        include 'footer.php';
        exit();
    }

    ///getting the order items
    $stmt = $conn->prepare("SELECT order_items.*, food_item.name as food_name FROM order_items JOIN food_item ON order_items.food_id = food_item.food_id WHERE order_items.order_id = ?");
    $stmt -> execute([$order_id]);
    $orderItems = $stmt -> fetchAll();

}
catch(PDOException $e){
    error_log('Database error: '.$e->getMessage());
    echo '<div class ="container py-5"><div class="alert alert-danger">An error occurred. Please try again later.</div></div>';
    include 'footer.php';
    exit();
}
?>
<div class="container py-5">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4>Order Confirmed</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Order #<?php echo $order_id; ?></h5>
                    <p>Status: <span class="badge bg-warning">Pending</span></p>
                    <p>Date: <?php echo date('F j, Y, g:i a', strtotime($order['order_date'])); ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Restaurant</h5>
                    <p><?php echo htmlspecialchars($order['restaurant_name']); ?></p>
                </div>
            </div>
            <h5 class="mb-3">Order Items</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orderItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['food_name']); ?></td>
                            <td>Rs.<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td class="text-end">Rs.<?php echo number_format($item['price'] * $item['quantity'] ,2); ?></td>
                        </tr>
                        <?php endforeach ; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Subtotal</th>
                        <td class="text-end">Rs.<?php echo number_format($order['total_price'],2); ?></td>
                    </tr>
                    <tr>
                        <th colspan="3">Delivering to </th>
                        <td class="text-end"><?php echo htmlspecialchars($order['user_address']??'Address not available'); ?></td>
                    </tr>
                    <tr>
                        <th colspan="3">Delivery Fee</th>
                        <td class="text-end">Rs.100.00</td>
                    </tr>
                    <tr>
                        <th colspan="3">Total</th>
                        <td class="text-end fw-bold">Rs.<?php echo number_format($order['total_price'] + 100, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-primary">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>