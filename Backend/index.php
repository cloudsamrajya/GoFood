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
        <!-- Main content section ends -->



        <!-- Footer section starts -->

        <!-- Footer section ends -->
         <?php include 'footer.php' ?>

    </body>
</html>
