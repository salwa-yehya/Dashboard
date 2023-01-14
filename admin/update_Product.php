<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $details = $_POST['details'];
   $category_data = $_POST['category'];
   // foreach($_POST['category'] as $selected){
   //    $category = $selected;
   // }

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ?, category_id = ? WHERE product_id = ?");
   $update_product->execute([$name, $price, $details, $category_data, $pid]);

   $message[] = 'product updated successfully!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE product_id = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../uploaded_img/'.$old_image);
         $message[] = 'image updated successfully!';
      }
   }
}


?>

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
      <?php
      $select_accounts = $conn->prepare("SELECT * FROM `admins` WHERE id = '$admin_id'");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
		<span class="text brand1" >Welcome ,<?= $fetch_accounts['name'] ?> </span>
		<?php
         }}
		 ?>
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
		
			<li class="active">
				<a href="product.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Product</span>
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
				<a href="admin.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Admins</span>
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
					<h1>Update Product</h1>
				</div>
				
			</div>
<!-- ______________________________ -->

<?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE product_id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['product_id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <div class="image-container">
         <div class="main-image">
            <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="" width="100px" height="100px">
         </div>
      </div>
      <span>update name</span>
      <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= $fetch_products['name']; ?>">
      <span>update price</span>
      <input type="number" name="price" required class="box" placeholder="enter product price" value="<?= $fetch_products['price']; ?> ">
      <span>update details</span>
      <textarea name="details" class="box" ><?= $fetch_products['details']; ?></textarea>
      <span>update image</span>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <span>update category</span>
      <select name="category" placeholder="enter product category" class="box" required maxlength="500" cols="60" rows="10">
               <?php
               // اول اشي استدعي كل الاعمدة الي بجدول الكاتيجوري
                     $prepare_category = $conn->prepare("SELECT * FROM `category`");
                     $prepare_category->execute();
               // هون بسأله اذا اصلا فيه بيانات بجدول الكاتيجوري اول , الفانكشن (روو كاونت ) بحسب عدد الصفوف بالجدول فلو كان صفر يعني ما فيه داتا بهادا الجدول

                     if($prepare_category->rowCount() > 0){
                        // اذا الجدول فيه داتا فبقله اقرألي هاي البيانات و اعطيها اسم الي هو فيتش_كاتيجوري
                        while($fetch_category = $prepare_category->fetch(PDO::FETCH_ASSOC)){
               ?>
               <option class="dropdown-item" value="<?= $fetch_category['category_id'] ?>">
                     <?php 
                     // جوا تاج الاوبشن بقله اطبعلي الاي دييه لكل كاتيجوري بالاضافة لاسمها و بسكر التاج بعيدها
                     echo $fetch_category['category_name']; 
                     ?>
               </option>
               <!-- هون بتكون جملة اللوب الاولى تبعت الوايل خلصت , فبرجع بلف كمان مرة و بطلع الكاتيجوري الثانية و هيك -->
               <?php 
               // هاي جملة الايلس تبعت في حال كان عدد الصفوف بالجدول يساوي صفر , طبعا اول قوس كيرلي هو تسكيرة قوس الوايل لانه لازم يكون بعد تاج الاوبشن حتى ما يصير فيه مشاكل بعرض الداتا
                     } } else { echo 'There is no category. Please create one first.';} 
            ?>    
      </select>
      <div class="inputBox">
         <input type="submit" name="update" class="add-btn" value="update">
      </div>
      <br>
      <a href="category.php" class="back"><i class="fa-solid fa-arrow-left"></i> go back</a>

   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">no product found!</p>';
      }
   ?>

			
	<!-- ______________________________ -->
			
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
	<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div >
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>
	<script src="script.js"></script>
</body>
</html>