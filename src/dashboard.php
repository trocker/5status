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
<div class="modal fade" id="change_job_status_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center" style="color:#888;">Change Task Status</h4>
      </div>
      <div class="modal-body">
          <div class="row" style="text-align:center">   
            <a href="index-green.html" class="btn btn-sub green-c" onclick="changeStatus('db')">Doing By</a>
            <a href="index-orange.html" class="btn btn-sub orange-c" onclick="changeStatus('qo')">Queued On</a>
            <a href="index-red.html" class="btn btn-sub red-c" onclick="changeStatus('sb')">Stopped By</a>
            <a href="index-blue.html" class="btn btn-sub blue-c" onclick="changeStatus('dob')">Done By</a>
            <a href="index-yellow.html" class="btn btn-sub yellow-c" onclick="changeStatus('wo')">Waiting On</a>
          </div><br>
      </div>
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="add_task_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center" style="color:#888;">Add Task</h4>
      </div>
      <div class="modal-body">
          <div class="row" style="text-align:center">   
            <input type="text" class="form-control" name="job" id="job" style="height:50px;" placeholder="Example - Send an email account to all students&hellip;">
          </div><br>
      </div>
      <div class="modal-footer">
        <div class="text-center addbtn-block"><a href="#" class="add-job" onclick="addjob()"><img src="images/big-add-icon.png" height="22" alt="icon">Add</a></div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="container">
  <div class="logo">
     <a href="index.php">
        <img src="images/logo.png" alt="logo" width="61">
        <div class="logo-txt"><span>5</span> Status</div>
     </a>
  </div>
  <div class="text-center addbtn-block" onclick="addjob_modal()"><a href="#" class="add-job"><img src="images/big-add-icon.png" height="22" alt="icon"> Add Job</a></div> 
  <div class="row" id="dashboard_card_area"></div>  
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.2.min.js"></script> 
<script src="js/jquery.cookie.js"></script>
<script src="js/custom.js"></script>
<script>$(document).ready(function(){dashboard();});</script>
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.min.js"></script>
</body>
</html>
