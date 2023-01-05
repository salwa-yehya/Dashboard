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
			<li class="active">
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
			
			<li>
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
				<a href="#" class="logout">
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
							<tr>
								<td><p>Salwa</p></td>
								<td><p>0771231233</p></td>
								<td><p>salwa@gmail.com</p></td>
								<td>3</td>
								<td>70jd</td>
								<td>29-6</td>
								<td>Aqaba</td>
								
							</tr>
							<tr>
								<td><p>Salwa</p></td>
								<td><p>0771231233</p></td>
								<td><p>salwa@gmail.com</p></td>
								<td>3</td>
								<td>70jd</td>
								<td>29-6</td>
								<td>Aqaba</td>
								
							</tr>
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