<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/style.css">
   <style>
      .p1 {
         font-size: 2rem;
         color: var(--light-color);
      }
   </style>
</head>

<body>

   <?php include 'components/user_header.php'; ?>


   <div id="abotUs">
      <h1 class="heading1"> Our Story </h1>
      <img src="images/zeena12.png" alt="" width="20%">
   </div>

   <section class="about">
      <p class="p1">Since 1895, founder Daniel mastery of crystal cutting has defined the company. His enduring passion for innovation and design has made it the world’s premier jewelry and accessory brand. Today, the family carries on the tradition of delivering extraordinary everyday style to women around the world. </p>
      <img src="images/aboutim11.jpg" width="40%" id="imagabout1" alt="">
   </section>

   <section class="about">
      <div class="row" id="sect2">

         <div class="image" id="imagea">
            <img src="images/aboutim55.jpg" id="imagabout2" alt="">
         </div>

         <div class="content">

            <p>Explore our new stores. In 2021, Creative Director Giovanna Engelbert's vision comes to life in our new store concept, with an explosive approach to color, size and styling. Come wonder in our imaginary world, where science and magic meet.</p>
            <p>Inspired by decades of creative collaborations and expertise, Swarovski opened its first boutique in the 1980s. The world’s fascination with a new brand of jewellery and crystal figurines began. With the introduction of the annual limited-edition Christmas ornament, a new tradition was born for collectors around the world.</p>
            <p>For over 35 years, felux has captivated the world with unique pieces like the Nirvana cocktail ring, the Slake bracelet and its signature Swiss movement watches. In 2008, the magical 'Crystal Forest' interior design was implemented in stores worldwide, welcoming shoppers to an architectural crystal wonderland.</p>
            <!-- <a href="contact.php" class="btn">contact us</a> -->
         </div>

      </div>
   </section>

   <section class="reviews">

      </div> 

   </section>









   <?php include 'components/footer.php'; ?>

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <script src="js/script.js"></script>

   <script>
      var swiper = new Swiper(".reviews-slider", {
         loop: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 1,
            },
            768: {
               slidesPerView: 2,
            },
            991: {
               slidesPerView: 3,
            },
         },
      });
   </script>

</body>

</html>