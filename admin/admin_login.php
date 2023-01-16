<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $pass = $_POST['pass'];

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboardd.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.png">
    <title>Admin</title>
    <script src="https://kit.fontawesome.com/73358cb070.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="Signup.css"> -->
    <link rel="stylesheet" href="login.css">
    <style>
 
</style>
</head>

<body>
<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

    <!-- <a href="index.html"><img  id="logoLogin" src="logo.png" alt="logo"></a> -->

<form action="" method="post" enctype="multipart/form-data" id="loginForm">

        <h2>login Admin</h2>
    <div class="qqq">
        <input id="inputLoginText" name="name" type="text" placeholder="Your User Name">
     <p id="p1"></p>   
    </div>
    
    <div class="qqq">
        <input id="inputLoginPassword" name="pass" type="password" placeholder="Enter password">
    <p id="p2"></p>
    </div>
    
    
        <input  id="inputButtonLogin" name="submit" type="submit" value="login" >
</form>
    <!-- <script src="signup_in.js"></script> -->
   

</body>
</html>