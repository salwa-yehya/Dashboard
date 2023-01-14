
<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};
if(isset($_GET['delete'])){

	$delete_id = $_GET['delete'];
	$delete_category_image = $conn->prepare("SELECT * FROM `category` WHERE category_id = ?");
	$delete_category_image->execute([$delete_id]);
	$fetch_delete_image = $delete_category_image->fetch(PDO::FETCH_ASSOC);
	unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
	$delete_category = $conn->prepare("DELETE FROM `category` WHERE category_id = ?");
	$delete_category->execute([$delete_id]);
	$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
	$delete_cart->execute([$delete_id]);
	header('location:category.php');
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
				<a href="oreder.php">
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
					<h1>Category</h1>
				</div>
				<a href="add_category.php" class="btn-download">
				<i class="fa-solid fa-plus"></i>
				<span class="text">Add New Category</span>
				</a>
			</div>
		<!-- _____________ -->


			<div class="table-data">
				<div class="order">
					<table>
					<thead>
					<tr>
					<th >Image</th>
					<th >Name</th>
					<th >Add Sale</th>
					<th >Remove Sale</th>
					<th >Edit</th>
					<th >Delete</th>

					</tr>
				</thead>
						<tbody>
						<?php
      $select_categorys = $conn->prepare("SELECT * FROM `category`");
      $select_categorys->execute();
      if($select_categorys->rowCount() > 0){
         while($fetch_categorys = $select_categorys->fetch(PDO::FETCH_ASSOC)){ 
   ?>
    <tr>
      <th scope="row"><img src="../uploaded_img/<?= $fetch_categorys['image_01']; ?>" width="90px" alt=""></th>
      <td><?= $fetch_categorys['category_name']; ?></td>
	  <!-- ____________ -->

	  <td style="text-align:center;"><a style="color:green;" href="add_sale_category.php?sale_id_category=<?= $fetch_categorys['category_id']; ?>"><i class="fa-solid fa-square-plus"></i></a></td>
      <td style="text-align:center;"> <a style="color:red;" href="remove_sale_category.php?removeSale=<?= $fetch_categorys['category_id']; ?>"><i class="fa-solid fa-square-minus delete1"></i></a></td>

	  <!-- ____________ -->
      <td style="text-align:center;"><a class="editbtn" href="update_category.php?update=<?= $fetch_categorys['category_id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
      <td style="text-align:center;"><a style="color:black;" href="category.php?delete=<?= $fetch_categorys['category_id']; ?>" onclick="return confirm('delete this category?');"><i class="fa-solid fa-trash delete1"></a></td>
    </tr>
    <?php
	     }
		}else{
		   echo '<p class="empty">no categorys added yet!</p>';
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
	

	<script src="script.js"></script>
</body>
</html>