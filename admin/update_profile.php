<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];

   $update_profile_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
   $update_profile_name->execute([$name, $admin_id]);

   $select_accounts = $conn->prepare("SELECT * FROM `admins` WHERE id = $admin_id");
   $select_accounts->execute();
	$fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC);
	$empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

   $prev_pass = $_POST['prev_pass'];
   $old_pass = $_POST['old_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['confirm_pass'];
   if($old_pass == $empty_pass){
      $message[] = 'please enter old password!';
   }elseif($old_pass != $prev_pass){
      $message[] = 'old password not matched!';
   }elseif($new_pass != $confirm_pass){
      $message[] = 'confirm password not matched!';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$confirm_pass, $admin_id]);
         $message[] = 'password updated successfully!';
      }else{
         $message[] = 'please enter a new password!';
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
			<li class="active"> 
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
					<h1>Edit Profile</h1>
				</div>	
			</div>
<!-- ______________________________ -->
<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="messages">
            <span>'.$message.'</span>
			<i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>
<section class="add-products">
   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">

         <div class="inputBox">
		<?php $select_accounts = $conn->prepare("SELECT * FROM `admins` WHERE id = $admin_id");
   $select_accounts->execute();
	$fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC);?>
            <input type="hidden" name="prev_pass" value="<?= $fetch_accounts['password']; ?>">

            <input type="text" name="name" value="<?= $fetch_accounts['name']; ?>" required placeholder="Enter Your Username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
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