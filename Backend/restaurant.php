<?php include '../DB/connect.php' ?>
<?php include 'header.php' ?>
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
            <td onclick="cart.php"><i class="bi bi-plus-lg"></i></td> <!--- yeta bata suru -->
        </tr>
        <?php endforeach ?>
        
        
       
    </table>
    
</div>























<?php include 'footer.php' ?>