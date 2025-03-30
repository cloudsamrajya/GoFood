
<?php
$isLoggedIn = isset($_SESSION['user_id']);
?>
<section class="navigation-bar">
      <a href="#">
        <img
          id="logo-gofood"
          src="../Images/Logo5.png"
          style="height: 10vh"
          alt="Brand_logo"
        />
      </a>
      <nav class="nav-buttons">
        <button class="btn-cart"><i class="bi bi-cart3"></i></button>
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