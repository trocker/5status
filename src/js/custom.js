// Custom Script for API calls.
//Web app definition
var web = {};
web.dashboard = "dashboard.php";
web.login = "index.php";

//Credentials for this client
var client_user_id, client_auth_key;

//Mode
//var mode = "_dev";
//var mode = "";


//API Definitions

var api = {};
api.login = "http://5status"+mode+".com:8080/src/api/v1/login.php";
api.register = "http://5status"+mode+".com:8080/src/api/v1/register.php";
api.get_cards = "http://5status"+mode+".com:8080/src/api/v1/cards.php";
api.add_cards = "http://5status"+mode+".com:8080/src/api/v1/addCard.php";


function login(){
	var login = {};
	login.email = $('#email').val();
	login.password = $('#password').val();
	$.ajax({
	  type: "POST",
	  url: api.login,
	  contentType: "application/json",
	  data: JSON.stringify({ "email_id": login.email, "password" : login.password }),
	  success: login_successful,
	  dataType: "json"
	});
}

function login_successful(data){
	if(data.status == "success"){
		alert(data.status);
		$.cookie("user_id", data.user_id);
		$.cookie("auth_key", data.auth_key);
		window.location.href = web.dashboard;
	} else {
		alert(data.message);
	}
}

function dashboard(){
	//Take the cookies stored
	client_user_id = $.cookie("user_id");
	client_auth_key = $.cookie("auth_key");

	//Make a query to get all the cards
	$.ajax({
	  type: "POST",
	  url: api.get_cards,
	  contentType: "application/json",
	  data: JSON.stringify({ "user_id": client_user_id, "auth_key" : client_auth_key }),
	  success: display_dashboard,
	  dataType: "json"
	});
}

function display_dashboard(data){
	if(data.status == "success"){
		//Display cards
		alert(data.status);
		var task_cards_html = '';
		$.each(data.cards, function(index, value){
			//Call make card
			task_cards_html = task_cards_html + make_card(value);
		});
		$('#dashboard_card_area').html(task_cards_html);
	}
}

function make_card(card){
	//Form the html for the cards
	//**TODO - pad the card title with minimum card title
	return '<div class="col-sm-4" id="'+card.card_id+'"><div class="main"> <div class="title-block"> <div class="media"> <div class="media-body"> <h4 class="title-heading">'+card.card_title+'</h4> </div> <div class="media-left counter"> <a href="#"> <div class="count">1</div> </a> </div> </div> </div> <div> <a href="index-green.html" class="btn btn-sub green-c">'+card.status+'</a> </div> <div class="add-block"> <a href="#" class="add-user"><span class="au-block"><img src="images/user.jpg"   alt="image" class="img-circle user" height="40"> <i class="add-user-btn"><img src="images/small-add-icon.png" alt="image"></i></span></a> <a href="#" class="add-user"><span class="au-block"><img src="images/user.jpg"   alt="image" class="img-circle user" height="40"> <i class="add-user-btn"><img src="images/small-add-icon.png" alt="image"></i></span></a> <a href="#" class="add-user"><span class="au-block"><img src="images/user.jpg"   alt="image" class="img-circle user" height="40"> <i class="add-user-btn"><img src="images/small-add-icon.png" alt="image"></i></span></a> </div> <div class="clearfix"></div> <div class="tp-comment"> <input type="text" class="form-control" placeholder="Type a comment..."> </div> <div class="commenting"> <div class="media"> <div class="media-left"> <a href="#" class="add-user"><span class="au-block"><img src="images/user.jpg"   alt="image" class="img-circle user" height="40"> <i class="add-user-btn"><img src="images/small-add-icon.png" alt="image"></i></span></a> </div> <div class="media-body"> <div class="what-delay"> <h5>What’s the delay?</h5> </div> <div class="recent-time"><img src="images/watch.png" alt="watch" width="15"> 2s ago</div> </div> </div> </div> <div class="tot-comment"><a href="#">30 Comments <i class="fa fa-angle-right"></i></a></div> </div> </div> '; 
}


function register(){
	var register = {};
	register.email = $('#email').val();
	register.password = $('#password').val();
	register.name = $('#name').val();
	$.ajax({
	  type: "POST",
	  url: api.register,
	  contentType: "application/json",
	  data: JSON.stringify({ "email_id": register.email, "password" : register.password, "name" : register.name }),
	  success: register_successful,
	  dataType: "json"
	});
}

function register_successful(data){
	if(data.status == "success"){
		alert(data.status);
		//window.location.href = web.login;
	} else {
		alert(data.message);
	}
}

function addjob_modal(){
	$('.modal').modal('show');
}

function addjob(){
	var job = {};
	job.title = $('#job').val();
	$.ajax({
	  type: "POST",
	  url: api.add_cards,
	  contentType: "application/json",
	  data: JSON.stringify({ "user_id": client_user_id, "auth_key": client_auth_key, "card_title": job.title }),
	  success: addjob_successful,
	  dataType: "json"
	});
}

function addjob_successful(data){
	if(data.status == "success"){
		alert(data.status);
		$('.modal').modal('hide');
		window.location.href = web.dashboard;
	} else {
		alert(data.message);
	}
}