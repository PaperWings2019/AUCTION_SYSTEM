<?php include_once("header.php")?>
<?php require("utilities.php")?>

<style>
table, th, td{
  border-collapse : 'collapse';
  
  border: 1px solid;
}
</style>

<?php
  // Get info from the URL:
  if (!isset($_GET['item_id'])) {
    header("refresh:0;url=browse.php");
    return;
  }
  $item_id = $_GET['item_id'];
  $account_type = $_SESSION['account_type'];
  $user_id = $_SESSION['user_id'];

  // TODO(Done): Use item_id to make a query to the database.

  include_once('database.php');
  $sql = "SELECT * FROM auctions WHERE itemID = $item_id";
  $result = mysqli_query($connection,$sql);
  $row = mysqli_fetch_row($result);
  //var_dump($row);

  // (Done)DELETEME: For now, using placeholder data.
  $title = $row[1];
  $description = $row[2];
  $current_price = $row[8];
  $num_bids = 1;//TODO
  $end_time = new DateTime($row[6]);
  $image = $row[11];
  
  $seller_id = $row[7];
    $get_seller_rating = "SELECT AVG(rating) FROM `ratings` r, `auctions` a WHERE r.itemID = a.itemID AND a.sellerID = $seller_id;";
    if(mysqli_query($connection, $get_seller_rating)){
      $rating_result = mysqli_query($connection, $get_seller_rating);
      $ratings = mysqli_fetch_row($rating_result);
      $rating = $ratings[0];
    } else {
        $rating = false;
    }
    
    $rating = floatval($rating);
$rounded_rating = round($rating, 1);
$rating = ceil($rating);
    

  // TODO(Done): Note: Auctions that have ended may pull a different set of data,
  //       like whether the auction ended in a sal oer was cancelled due
  //       to lack of high-enough bids. Or maybe not.
  
  // Calculate time to auction end:
  $now = new DateTime();
  
  if ($now < $end_time) {
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = ' (in ' . display_time_remaining($time_to_end) . ')';
  }
  
  // TODO: If the user has a session, use it to make a query to the database
  //       to determine if the user is already watching this item.
  if($_SESSION){
    $has_session = true;
  }else{
    $has_session = false;
  }
  $row_check_watchlist = array();
  if($_SESSION['logged_in']) {
    $query_check_watchlist = "SELECT * FROM `watchlist` WHERE `userID`=$user_id and `itemID` = $item_id";
    $result_check_watchlist = mysqli_query($connection,$query_check_watchlist);
    $row_check_watchlist = mysqli_fetch_array($result_check_watchlist);
  }
  if(is_null($row_check_watchlist)){
    $watching = false;
  }else{
  $watching = true;
  }
?>


<div class="container-fluid">

<div class="row m-5 " >
  <div class ="col-sm-3 m-3 " >
    <img  class = "border rounded" src="data:image/jpg;charset=utf8;base64,<?php echo $image ?>" width="100%"/>
  </div>
  <div class ="col-sm ml-5 mr-5">

  <div class="row "> <!-- Row #1 with auction title + watch button -->
    

    <div class="col-sm-8" > <!-- Left col -->
      <h2 class="my-3"><?php echo($title); ?></h2>
    </div>
    <div class="col-sm-4 align-self-center "> <!-- Right col -->
  <?php
    /* The following watchlist functionality uses JavaScript, but could
      just as easily use PHP as in other places in the code */
    if ($now < $end_time && $account_type == 'buyer'):
  ?>
      <div id="watch_nowatch" <?php if ($has_session && $watching) echo('style="display: none"');?> >
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addToWatchlist()">+ Add to watchlist</button>
      </div>
      <div id="watch_watching" <?php if (!$has_session || !$watching) echo('style="display: none"');?> >
        <button type="button" class="btn btn-success btn-sm" disabled>Watching</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="removeFromWatchlist()">Remove watch</button>
      </div>
  <?php endif /* Print nothing otherwise */ ?>
    </div>
  </div>

  <?
    $add_watchlist = $_POST['watch_watching'];
    $sql_add_to_watchlist = "INSERT INTO `watchlist`(`watchlistID`, `itemID`, `userID`) VALUES (1,$item_id,$user_id)";
    $result_add_to_watchlist = mysqli_query($connection,$sql_add_to_watchlist);
    var_dump($result_add_to_watchlist);

  ?>

  <div class="row pt-5 pl-3 pr-5"> <!-- Row #2 with auction description + bidding info -->
    <div class="col-sm-8"> <!-- Left col with item info -->

      <div class="itemDescription">
      <?php echo($description); ?>
      </div>

    </div>

    <div class="col-sm-4"> <!-- Right col with bidding info -->

      <p>
  <?php if ($now > $end_time): ?>
      <strong>This auction ended on <?php echo(date_format($end_time, 'j M H:i')) ?> </strong>
      <!-- TODO(Done): Print the result of the auction here? -->
      <div>
        <?php if ($row[5]>$row[8]):
            echo "This auction ended due to lack of high-enough bids";
        else:
            echo "This item is sold!"; ?>
            <div>
              <?php echo "The winner of this auction is User ". $row['10'];?>
            </div>   
        <?php endif ?>
      </div>
  <?php else: ?>
      Auction ends <?php echo(date_format($end_time, 'j M H:i') . $time_remaining) ?></p>  
      <p class="lead">Current bid: ??<?php echo(number_format($current_price, 2)) ?></p>

      <?php if($account_type == 'buyer'): ?>
        <!-- Bidding form -->
        <form method="POST" action="place_bid.php">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">??</span>
            </div>
          <input type="number" class="form-control" id="bid"  name="bidInput">
          <!-- post the item id to successfully header to the original page -->
          <input type="hidden" name="item_id" value=<?php echo $item_id ?>>
          </div>
          <button type="submit" class="btn btn-primary form-control">Place bid</button>
        </form>
      
      <?php else: ?>
        <div> You must be <button type="button" data-toggle="modal" data-target="#loginModal">logged in</button> as a buyer to place bids </div>
        
      <?php endif ?>
  <?php endif ?>

  <?php    
  if ($rating){
    
    echo('<br/><h5>Seller rating: '.$rounded_rating.'</h5>');
    if($rating=="1"){
      echo('<span class="prevIcon">???</span>
    <span class="icon">???</span>
    <span class="icon">???</span> 
    <span class="icon">???</span>
    <span class="icon">???</span> ');
    } else if($rating=="2"){
      echo('<span class="prevIcon">???</span>
    <span class="prevIcon">???</span>
    <span class="icon">???</span> 
    <span class="icon">???</span>
    <span class="icon">???</span>
     ');
    }else if($rating=="3"){
      echo('<span class="prevIcon">???</span>
    <span class="prevIcon">???</span>
    <span class="prevIcon">???</span>
    <span class="icon">???</span>
    <span class="icon">???</span> ');
    }else if($rating=="4"){
      echo('<span class="prevIcon">???</span>
    <span class="prevIcon">???</span>
    <span class="prevIcon">???</span>
     <span class="prevIcon">???</span>
    <span class="icon">???</span> ');
    }else if($rating=="5"){
      echo('<span class="prevIcon">???</span>
    <span class="prevIcon">???</span>
    <span class="prevIcon">???</span>
    <span class="prevIcon">???</span>
    <span class="prevIcon">???</span>  ');
    }
    
  } else {
    echo('This seller has no ratings');
  }
    
  
  
  ?>

    <?php
        $query = "SELECT buyerID, bidPrice, bidTime FROM `bidHistory` WHERE itemid = $item_id ORDER BY bidID DESC";
        $result_1 = mysqli_query($connection, $query);

      ?>
        
    <table class="table table-striped mt-5">
        <tr>
          <th> Buyer ID </th>
          <th> Bid Price </th>
          <th> Bid Time </th>
        </tr>
        <?php while($row = mysqli_fetch_row($result_1)): ?>
          <tr>
            <th> <?php echo $row[0] ?> </th>
            <th> <?php echo '??'.$row[1] ?> </th>
            <th> <?php echo $row[2] ?> </th>
          </tr>
        <?php endwhile; ?>

        
      </table>  
    
    </div> <!-- End of right col with bidding info -->

  </div> <!-- End of row #2 -->
  </div>
  
  <div class="row">
  
  </div>

</div>











<div>


</div>


<?php include_once("footer.php")?>
<style>

   .icon {
      
      font-size: 50px;
    }

    .prevIcon {
      color: #09f;
      font-size: 50px;
    }
</style>

<script> 
// JavaScript functions: addToWatchlist and removeFromWatchlist.

function addToWatchlist(button) {
  console.log("These print statements are helpful for debugging btw");

  // This performs an asynchronous call to a PHP function using POST method.
  // Sends item ID as an argument to that function.
  $.ajax('watchlist_funcs.php', {
    type: "POST",
    data: {functionname: 'add_to_watchlist', arguments: [<?php echo($item_id);?>]},

    success: 
      function (obj, textstatus) {
        // Callback function for when call is successful and returns obj
        console.log("Success");
        var objT = obj.trim();
 
        if (objT == "success") {
          $("#watch_nowatch").hide();
          $("#watch_watching").show();
        }
        else {
          var mydiv = document.getElementById("watch_nowatch");
          mydiv.appendChild(document.createElement("br"));
          mydiv.appendChild(document.createTextNode("Add to watch failed. Try again later."));
        }
      },

    error:
      function (obj, textstatus) {
        console.log("Error");
      }
  }); // End of AJAX call

} // End of addToWatchlist func

function removeFromWatchlist(button) {
  // This performs an asynchronous call to a PHP function using POST method.
  // Sends item ID as an argument to that function.
  $.ajax('watchlist_funcs.php', {
    type: "POST",
    data: {functionname: 'remove_from_watchlist', arguments: [<?php echo($item_id);?>]},

    success: 
      function (obj, textstatus) {
        // Callback function for when call is successful and returns obj
        console.log("Success");
        var objT = obj.trim();
 
        if (objT == "success") {
          $("#watch_watching").hide();
          $("#watch_nowatch").show();
        }
        else {
          var mydiv = document.getElementById("watch_watching");
          mydiv.appendChild(document.createElement("br"));
          mydiv.appendChild(document.createTextNode("Watch removal failed. Try again later."));
        }
      },

    error:
      function (obj, textstatus) {
        console.log("Error");
      }
  }); // End of AJAX call

} // End of addToWatchlist func
</script>