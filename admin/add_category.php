<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_category'])){

   $name = $_POST['name'];
   $name = htmlspecialchars($name, ENT_QUOTES);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = htmlspecialchars($image_01, ENT_QUOTES);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   $select_categorys = $conn->prepare("SELECT * FROM `category` WHERE category_name = ?");
   $select_categorys->execute([$name]);

   if($select_categorys->rowCount() > 0){
      $message[] = 'category name already exist!';
   }else{

      $insert_categorys = $conn->prepare("INSERT INTO `category`(category_name, image_01) VALUES(?,?)");
      $insert_categorys->execute([$name, $image_01]);

      if($insert_categorys){
         if($image_size_01 > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            $message[] = 'new category added!';
         }

      }

   }  

};?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
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
				<a href="dashboard.php">
				<i class='bx bxs-cog' ></i>
				<span class="text">Orders</span>
				</a>
			</li>
			<li>
				<a href="add_product.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Add Product</span>
				</a>
			</li>
			<li>
				<a href="product.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Product</span>
				</a>
			</li>
            
			<li class="active">
				<a href="add_category.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Add Category</span>
				</a>
			</li>
		<li>
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
					<h1>Add Category</h1>
				</div>	
			</div>
<!-- ______________________________ -->
<section class="add-products">

   <!-- <h1 class="heading">Add product</h1> -->

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Category name </span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="name">
         </div>
         
        <div class="inputBox">
            <span>Category image </span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
      </div>
      
      <input type="submit" value="Add category" class="add-btn" name="add_category">
   </form>
   <?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div >
            <span>'.$message.'</span>
         </div>
         ';
      }
   }
?>
</section>

<!-- ______________________________ -->
				</div>
			
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script.js"></script>
</body>
</html>