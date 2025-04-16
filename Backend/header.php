<link rel="stylesheet" href="../style.css">
<style>
  
  #cart-count{
    right: 100px;
    top: 20px;



  }
</style>
<?php
$isLoggedIn = isset($_SESSION['user_id']);
?>
<section class="navigation-bar">
      <a href="index.php">
        <img
          id="logo-gofood"
          src="../Images/Logo5.png"
          style="height: 10vh"
          alt="Brand_logo"
        />
      </a>


      <nav class="nav-buttons">
        <button onclick="<?php if($isLoggedIn): ?> window.location.href='orders.php'
        <?php else: ?>
          openmodal()
        
        <?php endif;?>
        
        
        
        
        " class="btn-cart position relative" ><i class="bi bi-cart3"></i> 
      <?php if($isLoggedIn): ?>
        <span id="cart-count" class="position-absolute  translate-middle badge rounded-pill bg-danger">
        <?php 
        $stmt = $conn -> prepare("SELECT COUNT(*) FROM order_items oi JOIN order_tbl o ON oi.order_id = o.order_id WHERE o.user_id = ? AND o.status = 'cart'");
        $stmt -> execute([$_SESSION['user_id']]); 
        ///we did this because current user id should be passed because if others passed it will be not be right
        echo $stmt -> fetchColumn()

        ?>

        </span>
       
          <?php endif; ?>
      
      
      
      
      
      
      </button>
         
        <?php if(!$isLoggedIn): ?>
        <button class="btn-login" onclick="openmodal()">Login</button>
        <?php else:   ?>
        <button class="btn-logout" style="border: none;
  color: white;
  background-color: #d63031;
  font-size: 20px;
  border-radius: 5px;
  padding: 10px;">Logout</button>
        <?php endif; ?>


      </nav>
    </section>
    <script>
      // const modalcontainer =  document.querySelector('modalcontainer');
      // function openmodal(){
      //   modalcontainer.classList.add('open_modal');
      // }
      
   
    const logoutBtn = document.querySelector('.btn-logout');
    if(logoutBtn) {
        logoutBtn.addEventListener('click', () => {
            // Send request to logout script
            fetch('logout.php')
                .then(response => {
                    if(response.ok) {
                        window.location.reload(); // Refresh page after logout
                    }
                });
        });
    }
    </script>