<?php include '../components/connect.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sale category</title>

</head>
<body>
    <section class="update-product">
        <h1 class="heading">Sale Form</h1> 
        <form action="" method="post" enctype="multipart/form-data">
            
          <?php  $id = $_GET['sale_id_category'];
// __________________
$select_categorys = $conn->prepare("SELECT * FROM `category` WHERE category_id='$id' ");
      $select_categorys->execute();
      $fetch_categorys = $select_categorys->fetch();


    //   ______________

    ?>
          <img src="../uploaded_img/<?= $fetch_categorys['image_01']; ?>" width="90px" alt="">
          <br>

            <span><h4>Category Name : </h4></span><span><?= $fetch_categorys['category_name']; ?></span>
            <br>
            
            <br>
            <span></span>
            <input type="number" name="new_price" required class="box" placeholder="enter discount percentage">
            <div class="flex-btn">
                <input type="submit" name="update" class="btn" value="ADD">
                <a href="category.php" class="option-btn">Go Gack</a>
            </div>
        </form>
        
</body>
</html>
<?PHP



?>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['new_price'])){
    $id = $_GET['sale_id_category'];
$select_products = $conn->prepare("SELECT * FROM `products` WHERE category_id ='$id'");
      $select_products->execute();

    if ($select_products->rowCount() > 0) {
        while ($slect_pro = $select_products->fetch(PDO::FETCH_ASSOC)) {
            $id_pro = $slect_pro['product_id'];
            $old_prise = $slect_pro['price'];
            $precent = $_POST['new_price'] / 100;
            $precent *= $old_prise;
            $discount_price = $old_prise - $precent;
            $xx = $conn->prepare("UPDATE products set price_discount='$discount_price', is_sale='1'
                                    WHERE product_id='$id_pro'");
            $xx->execute();

        }
    }

    header('location:category.php');
}