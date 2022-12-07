<?php include_once("header.php"); ?>

<div class="container">
<h2 class="my-3">Register new account</h2>

<!-- Create auction form -->
<form method="POST" action="process_registration.php">
  <div class="form-group row">
    <label for="accountType" class="col-sm-2 col-form-label text-right">Registering as a:</label>
	<div class="col-sm-10">
	  <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="accountType" id="accountBuyer" value="buyer" checked>
        <label class="form-check-label" for="accountBuyer">Buyer</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="accountType" id="accountSeller" value="seller">
        <label class="form-check-label" for="accountSeller">Seller</label>
      </div>
      <small id="accountTypeHelp" class="form-text-inline text-muted"><span class="text-danger">* Required.</span></small>
	</div>
  </div>
  <div class="form-group row">
    <label for="username" class="col-sm-2 col-form-label text-right">Username</label>
	<div class="col-sm-10">
      <input type="text" class="form-control" name="username"  id="usernameRegister" placeholder="Username">
      <small id="usernameHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
	</div>
  </div>
  <div class="form-group row">
    <label for="email" class="col-sm-2 col-form-label text-right">Email</label>
	<div class="col-sm-10">
      <input type="email" class="form-control" name="email"  id="emailRegister" placeholder="Email">
      <small id="emailHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
	</div>
  </div>
  <div class="form-group row">
    <label for="password" class="col-sm-2 col-form-label text-right">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control"  name="password"  id="passwordRegister" placeholder="Password" oninput="OnInput (event)" >
      <small class="form-text text-muted"><span class="text-danger">* Required. (A combination of letters and numbers only, special characters unallowed)</span></small> 
      <div id="passwordHelp" class="form-text text-muted">
		    <a id="digit_fail"  style="color:red">× 8-20 characters</a>
		    <a id="digit_pass"  style="color:green">√ 8-20 characters</a><br/>
		    <a id="number_fail" style="color:red">× A number</a>
		    <a id="number_pass" style="color:green">√ A number</a><br/>
        <a id="upper_fail"  style="color:red">× An upper case letter</a>
		    <a id="upper_pass"  style="color:green">√ An upper case letter</a><br/>
        <a id="lower_fail"  style="color:red">× A lower case letter</a>
		    <a id="lower_pass"  style="color:green">√ A lower case letter</a>
	    </div>
    </div>
  </div>
  <div class="form-group row">
    <label for="passwordConfirmation" class="col-sm-2 col-form-label text-right">Repeat password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name='passwordConfirmation'  id="passwordConfirmation" placeholder="Enter password again">
      <small id="passwordConfirmationHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
  </div>
  <div class="form-group row">
    <label for="verification" class="col-sm-2 col-form-label text-right">Verification code</label>
	<div class="col-sm-3">
      <input type="text" required class="form-control" name="verification"  id="verification" placeholder="Enter the verification code" style="width:90%; display:inline; " onchange="codeCheck()"><b id="hiddenMsg"></b>
      <small id="verificationHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
	</div>
	<div class="col-sm-2">
		<button type="button" class="btn btn-primary form-control" onclick="sendEmail()">Send to email</button>
	</div>
  </div>
  <div class="form-group row">
    <button id="submit" type="submit" class="btn btn-primary form-control">Register</button>
  </div>
  
</form>

<div class="text-center">Already have an account? <a href="" data-toggle="modal" data-target="#loginModal">Login</a>

</div>

<?php include_once("footer.php")?>


<script type="text/javascript">

var verifyCode;

$(document).ready(function() {	
	$("#passwordHelp").hide();
	$(document).click(function(){ 
    	$("#passwordHelp").hide(); 
	});



    $("#passwordRegister").click(function(event){
		$("#passwordHelp").toggle();
		event.stopPropagation();	
		if(/^[\w\W]{8,20}$/.test($('#passwordRegister').val())){
			$("#digit_pass").show();
			$("#digit_fail").hide();
		}else{
			$("#digit_fail").show();
			$("#digit_pass").hide();
		}

		if(/^[a-zA-Z_\W]*$/.test($('#passwordRegister').val())){
			$("#number_fail").show();
			$("#number_pass").hide();
		}else{
			$("#number_pass").show();
			$("#number_fail").hide();
		}

    if(/^[0-9a-z_\W]*$/.test($('#passwordRegister').val())){
			$("#upper_fail").show();
			$("#upper_pass").hide();
		}else{
			$("#upper_pass").show();
			$("#upper_fail").hide();
		}

    if(/^[0-9A-Z_\W]*$/.test($('#passwordRegister').val())){
			$("#lower_fail").show();
			$("#lower_pass").hide();
		}else{
			$("#lower_pass").show();
			$("#lower_fail").hide();
		}

	});
	

});



function OnInput (event) {
	$(document).ready(function() {
		if(/^[\w\W]{8,20}$/.test($('#passwordRegister').val())){
			$("#digit_pass").show();
			$("#digit_fail").hide();
		}else{
			$("#digit_fail").show();
			$("#digit_pass").hide();
		}

		if(/^[a-zA-Z_\W]*$/.test($('#passwordRegister').val())){
			$("#number_fail").show();
			$("#number_pass").hide();
		}else{
			$("#number_pass").show();
			$("#number_fail").hide();
		}

    if(/^[0-9a-z_\W]*$/.test($('#passwordRegister').val())){
			$("#upper_fail").show();
			$("#upper_pass").hide();
		}else{
			$("#upper_pass").show();
			$("#upper_fail").hide();
		}

    if(/^[0-9A-Z_\W]*$/.test($('#passwordRegister').val())){
			$("#lower_fail").show();
			$("#lower_pass").hide();
		}else{
			$("#lower_pass").show();
			$("#lower_fail").hide();
		}

	});
}

function sendEmail() {

	if(document.getElementById("emailRegister").value){
		reg_email = document.getElementById("emailRegister").value;
		
		$.ajax('mailValidate.php', {
    	type: "POST",
    	data: {arguments: [reg_email]},
   		success: 
        function (obj, textstatus) {
			console.log("Success");
			var objT = obj.trim();
			
			if (objT == "Senderror") {
				alert("Mail service error, please try later.");
			}
			else if (objT == "Mailerror") {
				alert("Incorrect mail address");
			}else{
				verifyCode = objT.substr(-4);
				alert("Mail successfully sent");
				//alert(verifyCode);
			}
		},
    	error:
     	function (obj, textstatus) {
        	console.log("Error");
      	}
  		}); 
	}else{
		alert("Please input a validate email address");
	}
}


function codeCheck(){
	if(document.getElementById("verification").value == ''){
		document.getElementById("hiddenMsg").innerHTML = '';
	}
	else if(document.getElementById("verification").value == verifyCode){
		document.getElementById("hiddenMsg").style.color = 'green';
		document.getElementById("hiddenMsg").innerHTML = '&ensp;√';
		document.getElementById("submit").disabled="";
	}else{
		document.getElementById("hiddenMsg").style.color = 'red';
		document.getElementById("hiddenMsg").innerHTML = '&ensp;×';
		document.getElementById("submit").disabled="true";
	}

}



</script>

