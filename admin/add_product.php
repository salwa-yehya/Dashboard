<?php

include '../components/connect.php';

session_start();

// التأكد من انه تم تسجيل دخول للادمن من خلال فحص ذاكرة السيشيين

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
};

// عند تعبئة فورم اضافة منتج جديد بالاسفل , تأكد من تعبئة البيانات التالي ثم القيام بتشفيرها


if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $price = $_POST['price'];
   $details = $_POST['details'];

   $category_id = $_POST['category'];

// تحميل صورة و تشفيرها

// قراءة اسم الصورة
   $image = $_FILES['image']['name'];
// قراءة حجم الصورة
   $image_size = $_FILES['image']['size'];
// تحديد المسار الموجودة فيه الصورة
   $image_tmp_name = $_FILES['image']['tmp_name'];
// تحديد المسار الجديد للصورة و تذكر انه يجب انشاء مجلد جديد مشابه للاسم المختار في المسار الجديد
   $image_folder = '../uploaded_img/'.$image;


// قراءة جميع المنتجات الموجودة في الداتابيس لتأكد من ان اسم المنتج غير متكرر , جدول المنتجات-عمود الاسم

// علامة الاستفهام تعني انتظار عنصر في فانكشين ال الاكسكيوت , اذا بدك حط المتغير مباشرة ولكن الافضل هو هاي

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

// في حالة ايجاد الاسم اطبع انه المنتج موجود

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exist!';

// غير ذلك , قم برفع المنتج الجديد الى قاعدة البيانات

   }else{

// القيام برفع كافة تفاصيل المنتج التي تم ادخالها و يجب التاكد من ان عدد الاعمدة مساوي لعدد البيانات المراد رفعها

      $insert_products = $conn->prepare("INSERT INTO `products`(name, details, price, image, category_id) VALUES(?,?,?,?,?)");
      $insert_products->execute([$name, $details, $price, $image, $category_id]);


// شرط للتأكد من ان حجم الصورة اقل من 2 ميجا


      if($insert_products){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{

// اذا كان حجم الصورة مسموح , انقل الصورة من المسار القديم الى المسار الجديد
            move_uploaded_file($image_tmp_name, $image_folder);
// متغير بتم عرضه دايما فوق مثل الاشعارات
            $message[] = 'new product added!';
         }

      }

   }  

};
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
					<h1>Add product</h1>
				</div>	
			</div>
<!-- ______________________________ -->
<section class="add-products">
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
   <!-- <h1 class="heading">Add product</h1> -->

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>product name </span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="name">
         </div>
         <div class="inputBox">
            <span>product price </span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price"  name="price">
         </div>
        <div class="inputBox">
            <span>product image </span>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box"  required>
        </div>
         <div class="inputBox">
            <span>product details </span>
            <textarea name="details" placeholder="enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
         <div class="inputBox">
            <span>product category</span>

          <!-- بدي اعمل قائمة فيه الكاتيجوري الي عندي كخيارات -->
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
               <option class="dropdown-item" name="category">
                     <?php 
                     // جوا تاج الاوبشن بقله اطبعلي الاي دييه لكل كاتيجوري بالاضافة لاسمها و بسكر التاج بعيدها
                     echo ($fetch_category['category_id']." - ".$fetch_category['category_name']); 
                     ?>
               </option>
               <!-- هون بتكون جملة اللوب الاولى تبعت الوايل خلصت , فبرجع بلف كمان مرة و بطلع الكاتيجوري الثانية و هيك -->
               <?php 
               // هاي جملة الايلس تبعت في حال كان عدد الصفوف بالجدول يساوي صفر , طبعا اول قوس كيرلي هو تسكيرة قوس الوايل لانه لازم يكون بعد تاج الاوبشن حتى ما يصير فيه مشاكل بعرض الداتا
                     } } else { echo 'There is no category. Please create one first.';} 
            ?>    
            </select>

         </div>
      </div>
      
      <input type="submit" value="add product" class="add-btn" name="add_product"> <br><br>
	  <a href="product.php" class="back"><i class="fa-solid fa-arrow-left"></i>Go Back</a>

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