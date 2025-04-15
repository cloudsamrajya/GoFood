<style>
    .toast-close {
    border: none ;
    background: none ;
    color: white ;
    outline: none ;
    margin-left: auto;
    cursor: pointer;
    font-size: 18px;
    }
</style>
<?php session_start() ?> 
<?php include '../DB/connect.php' ?>
<?php include 'header.php' ?>
<?php if(!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = 'Login First';
    header("Location:index.php ");


    exit();
} ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<?php
//for current cart count
$cartCount = 0;
///this for the order table
/// this is for do i have a cart
$stmt = $conn -> prepare('SELECT COUNT(*) FROM order_tbl WHERE user_id = ? AND status = "cart" ');
$stmt -> execute([$_SESSION['user_id']]);
$cartCount = $stmt -> fetchColumn();
 ?>


<?php 
$restaurant_food_item = [];
if(isset($_GET['restaurant_id'])){
$restaurant_id = $_GET['restaurant_id'];  
$stmt = $conn -> prepare("SELECT * FROM food_item WHERE restaurant_id = ?");
$stmt -> execute([$restaurant_id]);
$restaurant_food_item = $stmt -> fetchAll();
}

?>
<div class="table-container">
    <table class="tbl" >
        <tr class="no-hover">
            <th >
                Food Item
            </th>
            <th >
                Price
            </th>
            <th>
                Availability
            </th>
            <th>
                Add
            </th>
        </tr>
        <?php if (empty($restaurant_food_item)): ?>
        <tr><td colspan="4" style="text-align: center; padding: 20px; color: #666;">No food items found!</td></tr>
    <?php endif; ?>
        <?php foreach($restaurant_food_item as $r_f_i): ?>
        <tr>
            <td><?php echo $r_f_i['name']?></td>
            <td><?php echo $r_f_i['price'] ?></td>
            <td><span style="color: <?php echo ($r_f_i['availability']=='Available') ? '#2ecc71':'#e74c3c' ?> "><?php echo $r_f_i['availability'] ?></span>  </td>
            <td ><button class="btn btn-sm btn-primary add-to-cart"
             data-food-id = "<?php echo $r_f_i['food_id']?>"
             data-price = "<?php echo $r_f_i['price'] ?>"
             ><i class="bi bi-plus-lg"></i></button></td> 
        </tr>
        <?php endforeach ?>
        
        
       
    </table>
    
</div>

<script>
    $(document).ready(function(){
        $('.add-to-cart').click(function(){
            const foodid = $(this).data('food-id');
            const price = $(this).data('price');

            $.ajax({
                url: 'add_to_cart.php',
                method: 'POST',
                data: {
                    foodid: foodid,
                    price: price,
                    restaurant_id: <?php echo $restaurant_id ?? 0; ?>
                },
                success: function(response){
                    if(response.success){
                        $('#cart-count').text(response.cart_count);
                        // for showing notification
                        Toastify({
                            text: 'Item added to cart',
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position:"right",
                            backgroundColor: "#4CAF50",
                            style:{
                                padding: "10px 20px",
                                color: "#fff",
                                fontSize: "14px",
                                display: "flex",
                                alignItems: "center",
                                justifyContent: "space-between",

                            }

                        }).showToast();
                    }
                    else{
                        alert(response.message);
                    }
                }

            
            })

        })
        
    })
</script>























<?php include 'footer.php' ?>