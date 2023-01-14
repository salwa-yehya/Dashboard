<?php include '../components/connect.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">
    <title>Felux_Dashbord</title>

</head>
<body>
    	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="dashboard.php" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">FELUX</span>
		</a>
	
		<ul class="side-menu top">
        <li >
				<a href="dashboardd.php">
				<i class='bx bxs-cog' ></i>
				<span class="text">Home</span>
				</a>
			</li>
			<li >
				<a href="order.php">
				<i class='bx bxs-cog' ></i>
					<span class="text">Orders</span>
				</a>
			</li>
			
			<li>
				<a href="product.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Product</span>
				</a>
			</li>
           
			
		 <li class="active">
				<a href="category.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Category</span>
				</a>
			</li>
			<li>
			<a href="users.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Users</span>
				</a>
			</li>
			<li>
				<a href="add_new_admin.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Add New Admin</span>
				</a>
			</li>
			<li>
				<a href="update_profile.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Edit Profile</span>
				</a>
			</li>
		</ul>
		
			<ul class="side-menu">
			<li>
				<a href="../components/admin_logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->
	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<!-- <input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label> -->
			
		</nav>
		<!-- NAVBAR -->
			<!-- MAIN -->
			<main>
			<div class="head-title">
				<div class="left">
					<h1>Add Sale</h1>
				</div>
				
			</div>
    <!-- <section class="update-product">
        <h1 class="heading">Sale Form</h1>  -->
        <section class="content">
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

           <span>Category Name</span>
           <input type="text" name="name" required class="box" maxlength="100" value="<?= $fetch_categorys['category_name']; ?>" >

            <br><br>
            
            <span>New price</span>
            <input type="number" name="new_price" required class="box" placeholder="Enter Discount Percentage">

			<br><br>

            <div class="flex-btn">
                <input type="submit" name="update" class="add-btn" value="ADD"><br><br>
                <a href="category.php" class="back"><i class="fa-solid fa-arrow-left"></i>Go Back</a>

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