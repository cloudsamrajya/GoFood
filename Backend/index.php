<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php include '../DB/connect.php' ?>
<?php session_start();
if(isset($_SESSION['message'])){
  echo "<script>
  $(document).ready(function(){
  alert('".$_SESSION['message']."')
  })
  </script>";
  unset($_SESSION['message']);
}
 ?>
<html>
    <head>
    <title>
        Home Page
    </title>
    <!-- Add viewport meta tag for responsiveness -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    </head>
    <body>
        <!-- Menu section starts -->
    
    <?php include 'header.php' ?>
    </div>

        <!-- Menu section ends -->

        <!-- Main content section starts -->
        <section class="section-2">
      <img class="banner-image" src="../Images/banner3.jpg" alt="" />
      <div class="search-container">
        <form method="GET" action="search.php" class="search-form">
        <input type="text" name="query" class="search-bar" placeholder="Food or Restaurant" />
        <button class="btn-search">Search</button>
        </form>
      </div>
    </section>
    <main class="featured-product">
      <div class="section-title">
        <h2>Deals of the day</h2>
      </div>
      <?php $restaurants = $conn-> query("SELECT * FROM restaurant") -> fetchAll() ?>  <!-- restaurants   -->

      <div class="product-container">
        <?php foreach($restaurants as $r): ?>
        <div class="featured-product-div">
          <a class="anchor" href="restaurant.php?restaurant_id=<?php echo $r['restaurant_id']; ?>">
          <div class="featured-product-div-img">
            <img
              class="featured-img"
              src="<?php echo $r['image']; ?>"
              alt="<?php echo $r['name']; ?>"
            />
          </div>
          <div class="featured-product-div-title"><?php echo $r['name'] ?></div>
          </a>
        </div>
        <?php endforeach ?>
      </div>
    </main>
    <section class="section-3">
      <div class="section-3-container">
        <div class="section-3-banner">
          <img src="../Images/banner2.jpg" alt="" id="banner1" />
        </div>
        <div class="section-3-about">
          <p>
            GoodFood is the fastest, easiest, and most convenient way to enjoy
            delicious meals from your favorite restaurants—whether you're at
            home, at work, or anywhere you choose. We understand that your time
            is precious, and every moment counts.
          </p>
          <p>
            That's why we bring your favorite dishes straight to your
            doorstep—so you can focus on what truly matters while we take care
            of the rest.
          </p>
        </div>
      </div>
    </section>
     <style>
       /* to stop the scroll when modal is open*/ 
        body.modal-open {
          overflow: hidden;
          width: 100%;
        }

        .modalcontainer{
            position: fixed;
            z-index: 1000;
            height: 100vh;
            width: 100%;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            visibility: hidden;
            opacity: 0;
        }
        .open_modal{
            visibility: visible;
            opacity: 1;
        }
        .logincontainer{
            height: auto;
            width: 90%;
            max-width: 400px;
            border-radius: 5px;
            background-color: white;
            padding: 20px 0;
        }
        .logincontainer form{
            height: auto;   
            width: 100%;
            padding: 30px;
            background-color: white;
            display: flex;
            flex-direction: column;
            gap: 20px;
            border-radius: 5px;
            position: relative;
        }
        .btn-x{
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 1.5rem;
            background: none;
            border: none;
            cursor: pointer;
        }
        .register-div{
          text-align: center;
          margin-top: 1.3rem;
        }
     </style>
     <!--- modal -->
     <!-- Parent -->
    <div class='modalcontainer'>
        <!-- modal child -->
        <div class="logincontainer">
            <!-- logincontainer  child --->
            <!--- form --->
        <form action="entering.php" method="POST">
        <button type="button" class="btn-x" onclick="closemodal()">&times;</button>
     
        <!-- email -->
        <div class="mb-1 mt-3">
          <label for="exampleFormControlInput1" class="form-label">Email address</label>
          <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>

        <!--- password -->
        <label for="inputPassword5" class="form-label mb-0">Password</label>
        <input type="password" id="inputPassword5" name="password" class="form-control" aria-describedby="passwordHelpBlock">

        <div id="passwordHelpBlock" class="form-text">
          Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
        </div>

        <div class="col-auto mt-3">
            <button type="submit" name="submit" class="btn btn-primary mb-3 mx-auto d-block" style="width: 80%;">Login</button>
        </div>
        <!--  If the login credentials are incorrect  it moves to same page  --->
        <?php if(isset($_SESSION['login_error'])): ?>
            <p style="color: red;"><?= $_SESSION['login_error'] ?></p>
        <?php endif; ?> 
        <!--  End of login credentials section  --->
    </form>
    <!---register here -->
      <div class="register-div">
        <span>Don't have an account?</span> <a href="form.php" target="_blank">Register here</a>
      </div>
        </div>
    </div>
    
        <!-- Main content section ends -->

        <!-- Footer section starts -->
        <?php include 'footer.php' ?>
        <!-- Footer section ends -->

        <script>
          const modalcontainer = document.querySelector('.modalcontainer')
          const closebtn = document.querySelector('.btn-x');
          function openmodal(){
            modalcontainer.classList.add('open_modal');
            document.body.classList.add('modal-open'); 
          }

          function closemodal(){
            modalcontainer.classList.remove('open_modal');
            document.body.classList.remove('modal-open');
          }
          <?php 
            $shouldAutoOpen = isset($_SESSION['login_error']);
            if ($shouldAutoOpen) {
                unset($_SESSION['login_error']); // Clear it immediately after checking
            }
          ?>
    
          // Then this JavaScript runs with the value from PHP
          document.addEventListener('DOMContentLoaded', function() {
              <?php if ($shouldAutoOpen): ?>
                  openmodal();
              <?php endif; ?>
          });
        </script>
    </body>
</html>