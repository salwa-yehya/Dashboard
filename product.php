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
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">FELUX</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="dashboard.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
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
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Users</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Profile</span>
				</a>
			</li>
			<li>
				<a href="#">
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
							<tr>
								<td><p>1</p></td>
								<td>
									<img src="R 3-2.png">
                                </td>
								<td>
									<p>Octagon shape, White, Gold-tone plated</p>
								</td>
								<td><p>Dextera bangle</p></td>
								<td><p>70jd</p></td>
								<td><p>50jd</p></td>
								<td><i class="fa-solid fa-plus"></i></td>
								<td><i class="fa-solid fa-minus"></i></td>
								<td><p>	BRACELETS</p></td>
								<td><i class="fa-solid fa-pen-to-square"></i></td>
								<td><i class="fa-solid fa-trash"></i></td>
								
							</tr>
							<tr>
								<td><p>2</p></td>
								<td>
									<img src="R 3-2.png">
                                </td>
								<td>
									<p>Octagon shape, White, Gold-tone plated</p>
								</td>
								<td><p>Dextera bangle</p></td>
								<td><p>70jd</p></td>
								<td><p>50jd</p></td>
								<td><i class="fa-solid fa-plus"></i></td>
								<td><i class="fa-solid fa-minus"></i></td>
								<td><p>	BRACELETS</p></td>
								<td><i class="fa-solid fa-pen-to-square"></i></td>
								<td><i class="fa-solid fa-trash"></i></td>
								
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