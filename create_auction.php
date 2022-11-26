<?php include_once("header.php")?>

<?php
  
  
  if ($_SESSION['logged_in']==false || $_SESSION['account_type'] != 'seller') {
    header('Location: browse.php');
  }

?>

<style>
.errorMessage {
  background-color: pink;
  width: 240px;
  padding-left: 10px;
  padding-right: 10px;
  padding-top: 5px;
  padding-bottom: 5px;
  margin-left: 107px;
  visibility: hidden;
  border-radius: 10px;
  position: relative;
  float: left;
}
.errorMessage.top-arrow:after {
  color: pink;
  content: " ";
  position: absolute;
  right: 90px;
  top: -15px;
  border-top: none;
  border-right: 10px solid transparent;
  border-left: 10px solid transparent;
  border-bottom: 15px solid pink;
}
</style>
<div class="container">

<!-- Create auction form -->
<div style="max-width: 800px; margin: 10px auto">
  <h2 class="my-3">Create new auction</h2>
  <div class="card">
    <div class="card-body">
      <!-- Note: This form does not do any dynamic / client-side / 
      JavaScript-based validation of data. It only performs checking after 
      the form has been submitted, and only allows users to try once. You 
      can make this fancier using JavaScript to alert users of invalid data
      before they try to send it, but that kind of functionality should be
      extremely low-priority / only done after all database functions are
      complete. -->
      <form name="auctionForm" method="POST" action="create_auction_result.php" onsubmit = "return validateForm()" enctype="multipart/form-data">
        <div class="form-group row">
          <label for="auctionTitle" class="col-sm-2 col-form-label text-right">Title of auction</label>
          <div class="col-sm-10">
            <input name="auctionTitle" type="text" class="form-control" id="auctionTitle" placeholder="e.g. Black mountain bike">
            <small id="titleHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> A short description of the item you're selling, which will display in listings.</small>
            <p class = "errorMessage top-arrow" > </p>
          </div>
        </div>
        <div class="form-group row">
          <label for="auctionDetails" class="col-sm-2 col-form-label text-right">Details</label>
          <div class="col-sm-10">
            <textarea name="auctionDetails" class="form-control" id="auctionDetails" rows="4"></textarea>
            <small id="detailsHelp" class="form-text text-muted">Full details of the listing to help bidders decide if it's what they're looking for.</small>
          </div>
        </div>
        <div class="form-group row">
          <label for="auctionCategory" class="col-sm-2 col-form-label text-right">Category</label>
          <div class="col-sm-10">
            <select name="auctionCategory" class="form-control" id="auctionCategory">
              <option selected>Choose...</option>
              <option value="Art">Art</option>
              <option value="Book">Book</option>
              <option value="Clothes">Clothes</option>
              <option value="Electronics">Electronics</option>
              <option value="Music & DVDs">Music & DVDs</option>
              <option value="Toys and Games">Toys and Games</option>
              <option value="Others">Others</option>
            </select>
            <small id="categoryHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Select a category for this item.</small>
            <p class = "errorMessage top-arrow" > </p>
          </div>
        </div>
        <div class="form-group row">
          <label for="auctionStartPrice" class="col-sm-2 col-form-label text-right">Starting price</label>
          <div class="col-sm-10">
	        <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">£</span>
              </div>
              <input name="auctionStartPrice" type="number" class="form-control" id="auctionStartPrice">
              
            </div>
            <small id="startBidHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Initial bid amount.</small>
            <p class = "errorMessage top-arrow" > </p>
          </div>
        </div>
        <div class="form-group row">
          <label for="auctionReservePrice" class="col-sm-2 col-form-label text-right">Reserve price</label>
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">£</span>
              </div>
              <input name="auctionReservePrice" type="number" class="form-control" id="auctionReservePrice">
            </div>
            <small id="reservePriceHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Must be higher than starting price. Auctions that end below this price will not go through. This value is not displayed in the auction listing.</small>
            <span class = "errorMessage top-arrow" > </span>
            <span class = "errorMessage top-arrow" > </span>
          </div>
        </div>
        <div class="form-group row">
          <label for="auctionEndDate" class="col-sm-2 col-form-label text-right">End date</label>
          <div class="col-sm-10">
            <input name="auctionEndDate" type="datetime-local" class="form-control" id="auctionEndDate">
            <small id="endDateHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Day for the auction to end.</small>
            <p class = "errorMessage top-arrow" > </p>
          </div>
        </div>

        <div class="form-group row">
          <label for="uploadImage" class="col-sm-2 col-form-label text-right">Upload Image</label>
          <div class="col-sm-10">
            <input type="file" name="image" id="uploadImage">
            <small id="uploadImage" class="form-text text-muted"> <span class="text-danger">* Required.</span> Allowed file types: jpg, png, jpeg</small>
            <p class = "errorMessage top-arrow" > </p>
          </div>
        </div>

        

        <button type="submit" class="btn btn-primary form-control" value="Upload">Create Auction</button>
        
      </form>
    </div>
  </div>
</div>

</div>


<script>
  function validateForm() {
    var nameVal_1 = document.forms["auctionForm"]["auctionTitle"].value;
    var nameVal_2 = document.forms["auctionForm"]["auctionCategory"].value;
    var nameVal_3 = document.forms["auctionForm"]["auctionStartPrice"].value;
    var nameVal_4 = document.forms["auctionForm"]["auctionReservePrice"].value;
    var nameVal_5 = document.forms["auctionForm"]["auctionEndDate"].value;
    var nameVal_6 = document.forms["auctionForm"]["uploadImage"].value;



  if(nameVal_1 == null || nameVal_1 == "") {
    document.getElementsByClassName( "errorMessage" )[0].style.visibility = "visible";
    document.getElementsByClassName( "errorMessage" )[0].innerHTML = "Please Fill in the Auction Title!";
    return false;
  } else if (nameVal_2 == null || nameVal_2 == "Choose..."){
    removeError(1)
    document.getElementsByClassName( "errorMessage" )[1].style.visibility = "visible";
    document.getElementsByClassName( "errorMessage" )[1].innerHTML = "Please Select a category!";
    return false;
  } else if (nameVal_3 == null || nameVal_3 == ""){
    removeError(2)
    document.getElementsByClassName( "errorMessage" )[2].style.visibility = "visible";
    document.getElementsByClassName( "errorMessage" )[2].innerHTML = "Please Fill in the starting price!";
    return false;
  } else if (nameVal_4 == null || nameVal_4 == ""){
    document.getElementsByClassName( "errorMessage" )[3].style.visibility = "visible";
    removeError(3)
    document.getElementsByClassName( "errorMessage" )[3].innerHTML = "Please Fill in the reserve price!";
    return false;
  }else if (parseInt(nameVal_4) <= parseInt(nameVal_3)){
    removeError(4)
    document.getElementsByClassName( "errorMessage" )[4].style.visibility = "visible";
    document.getElementsByClassName( "errorMessage" )[4].innerHTML = "The reserve price must be higher than the starting price!";
    return false;
  }else if (nameVal_5 == null || nameVal_5 == ""){
    removeError(5)
    document.getElementsByClassName( "errorMessage" )[5].style.visibility = "visible";
    document.getElementsByClassName( "errorMessage" )[5].innerHTML = "Please Fill in the End date!";
    return false;
  }else if (nameVal_5 == null || nameVal_5 == ""){
    removeError(5)
    document.getElementsByClassName( "errorMessage" )[5].style.visibility = "visible";
    document.getElementsByClassName( "errorMessage" )[5].innerHTML = "Please Fill in the End date!";
    return false;
  } else {
  return true;
  }
  }


  function removeError(index){
    for (let i = 0; i<index; i++){
      document.getElementsByClassName( "errorMessage" )[i].style.visibility = "hidden";
    }
  }

</script>


<?php include_once("footer.php")?>