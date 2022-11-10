<?php include_once("header.php")?>

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
    <label for="email" class="col-sm-2 col-form-label text-right">Email</label>
	<div class="col-sm-10">
      <input type="text" class="form-control" name="email"  id="emailRegister" placeholder="Email">
      <small id="emailHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
	</div>
  </div>
  <div class="form-group row">
    <label for="password" class="col-sm-2 col-form-label text-right">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control"  name="password"  id="passwordRegister" placeholder="Password" oninput="OnInput (event)" >
      <small class="form-text text-muted"><span class="text-danger">* Required.</span></small> 
      <div id="passwordHelp" class="form-text text-muted">
		    <a id="digit_fail"  style="color:red">× 8-20 digits</a>
		    <a id="digit_pass"  style="color:green">√ 8-20 digits</a><br/>
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
    <button type="submit" class="btn btn-primary form-control">Register</button>
  </div>
</form>

<div class="text-center">Already have an account? <a href="" data-toggle="modal" data-target="#loginModal">Login</a>

</div>

<?php include_once("footer.php")?>


<script type="text/javascript">

  
$(document).ready(function() {	
	$("#passwordHelp").hide();
	$(document).click(function(){ 
    	$("#passwordHelp").hide(); 
	});



    $("#passwordRegister").click(function(event){
		$("#passwordHelp").toggle();
		event.stopPropagation();	
		if(/^[0-9A-Za-z]{8,20}$/.test($('#passwordRegister').val())){
			$("#digit_pass").show();
			$("#digit_fail").hide();
		}else{
			$("#digit_fail").show();
			$("#digit_pass").hide();
		}

		if(/^[a-zA-Z]*$/.test($('#passwordRegister').val())){
			$("#number_fail").show();
			$("#number_pass").hide();
		}else{
			$("#number_pass").show();
			$("#number_fail").hide();
		}

    if(/^[0-9a-z]*$/.test($('#passwordRegister').val())){
			$("#upper_fail").show();
			$("#upper_pass").hide();
		}else{
			$("#upper_pass").show();
			$("#upper_fail").hide();
		}

    if(/^[0-9A-Z]*$/.test($('#passwordRegister').val())){
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
		if(/^[0-9A-Za-z]{8,20}$/.test($('#passwordRegister').val())){
			$("#digit_pass").show();
			$("#digit_fail").hide();
		}else{
			$("#digit_fail").show();
			$("#digit_pass").hide();
		}

		if(/^[a-zA-Z]*$/.test($('#passwordRegister').val())){
			$("#number_fail").show();
			$("#number_pass").hide();
		}else{
			$("#number_pass").show();
			$("#number_fail").hide();
		}

    if(/^[0-9a-z]*$/.test($('#passwordRegister').val())){
			$("#upper_fail").show();
			$("#upper_pass").hide();
		}else{
			$("#upper_pass").show();
			$("#upper_fail").hide();
		}

    if(/^[0-9A-Z]*$/.test($('#passwordRegister').val())){
			$("#lower_fail").show();
			$("#lower_pass").hide();
		}else{
			$("#lower_pass").show();
			$("#lower_fail").hide();
		}

	});
}



</script>

