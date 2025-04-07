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
        <tr>
            <th>
                Food Item
            </th>
            <th>
                Price
            </th>
            <th>
                Availability
            </th>
            <th>
                Add
            </th>
        </tr>
        <?php if (empty($restaurant_food_item)) {
    echo "No data found!";
}?>
        <?php foreach($restaurant_food_item as $r_f_i): ?>
        <tr>
            <td><?php echo $r_f_i['name']?></td>
            <td><?php echo $r_f_i['price'] ?></td>
            <td><?php echo $r_f_i['availability'] ?></td>
            <td>+</td>
        </tr>
        <?php endforeach ?>
        
        
       
    </table>
    
</div>























<?php include 'footer.php' ?>