<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};



?>

<?php if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addTOcart'])){
   $product_id = $_POST['product_id'];
   $product_name = $_POST['name'];
   $product_price = $_POST['price'];
   $product_image = $_POST['image'];
   $product_quantity = $_POST['qty'];

   $send_to_cart = $conn->prepare("INSERT INTO `cart` (user_id , pid , name , price , image , quantity)
                                    VALUES (? , ? , ? , ?, ? , ?)"); 
   $send_to_cart->execute([$user_id , $product_id , $product_name , $product_price, $product_image, $product_quantity]);
}?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>FELUX</title>
   <link rel="icon" href="images/logo3.png">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/style.css">
   <link rel="stylesheet" href="./css/comment.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">

   <h1 class="heading">quick view</h1>

   <?php
     $pid = $_GET['pid'];
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE product_id  = ?"); 
     $select_products->execute([$pid]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>

   
   <form action="" method="post" class="box">
      <input type="hidden" name="product_id" value="<?= $fetch_product['product_id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <?php 
      if ($fetch_product['is_sale'] == 1){
         ?>
         <input type="hidden" name="price" value="<?=$fetch_product['price_discount'];?>">
         <?php
      } else {
         ?>
         <input type="hidden" name="price" value="<?=$fetch_product['price'];?>">
         <?php
      }
      ?>      <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">
      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="./uploaded_img/<?= $fetch_product['image']; ?>" alt="">
            </div>
            
         </div>
         <div class="content">
            <div class="name"><?= $fetch_product['name']; ?></div>
            <div class="flex">
            <?php if ($fetch_product['is_sale'] == 1){ ?>

<div class="price"><span><del style="text-decoration:line-through; color:silver">$<?= $fetch_product['price']; ?></del><ins style="color:red; padding:20px 0px"> $<?=$fetch_product['price_discount'];?></ins> </span></div>

<?php } else { ?>

<div class="name" style="color:red;">$<?= $fetch_product['price']; ?></div> <?php } ?>               <input type="number" name="qty" class="qty" min="1" max="99"  value="1">
            </div>
            <div class="details"><?= $fetch_product['details']; ?></div>
            <div class="flex-btn">
               <input type="submit" value="add to cart" class="btn" name="addTOcart">
          
            </div>
         </div>
      </div>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

</section>
<!-- start add comment -->
<section class="Review-view comments">
   <h1 class="heading">Review for products</h1>
        <?php
        $query = "SELECT * FROM review INNER JOIN users 
                ON (review.user_id = users.user_id) WHERE product_id = ? ";
                $stmt = $conn->prepare($query);
                $stmt->execute([$pid]);
        while ($comment = $stmt->fetch()) {
           $comment_id = $comment['review_id'];
         //   $user_id = $comment['user_id'];
           $product_id = $comment['product_id'];
           $comment_date = $comment['review_date'];
           $comment_content = $comment['review_text'];
           $user_name = $comment['name'];
           ?>
           <div class="com">
                  <h2 id="uscom"><?php echo $user_name ?></h2>
                  <p id="datecom"><?php echo $comment_date ?></p>
                  <p id="textcom"><?php echo  $comment_content; ?></p>
                 
            </div><br> <?php } ?>
         <?php if (isset($_POST['submit_comment'])) {
            if (isset($_SESSION['user_id'])) {
               $comment_text = $_POST['comment_text'];
               $sqlInserComment = "INSERT INTO review (user_id,product_id,review_text,review_date) 
               VALUES ('$user_id','$pid','$comment_text ',NOW())";
               $stmt = $conn->query($sqlInserComment);
               $return_to_page =  $_SERVER['PHP_SELF'];
               header("location:quick_view.php?pid=$pid");
            }
         }
         if (!$stmt->execute([$pid])) {
            echo "NO";
         }
         ?>
         <?php
         if(isset($_SESSION['user_id'])){ ?>
            <form action="" method="post" class="addComment">
            <div >
               <div  >
                  <textarea style="width:100%; border:2px solid silver; height: 100px"  class="form-control" name="comment_text" cols="12"  rows="3" placeholder="Add your comment" value=""></textarea>
               </div>
            </div>
            <div class="col-md-12 text-right">
               <button type="submit" name="submit_comment" style="width: 100%;" class="btn submit_btn">
                  Submit Now
               </button>
            </div>
            </form>
         <?php } ?> 
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
