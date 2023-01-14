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
		<li class="active" >
				<a href="dashboard.php">
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
			<!-- <i class="fa-solid fa-user"></i> -->
			<!-- <input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label> -->
			
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
				</div>
				
			</div>

			<ul class="box-info">
			
				<!-- ________________________ -->
				<li>
				<?php
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount()
         ?>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3><?= $number_of_products; ?></h3>
						<p>products added</p>
					</span>
				</li>
				<li>
				<?php
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $number_of_users = $select_users->rowCount()
         ?>
		 <i class='bx bxs-group' ></i>
					
					<span class="text">
						<h3><?= $number_of_users; ?></h3>
						<p>normal users</p>
					</span>
				</li>
				<!-- ______________________________ -->
				<?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount()
         ?>
				<li>
				<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3><?= $number_of_orders; ?></h3>
						<p>Number of Orders</p>
					</span>
				</li>
				<?php
            $total_pendings = 0;
            $select_pendings = $conn->prepare("SELECT * FROM `orders`");
            $select_pendings->execute();
            if($select_pendings->rowCount() > 0){
               while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                  $total_pendings += $fetch_pendings['total_price'];
               }
            }
         ?>
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3>JD<?= $total_pendings; ?></h3>
						<p>Total Sales</p>
					</span>
				</li>
			</ul>

<!-- ____________________Recent Orders______________________-- -->
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Orders</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>Order Number</th>
								<th>Date Order</th>
								<th>Total Quantity</th>
								<th>Total Price</th>
							</tr>
						</thead>
						<tbody>
						<?PHP 
							$sql = "SELECT * FROM `orders`";
							$db=$conn->prepare($sql);
							$db->execute();
							if($db->rowCount() > 0){
								while($data= $db->fetch(PDO::FETCH_ASSOC)){   
						
							?>
						<tr>
								<td>
									
									<p><?=$data['order_id'] ?> </p>
								</td>
								<td><?=$data['order_time'] ?></td>
								<td><?=$data['total_quantity'] ?></td>
								<td><?=$data['total_price'] ?></td>
							</tr>
							<?PHP }}?>
							
 
						</tbody>
					</table>
				</div>
				
			</div>
		</main>
		<!-- MAIN -->
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