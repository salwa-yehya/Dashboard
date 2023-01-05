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
			<!-- <input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label> -->
			
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Edit Profile</h1>
				</div>	
			</div>
<!-- ______________________________ -->
<section class="add-products">
   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
           
            <input type="text" name="name" value="" required placeholder="Enter Your Username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
             </div>

                 <div class="inputBox">
                 <input type="password" name="old_pass" placeholder="Enter Old Password" maxlength="20"  class="box" >                            
                 </div>

                <div class="inputBox">
                <input type="password" name="new_pass" placeholder="Enter New Password" maxlength="20"  class="box" >                                                                     
                </div>

                <div class="inputBox">
                <input type="password" name="confirm_pass" placeholder="Confirm New Password" maxlength="20"  class="box">                                                                                                                     
                 </div>
                 </div>

                 <input type="submit" value="Update Now" class="add-btn" name="submit">

         </div>
   </form>

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