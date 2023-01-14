<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>

<?php             
?>
<!-- _______addTOcart__________ -->
<?php 
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addTOcart'])) {
   $product_id = $_POST['product_id'];
   $product_name = $_POST['name'];
   $product_price = $_POST['price'];
   $product_image = $_POST['image'];
   $product_quantity = $_POST['qty'];
   
$select_cart = $conn->prepare("SELECT * FROM cart where pid=$product_id");
 
            $select_cart->execute();
   $data = $select_cart->fetchAll(PDO::FETCH_ASSOC);
   if ($data) {
    $qq = $data[0]['quantity'];
      $q_u = $qq + 1;
   $xx = $conn->prepare("UPDATE cart set quantity='$q_u'
   WHERE pid='$product_id'");
$xx->execute();
 }else{
        $send_to_cart = $conn->prepare("INSERT INTO `cart` (user_id , pid , name , price , image , quantity)
                                    VALUES (? , ? , ? , ?, ? , ?)");
   $send_to_cart->execute([$user_id, $product_id, $product_name, $product_price, $product_image, $product_quantity]);

}
}?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />


   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <script src="https://kit.fontawesome.com/98bf175dbe.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="css/homnav.css">
   <link rel="icon" href="images/logo3.png">

</head>

<body>

   <?php include 'components/user_headerforonlyhom.php'; ?>

   <div class="home-bg layarsheaders">
      <video autoplay muted loop id="myVideo">
         <source src="images/shovedeo.mp4" type="video/mp4">
      </video>

      <section class="home">


         <div class="swiper home-slider">

            <div class="swiper-wrapper">

               <div class="swiper-slide slide">

                  <div class="content">
                     <h3>Welcome to Your FeLux</h3>
                     <span>Choose Your Favorite Jewellery</span><br>
                     <a href="shop.php" class="btn" style="background-color:#e0b473; color:black;">shop now</a>
                  </div>
               </div>

            </div>

            <div class="swiper-pagination"></div>

         </div>

      </section>

   </div>
<div>
   
</div>

   <section class="category1">

      <div class="zeena">
         <h1 class="heading">Category</h1>
         <img src="images/zeena1.png" alt="" width="30%">
      </div>


      <div class="box-container1">
         <?php $select_catogry = " SELECT * FROM category ";
         $X = $conn->prepare($select_catogry);
         $X->execute();
         while ($c = $X->fetch()) {
            $category_id = $c['category_id'];
            $category_name = $c['category_name'];
            $image_01 = $c['image_01'];


         ?>
            <a href="category.php?category=<?php echo "$category_id" ?>" class="box1">
               <img src="images\<?php echo "$image_01" ?>" alt="" width="70" height="70">
               <h3><?php echo "$category_name" ?></h3>
            </a>

         <?php } ?>

      </div>

   </section>

   <div class="static">
    <section>
      <span class="sta">Up to</span><span class="sta1">40% OFF</span><span class="sta">& FREE SHIPPING </span><br>
      <span class="sta2"><a href="shop.php"  style=" color:#fff;">shop now </a><i class="fa-solid fa-angle-right sta3"></i></span>

    </section>
   </div>

   <section class="home-products">

      <div class="zeena">
         <h1 class="heading">On Sale</h1>
         <img src="images/zeena12.png" alt="" width="30%">
      </div>


      <div class="swiper products-slider">

         <div class="swiper-wrapper">

            <?php
            $select_products = $conn->prepare("SELECT * FROM `products` where is_sale='1'");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
               while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                  <form action="" method="post" class="swiper-slide slide">
                     <input type="hidden" name="product_id" value="<?= $fetch_product['product_id']; ?>">
                     <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                     <?php
                     if ($fetch_product['is_sale'] == 1) {
                     ?>
                        <input type="hidden" name="price" value="<?= $fetch_product['price_discount']; ?>">
                     <?php
                     } else {
                     ?>
                        <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                     <?php
                     }
                     ?>
                     <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">
                     <a href="quick_view.php?pid=<?= $fetch_product['product_id']; ?>"><img src="uploaded_img/<?= $fetch_product['image']; ?>" alt=""></a>
                     <div class="name"><?= $fetch_product['name']; ?></div>
                     <div class="flex">
                        <?php if ($fetch_product['is_sale'] == 1) { ?>

                           <div class="price"><span><del style="text-decoration:line-through; color:silver">JD<?= $fetch_product['price']; ?></del><ins style="color:red; padding:20px 0px"> JD<?= $fetch_product['price_discount']; ?></ins> </span></div>

                        <?php } else { ?>

                           <div class="name" style="color:red;">JD<?= $fetch_product['price']; ?></div> <?php } ?>
                        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                     </div>
                     <input type="submit" value="add to cart" class="btn" name="addTOcart">
                  </form>
            <?php
               }
            } else {
               echo '<p class="empty">no products added yet!</p>';
            }
            ?>

         </div>

         <div class="swiper-pagination"></div>

      </div>

   </section>


   <div class="home2-bg">

<section class="home2">

   <div class="swiper home2-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/brand1-removebg-preview.png" alt="" width="20">
         </div>
         <!-- <div class="content">
            <span>upto 50% off</span>
            <h3>latest Bracelet</h3> 
            <a href="shop.php" class="btn"  >shop now</a>
         </div> -->
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/brand3-removebg-preview.png"  alt="" width="20">
         </div>
         <!-- <div class="content">
            <span>upto 50% off</span>
            <h3>latest Ring</h3>
            <a href="shop.php" class="btn">shop now</a>
         </div> -->
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/brand4-removebg-preview.png"   alt="" width="20">
         </div>
         <!-- <div class="content">
            <span>upto 50% off</span>
            <h3>latest Necklace</h3>
            <a href="shop.php" class="btn">shop now</a>
         </div> -->
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/brand5-removebg-preview.png"   alt="" width="20">
         </div>
         <!-- <div class="content">
            <span>upto 50% off</span>
            <h3>latest Necklace</h3>
            <a href="shop.php" class="btn">shop now</a>
         </div> -->
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/brand6-removebg-preview.png"   alt="" width="20">
         </div>
         <!-- <div class="content">
            <span>upto 50% off</span>
            <h3>latest Necklace</h3>
            <a href="shop.php" class="btn">shop now</a>
         </div> -->
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/brand7-removebg-preview.png"   alt="" width="20">
         </div>
         <!-- <div class="content">
            <span>upto 50% off</span>
            <h3>latest Necklace</h3>
            <a href="shop.php" class="btn">shop now</a>
         </div> -->
      </div>
      
   </div>

      <div class="swiper-pagination1"></div>

   </div>

</section>

</div>







   <?php include 'components/footer.php'; ?>

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <script src="js/script.js"></script>

   <script>
   var swiper = new Swiper(".home2-slider", {
   loop:true,
   centeredSlides: true,
   autoplay: {
     delay: 3000,
     disableOnInteraction: false,
   },
   breakpoints: {
     0: {
       slidesPerView: 1,
     },
     550: {
     slidesPerView: 2,
            },
                     768: {
               slidesPerView: 3,
            },
            // 1024: {
            //    slidesPerView: 4,
            // },
     
     
   },
   pagination: {
            el: ".swiper-pagination1",
            clickable:true,
          },
 });

      var swiper = new Swiper(".products-slider", {
         loop: true,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            550: {
               slidesPerView: 2,
            },
            768: {
               slidesPerView: 2,
            },
            1024: {
               slidesPerView: 3,
            },
         },
      });
   </script>

   <script>
      const header = document.querySelector('.header-for');
      window.onscroll = function() {
         var top = window.scrollY;
         // console.log(top);
         if (top >= 100) {
            header.classList.add('active');
         } else {
            header.classList.remove('active');

         }
      }
   </script>
</body>

</html>