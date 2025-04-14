<?php include '../DB/connect.php'?>
<?php if(isset($_GET['food_id'])){
  $food_id = $_GET['food_id'];
  $stmt = $conn -> prepare("SELECT * FROM food_item where food_id = ?");
  $stmt -> execute([$food_id]);
  $foods = $stmt -> fetchAll();
} ?>




<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<style>.cart-item img {
     max-width: 100px;
     height: auto;
 }

 .quantity-input {
     width: 50px;
 }

 .cart-summary {
     background-color: #f8f9fa;
     border-radius: 10px;
 }</style>
<div class="container py-5">
    <h1 class="mb-5">Your Shopping Cart</h1>
    <div class="row">
        <div class="col-lg-8">
            <!-- Cart Items -->
            <div class="card mb-4">
                <div class="card-body" >
                    <?php foreach($foods as $food): ?>
                    <div class="d-flex justify-content-between align-items-center" >
                        
                        <div class="col-md-5">
                            <h5 class="card-title"><?php echo $food['name'] ?></h5>
                            <p class="text-muted"><?php echo $food['category']?></p>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group">
                                <button class="btn btn-outline-secondary btn-sm" type="button">-</button>
                                <input style="max-width:100px" type="text" class="form-control  form-control-sm text-center quantity-input" value="1">
                                <button class="btn btn-outline-secondary btn-sm" type="button">+</button>
                            </div>
                        </div>
                        <div class="col-md-2 text-end"  >
                            <p class="fw-bold">$99.99</p>
                            <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                        </div>
                    </div>
                    <hr>
                    <?php endforeach  ?>
                    
                </div>
            </div>
            <!-- Continue Shopping Button -->
            <div class="text-start mb-4">
                <a href="#" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- Cart Summary -->
            <div class="card cart-summary">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <span>$199.97</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping</span>
                        <span>$10.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tax</span>
                        <span>$20.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong>$229.97</strong>
                    </div>
                    <button class="btn btn-primary w-100">Proceed to Checkout</button>
                </div>
            </div>
            <!-- Promo Code -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Apply Promo Code</h5>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter promo code">
                        <button class="btn btn-outline-secondary" type="button">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>