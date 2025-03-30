<?php session_start();

 ?>
<html>
    <head>
    <title>
        Home Page
    </title>
    </head>
    <body>
        <!-- Menu section starts -->
    
    <?php include 'header.php' ?>
    </div>

        <!-- Menu section ends -->



        <!-- Main content section starts -->
        <section class="section-2">
      <img style="width: 100%; height: 50vh" src="../Images/banner3.jpg" alt="" />
      <div class="search-container">
        <input type="text" class="search-bar" placeholder="Food or Cuisine" />
        <button class="btn-search">Search</button>
      </div>
    </section>
    <main class="featured-product">
      <span style="display: flex; justify-content: center"
        ><h2>Deals of the day</h2></span
      >
      <div class="product-container">
        <div class="featured-product-div">
          <div class="featured-product-div-img">
            <img
              class="featured-img"
              src="https://apps.pokharafooddelivery.com/assets/img/slider/1742374891TmEZBxKvLp.png"
              alt=""
            />
          </div>
          <div class="featured-product-div-title">Momo</div>
        </div>
        <div class="featured-product-div">
          <div class="featured-product-div-img">
            <img
              class="featured-img"
              src="https://apps.pokharafooddelivery.com/assets/img/slider/1727242147e9gnefTc2H.jpeg"
              alt=""
            />
          </div>
          <div class="featured-product-div-title">Momo</div>
        </div>
        <div class="featured-product-div">
          <div class="featured-product-div-img">
            <img
              class="featured-img"
              src="https://apps.pokharafooddelivery.com/assets/img/slider/1737009409exK7tRlgmc.jpeg"
              alt=""
            />
          </div>
          <div class="featured-product-div-title">Momo</div>
        </div>
        <div class="featured-product-div">
          <div class="featured-product-div-img">
            <img
              class="featured-img"
              src="https://apps.pokharafooddelivery.com/assets/img/slider/1736254026fhIGEqUW8R.png"
              alt=""
            />
          </div>
          <div class="featured-product-div-title">Momo</div>
        </div>
        <div class="featured-product-div">
          <div class="featured-product-div-img">
            <img
              class="featured-img"
              src="https://apps.pokharafooddelivery.com/assets/img/slider/1707218083sg19xV3e04.png"
              alt=""
            />
          </div>
          <div class="featured-product-div-title">Momo</div>
        </div>
        <div class="featured-product-div">
          <div class="featured-product-div-img">
            <img
              class="featured-img"
              src="https://apps.pokharafooddelivery.com/assets/img/slider/1719566872no9n76PI8f.png"
              alt=""
            />
          </div>
          <div class="featured-product-div-title">Momo</div>
        </div>
      </div>
    </main>
    <section class="section-3">
      <div class="section-3-container">
        <div class="section-3-banner">
          <img src="../Images/banner2.jpg" alt="" id="banner1" />
        </div>
        <div class="section-3-about">
          <p
            style="font-family: Arial, Helvetica, sans-serif; font-size: 1.1rem"
          >
            GoodFood is the fastest, easiest, and most convenient way to enjoy
            delicious meals from your favorite restaurants—whether you're at
            home, at work, or anywhere you choose. We understand that your time
            is precious, and every moment counts.
          </p>
          <p
            style="font-family: Arial, Helvetica, sans-serif; font-size: 1.1rem"
          >
            That’s why we bring your favorite dishes straight to your
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
         
            height: 70%;
            width: 30%;
            border-radius: 5px;
            
           
           
            
        }
        .logincontainer form{
            /* background-color: red; */
            
        height: 100%;   
        width: 100%;
        padding: 30px;
        background-color: white;
        display: flex;
        flex-direction: column;
        gap: 20px;
        border-radius: 5px;
        position: relative; /

        }
        .btn-x{
            position: absolute;
        top: 10px;
        right:20px;
        font-size: 1.5rem;
        background: none;
        border: none;
        cursor: pointer;


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
        <button type="button"  class="btn-x" onclick="closemodal()">&times;</button>
     
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
    <button type="submit" name="submit" class="btn btn-primary mb-3 mx-auto d-block " style="width: 80%;">Login</button>
  </div>
       
    </form>
        </div>

    </div>
    
        <!-- Main content section ends -->



        <!-- Footer section starts -->

        <!-- Footer section ends -->
         <?php include 'footer.php' ?>

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

       
         </script>
    </body>
</html>
