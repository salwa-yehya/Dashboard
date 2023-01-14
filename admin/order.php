<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
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
				<a href="dashboard.php">
				<i class='bx bxs-cog' ></i>
				<span class="text">Home</span>
				</a>
			</li>
			<li class="active">
				<a href="order.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Orders</span>
				</a>
			</li>
			<!-- <li>
				<a href="add_product.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Add Product</span>
				</a>
			</li> -->
			<li>
				<a href="product.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Product</span>
				</a>
			</li>
<!-- 			
			<li>
				<a href="add_category.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Add Category</span>
				</a>
			</li> -->
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
			<!-- <i class="fa-solid fa-user"></i> -->
			<!-- <input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label> -->
			
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Orders</h1>
				</div>
				
			</div>
<!-- ______________________________ -->


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
					<th >Name</th>	
					<th >Number</th>
					<th >Email</th>
					<th >Total Products</th>
					<th >Total Price</th>
					<th >Order_Time</th>
					<th >Location</th>
					</tr>
				</thead>
						<tbody>
						<?php $select_orders = $conn->prepare("SELECT * 
                                       FROM `orders`
                                       INNER JOIN `users` ON Orders.user_id = users.user_id;");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
    <tr>
      
      <td><?= $fetch_orders['name']; ?></td>
      <td><?= $fetch_orders['number']; ?></td>
      <td><?= $fetch_orders['email']; ?></td>
      <td><?= $fetch_orders['total_quantity']; ?></td>
      <td>JD<?= $fetch_orders['total_price']; ?></td>
      <td><?= $fetch_orders['order_time']; ?></td>
	  <td><?= $fetch_orders['location']; ?></td>
    </tr>

    <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
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