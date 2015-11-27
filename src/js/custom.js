// Custom Script for API calls.
//Web app definition
var web = {};
web.dashboard = "dashboard.php";
web.login = "index.php";

//Credentials for this client
var client_user_id, client_auth_key, job_in_focus;

//Mode
//var mode = "_dev.com:8080/src";
var mode = ".com";


//API Definitions

var api = {};
api.login = "http://5status"+mode+"/api/v1/login.php";
api.register = "http://5status"+mode+"/api/v1/register.php";
api.get_cards = "http://5status"+mode+"/api/v1/cards.php";
api.add_cards = "http://5status"+mode+"/api/v1/addCard.php";
api.status = "http://5status"+mode+"/api/v1/changeStatus.php";
api.comment = "http://5status"+mode+"/api/v1/comment.php";
api.invite_user = "http://5status"+mode+"/api/v1/invite_to_card.php";

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
	//Figure out the color of the button 
	var button_color = 'green-c';
	if(card.status.toLowerCase() == 'to-do'){
		button_color = 'red-c';
	}
	if(card.status.toLowerCase() == 'doing by'){
		button_color = 'green-c';
	}
	if(card.status.toLowerCase() == 'queued on'){
		button_color = 'orange-c';
	}
	if(card.status.toLowerCase() == 'done by'){
		button_color = 'blue-c';
	}
	if(card.status.toLowerCase() == 'waiting on'){
		button_color = 'yellow-c';
	}
	if(card.status.toLowerCase() == 'stopped by'){
		button_color = 'red-c';
	}


	//form the card sharers division
	var card_sharer_html = "";
	for(i in card.card_sharers){
		card_sharer_html = card_sharer_html + '<a href="#" class="add-user" title="'+card.card_sharers[i].name+'" data-user="'+card.card_sharers[i].user_id+'"><span class="au-block"><img src="'+card.card_sharers[i].picture+'"   alt="image" class="img-circle user" height="40" width="40"></span></a>';
	}
	//Form the html for the cards
	//**TODO - pad the card title with minimum card title
	return '<div class="col-sm-4" id="'+card.card_id+'"><div class="main"> <div class="title-block"> <div class="media"> <div class="media-body"> <h4 class="title-heading" title="'+card.card_title+'">'+min_title(card.card_title)+'</h4> </div> <div class="media-left counter"> <a href="#"> <div class="count">1</div> </a> </div> </div> </div> <div onclick="changetaskstatus_modal('+card.card_id+')"> <a class="btn btn-sub '+button_color+'">'+card.status+'</a> </div> <div class="add-block">'+ card_sharer_html +'<a href="#" class="add-user" onclick="inviteuser_modal('+card.card_id+')"><span class="au-block"><img src="images/user.jpg"   alt="image" class="img-circle user" height="40" width="40"> <i class="add-user-btn"><img src="images/small-add-icon.png" alt="image"></i></span></a> </div> <div class="clearfix"></div> <div class="tp-comment"> <input type="text" class="form-control" onkeyup="comment_box_event(event, this)" id="'+card.card_id+'" placeholder="Type a comment..."> </div> <div class="commenting"> <div class="media"> <div class="media-left"> <a href="#" class="add-user"><span class="au-block"><img title="'+card.comments[0].name+'" src="'+card.comments[0].picture+'"   alt="image" class="img-circle user" height="40" width="40"></span></a> </div> <div class="media-body"> <div class="what-delay"> <h5>'+card.comments[0].comment+'</h5> </div> <div class="recent-time"><img src="images/watch.png" alt="watch" width="15"> '+time_ago(card.comments[0].created_on)+' ago</div> </div> </div> </div> <div class="tot-comment"><a href="#">'+card.number_of_comments+' Comments <i class="fa fa-angle-right"></i></a></div> </div> </div> '; 
}

function time_ago(timestamp){
	//TODO: Make the time say 2s, 2m, 2h, 2d, 2y ago
	return "2s";
}
function min_title(title){
	//Fix the length of the title
	if(title.length < 60){
		for (var i = title.length - 1; i < 60; i++) {
			title = title + "&nbsp;";
		};
	} else {
		title = title.substring(0,59);
		title = title + "...";
	}
	return title;
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
		window.location.href = web.login;
	} else {
		alert(data.message);
	}
}

function addjob_modal(){
	$('#add_task_modal').modal('show');
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

function changetaskstatus_modal(id){
	job_in_focus = id;
	$('#change_job_status_modal').modal('show');
}

function changeStatus(nextStatus){
	var task_status;

	if(nextStatus=='db'){
		task_status = 'doing by';
	}
	if(nextStatus=='qo'){
		task_status = 'queued on';
	}
	if(nextStatus=='dob'){
		task_status = 'done by';
	}
	if(nextStatus=='sb'){
		task_status = 'stopped by';
	}
	if(nextStatus=='wo'){
		task_status = 'waiting on';
	}

	$.ajax({
	  type: "POST",
	  url: api.status,
	  contentType: "application/json",
	  data: JSON.stringify({ "user_id": client_user_id, "auth_key" : client_auth_key, "card_id" : job_in_focus, "card_status" : task_status }),
	  success: changestatus_successful,
	  dataType: "json"
	});
}

function changestatus_successful(data){
	if(data.status == "success"){
		alert(data.status);
		$('.modal').modal('hide');
		window.location.href = web.dashboard;
	} else {
		alert(data.message);
	}
}


function comment_box_event(e, element){
	if(e.keyCode==13){
		comment_submit(element.value, element.id);
	}
}

function comment_submit(comment, card_id){
	//send the comment over ajax
	$.ajax({
	  type: "POST",
	  url: api.comment,
	  contentType: "application/json",
	  data: JSON.stringify({ "user_id": client_user_id, "auth_key" : client_auth_key, "id" : card_id, "comment" : comment }),
	  success: comment_successful,
	  dataType: "json"
	});
}

function comment_successful(data){
	if(data.status == "success"){
		alert(data.status);
		window.location.href = web.dashboard;
	} else {
		alert(data.message);
	}
}



function inviteuser_modal(id){
	job_in_focus = id;
	$('#invite_user_status_modal').modal('show');
}

function inviteuser(){
	var user = {};
	user.email = $('#inviteuser').val();
	$.ajax({
	  type: "POST",
	  url: api.invite_user,
	  contentType: "application/json",
	  data: JSON.stringify({ "user_id": client_user_id, "auth_key": client_auth_key, "email_invited": user.email, "card_id": job_in_focus}),
	  success: inviteuser_successful,
	  dataType: "json"
	});
}

function inviteuser_successful(data){
	//
	if(data.status == "success"){
		alert(data.status);
		window.location.href = web.dashboard;
	} else {
		alert(data.message);
	}
}