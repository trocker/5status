<?php


?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>5 Status</title>
      <!-- Bootstrap -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Lato:400,300" rel="stylesheet" type="text/css">
      <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <div class="container">
      <div class="logo">
         <a href="index.php">
            <img src="images/logo.png" alt="logo" width="61">
            <div class="logo-txt"><span>5</span> Status</div>
         </a>
      </div>
      <br> 
      <br> 
      <div class="logo-txt" style="margin-top: 10px; margin-bottom: 10px;">All your tasks in one place.</div>
      <div style="margin-bottom: 20px;" class="logo-txt">Share. Comment. Update Status.</div>
      <div style="margin-bottom: 40px;" class="logo-txt"><u>Register</u></div>
      <form method="post" name="submit" align="center" style="text-align: center; width: 300px; margin: auto;"  onsubmit="register()">
  
         <div class="row" style="text-align:center">   
            <input type="email" class="form-control" name="email" id="email" placeholder="Email - sample@example.com" required></div><br> 
         <div class="row" style="text-align:center">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required></div><br> 
         <div class="row" style="text-align:center">
            <input type="name" class="form-control" name="name" id="name" placeholder="Name" required></div><br> 
         <div class="row" style="text-align:center">
            <center class="form-control"> Select Picture <input type="file" name="register_picture" id="register_picture" align="center" style="width:70px; border-radius:5px; float:left;"></center><br>
            <div class="text-center addbtn-block"><a href="#" class="add-job" onclick="register()">Register</a></div></div><br>

      </form>
 
        
</div>
      

          
      
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
		<script src="js/jquery-1.11.2.min.js"></script> 
		<script src="js/jquery.cookie.js"></script>
		<script src="js/custom.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed --> 
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>
