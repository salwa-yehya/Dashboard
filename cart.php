<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['quantity'];
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>FELUX</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/logo3.png">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products shopping-cart">

<h3 class="heading">Shopping Cart</h3>

<div class="box-container cartContainer">

<?php
   $total_price = 0;
   $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $select_cart->execute([$user_id]);
   if($select_cart->rowCount() > 0){
      while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
?>
<!-- __________________ -->
<form action="" method="post" class="box cartItem">
   <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">

   <img class="cartImage" src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
   <div>
   <div class="name"><?= $fetch_cart['name']; ?></div>

   <div class="flex">
      <?php
      $product_cart_id = $fetch_cart['pid'];
      $select_product = $conn->prepare("SELECT * FROM `products` WHERE product_id = $product_cart_id");
      $select_product->execute();
      if($select_product->rowCount() > 0){

         while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
         
         if ($fetch_product['is_sale'] == 1){ ?>

         <div class="price"><span style="display: flex; flex-direction: row;"><del style="text-decoration:line-through; color:silver"><?= $fetch_product['price']; ?>JD</del><ins style="color:red;"> <?=$fetch_product['price_discount'];?>JD</ins> </span></div>

         <?php } 
         else { ?>
<!-- _________ -->
         <div class="name" style="color:red; padding:20px 0px"><?= "JD".$fetch_product['price']; ?></div> 
         <?php } ?>
<!-- _________ -->

         <?php if ($fetch_product['category_id'] != '100'){?>

         <input type="number" name="quantity" class="qty" min="1" max="99" value="<?=$fetch_cart['quantity'];?>">
         <button type="submit" class="fas fa-solid fa-square-check" style="font-size:40px;background-color:none; color:#d39638;" name="update_qty"></button>
         <?php } else { ?>
         <input type="hidden" name="quantity" value="1">
         <?php } } } ?> 
   </div>
   <div class="sub-total"> Sub Total : <span>JD<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span> </div>
   <input type="submit" value="delete item" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete">
         </div>
</form>
<!-- _____________________ -->
<?php
$total_price += $sub_total;
   }
}else{
   echo '<p class="empty">your cart is empty</p>';
}
?>
</div>

<div class="cart-total">
   <p>Total Price : <span>JD<?= $total_price; ?></span></p>
  <a href="checkout.php" class="option-btn <?= ($total_price > 1)?'':'disabled'; ?>">proceed to checkout</a>
   <a href="shop.php" class="btn">continue shopping</a>
   <!-- <a href="cart.php?delete_all" class="delete-btn <?= ($total_price > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all item</a> -->
   
</div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>