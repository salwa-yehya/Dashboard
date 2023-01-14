<?php

include '../components/connect.php';

session_start();

// التأكد من انه تم تسجيل دخول للادمن من خلال فحص ذاكرة السيشيين
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
};
if(isset($_GET['delete'])){

	// اقرء الاي ديه الي مبعوث مع الرابط 
	   $delete_id = $_GET['delete'];
	
	// هون بدي امسح الصورة تبعت المنتج الي كبسة على الديليت تبعته
	   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE product_id = ?");
	   $delete_product_image->execute([$delete_id]);
	   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
	   unlink('../uploaded_img/'.$fetch_delete_image['image']);
	
	// هون بدي امسح المنتج كامل و بعدين اقله انقلني على صفحة المنتجات عشان ما اضطر اعمل ريفريش للصفحة لما احذف منتج
	   $delete_product = $conn->prepare("DELETE FROM `products` WHERE product_id = ?");
	   $delete_product->execute([$delete_id]);
	   header('location:product.php');
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
<style>
	th {
		width: 20rem;
	}
</style>
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
		<li  >
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
					<h1>Product</h1>
				</div>
				<a href="add_product.php" class="btn-download">
				<i class="fa-solid fa-plus"></i>
				<span class="text">Add New Product</span>
				</a>
			</div>
<!-- ______________________________ -->

<!-- <a href="add_product.php"><button class="add-btn">Add New Product</button></a> -->

			<div class="table-data">
				<div class="order">
					<div class="head">
						<!-- <h3>Product</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i> -->
					</div>
					<table>
					<thead>
					<tr>
					<th >Id</th>
					<th >Image</th>
					<th >Description</th>
					<th >Name</th>
					<th >Price</th>
					<th >discount</th>
					<th >Add Sale</th>
					<th >Remove Sale</th>
					<th >Catecgory</th>
					<th >Edit</th>
					<th >Delete</th>
					</tr>
				</thead>
						<tbody>
						<?PHP $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
            $i=0;
      ?>
    <tr>
      <td ><?php echo $fetch_products['product_id'];?></td>
      <td ><img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="" width="60px"></td>
      <td ><span><?= $fetch_products['details']; ?></td>
      <td ><?php echo $fetch_products['name'];?></td>
      <td >JD<span><?= $fetch_products['price']; ?></td>
      <td style="text-align:center;">JD<span><?= $fetch_products['price_discount']; ?></td>
      <td style="text-align:center;"><a style="color:green;" href="add_sale.php?sale=<?= $fetch_products['product_id']; ?>"><i class="fa-solid fa-square-plus"></i></a></td>
      <td style="text-align:center;"> <a style="color:red;" href="remove_sale.php?removeSale=<?= $fetch_products['product_id']; ?>"><i class="fa-solid fa-square-minus delete1"></i></a></td>
      <?php $product_category = $conn->prepare("SELECT * 
                                        FROM `products`
                                        INNER JOIN `category` ON products.category_id = category.category_id");
                  $product_category->execute();
                  if($product_category->rowCount() > 0){
                     while($fetch_product_category = $product_category->fetch(PDO::FETCH_ASSOC)){ 
                        if($i==0 && $fetch_products['category_id'] == $fetch_product_category['category_id'] ){
                        $i++;
            ?>
      <td ><?php echo $fetch_product_category['category_name'];?></td>
      <?php 
                        }
                     }
                  }
            ?>
      <td style="text-align:center;">
         <a class="editbtn" href="update_product.php?update=<?= $fetch_products['product_id']; ?>" ><i class="fa-solid fa-pen-to-square "></i></a></td>
      <td style="text-align:center;">   
         <a style="color:black; text-align:center;" href="product.php?delete=<?= $fetch_products['product_id']; ?>"  onclick="return confirm('delete this product?');"><i class="fa-solid fa-trash delete1"></i></a>
      </td>
    </tr>
    <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>
						
						</tbody>
					</table>
	<!-- ______________________________ -->
				</div>
			
			</div>
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