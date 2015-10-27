// Custom Script for API calls.
//Web app definition
var web = {};
web.dashboard = "dashboard.html";
web.login = "login.html";

//API Definitions

var api = {};
api.login = "http://52.89.55.177/5status/src/api/v1/login.php";
api.register = "";
api.get_cards = "";
api.add_cards = "";


function login(){
	var login = {};
	login.email = $('#email').val();
	login.password = $('#password').val();
	$.ajax({
	  type: "POST",
	  url: api.login,
	  data: JSON.stringify({ "email_id": login.email, "password" : login.password }),
	  success: login_successful,
	  dataType: "json"
	});
}

function login_successful(data){
	alert(data);
	//save the cookie
	//redirect to the dashboard
}