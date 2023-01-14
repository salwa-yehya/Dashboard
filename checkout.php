<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};
// ________nameuser________

$select_accounts = $conn->prepare("SELECT * FROM `users` WHERE user_id  = '$user_id'");
$select_accounts->execute();
if($select_accounts->rowCount() > 0){
   while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){
      $NameUser=$fetch_accounts['name'];

   }}
 ?>
 <!-- _______________________ -->
 <?php
if (isset($_POST['order'])) {

   $number = $_POST['number'];
   $email = $_POST['email'];
   $address = 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'];
   $total_products = $_POST['qty'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if ($check_cart->rowCount() > 0) {

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, location, total_quantity, total_price, order_time,number,email) VALUES('$user_id', '$address', '$total_products', '$total_price', NOW(),'$number','$email')");


      $insert_order->execute();

      // $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      // $delete_cart->execute([$user_id]);


      // orders details table تخزين الطلب في ال 

      $con = $conn->prepare("SELECT * FROM orders  ORDER BY order_id DESC"); //  بنعمل للجدول ترتيب تنازلي لحتى نجيب اخر اوردر  
      $con->execute();
      $data = $con->fetch(PDO::FETCH_ASSOC); // بجيب اول صف fetch  من خلال ال 
      $last_id = $data['order_id'];

      $_SESSION['last_order']= $last_id;
      // ______________
      $sql="SELECT products.product_id,products.name,products.price,products.is_sale,products.price_discount,cart.quantity
    FROM products
    INNER JOIN cart 
    ON products.product_id=cart.pid
    WHERE cart.user_id=:id";
      $db = $conn->prepare($sql);
      // __________________
      $db->bindValue(':id', $user_id);
      $db->execute();
      $data = $db->fetchAll(PDO::FETCH_ASSOC);
      foreach ($data as $value) {

         $id = $value['product_id'];
if($value['is_sale']==0){
   $price = $value['price'];
} else{
   $price = $value['price_discount'];
}
        
         $quantity = $value['quantity'];
         $name_pro = $value['name'];

         $sql = "INSERT INTO order_details (order_id, product_id, quantity, price,NameProduct,NameUser) 
        VALUES ('$last_id', '$id', '$quantity', '$price','$name_pro','$NameUser')";
         $insert = $conn->prepare($sql);
         $insert->execute();

      }
      $con = $conn->prepare("DELETE FROM cart WHERE user_id = :id");
      $con->bindValue(':id', $user_id);
      $con->execute();
      echo "<script>window.location='./orders.php'</script>";



      // header("Location:./orders.php");
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>your orders</h3>

   <div class="display-orders">
      <?php
      $total_quantity = 0;
         $total_price = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $total_price += ($fetch_cart['price'] * $fetch_cart['quantity']);
            $total_quantity += $fetch_cart['quantity'];
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= 'JD'.$fetch_cart['price'].' x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $total_price; ?>" value="">
         <div class="grand-total">Total Price : <span>JD<?= $total_price; ?></span></div>
      </div>
<?php $_SESSION['total_price'] = $total_price;
 ?>
      <h3>place your orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="9999999999"  required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Flat number :</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Street name :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" placeholder="e.g. Amman" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" placeholder="e.g. jordan" class="box" maxlength="50" required>
         </div>
      </div>
      <input type="hidden" name="qty" value="<?= $total_quantity ?>">
      <input type="submit" name="order" class="btn <?= ($total_price > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>