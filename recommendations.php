<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include_once("database.php")?>

<div class="container">

<h2 class="my-3">Recommendations for you</h2>
<form method="get" action="recommendations.php"  >
  <div class="row" style="padding-bottom: 20px;">
    <div class="col-md-8 pr-0">
      <div class="form-inline">
        <label class="mx-2" for="order_by">Sort by:</label>
        <select class="form-control"  id="order_by" name="order_by">
          <option value="History">Recommended according to your bidding history</option>
          <option value="Watchlist">Recommended according to your Watchlist</option>
          <option selected value="Competitors">Recommended according to your past competitors are currently bidding on</option>
        </select>
      </div>
    </div>
    <div class="col-md-1 px-0">
      <button type="submit" class="btn btn-primary" name="searched" value="true">Search</button>
    </div>
  </div>
</form>
<?php
  // This page is for showing a buyer recommended items based on their bid 
  // history. It will be pretty similar to browse.php, except there is no 
  // search bar. This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.
  // var_dump($_SESSION);
  
  
  // // TODO: Check user's credentials (cookie/session).
  if (!($_SESSION['logged_in'] == true && $_SESSION['account_type'] == 'buyer')) {
    header("Location: browse.php");
  }
  if (!isset($_GET['order_by'])) {
    // // TODO: Define behavior if an order_by value has not been specified.
    $order_by = 'Competitors';
  }
  else {
    $order_by = $_GET['order_by'];
  }

  // TODO: Perform a query to pull up auctions they might be interested in.
  $buyerid = $_SESSION['user_id'];
  if ($order_by =='Watchlist'){
    $sql = "SELECT *
            FROM auctions a
            INNER JOIN(
              (SELECT DISTINCT itemID
              FROM watchlist
              WHERE userID = {$buyerid})
            ) AS t
            ON (t.itemID = a.itemID)";
            // // todo: after status is ready to change, add the constraint where the auction is open
    $r = mysqli_query($connection, $sql);
    $result_fetched = mysqli_fetch_all($r);
    if (empty($result_fetched)) {
      echo "Currently, there are no recommendations for you.";
      $result_fetched = array();
      return;
    } 
    $cat_col = array();
    foreach ($result_fetched as $index => $content) {
      $cat_col[$index] = $content[3];
    }
    $sql = "SELECT *
          FROM (SELECT *
                FROM auctions
                WHERE auctionStatus = 1) AS a
          WHERE 0 ";
    foreach ($cat_col as $index => $content) {
      $sql .= "OR (a.category = '$content') ";
    }
    $result_fetched = mysqli_fetch_all(mysqli_query($connection, $sql));
  } 
  elseif ($order_by=='Competitors'){
      $sql = "SELECT itemID FROM bidhistory WHERE buyerID = {$buyerid} GROUP BY itemID" ;
      $result = mysqli_query($connection,$sql);
      $row_bidding_items = mysqli_fetch_all($result);
      $Bidding_items = $row_bidding_items;
      if (empty($Bidding_items)) {
        echo "Currently, there are no recommendations for you.";
        $result_fetched = array();
        return;
      } 

      $sql = "SELECT buyerID FROM bidhistory WHERE (itemID = {$Bidding_items[0][0]}";
      foreach ($Bidding_items as $Value){
      $sql .= " OR itemID = {$Value[0]}";
      }
      $sql .= " )AND buyerID <> {$buyerid} Group by BuyerID";
      $result = mysqli_query($connection,$sql);
      $Competitors_ID = mysqli_fetch_all($result);
      if (empty($Competitors_ID)) {
        echo "Currently, there are no recommendations for you.";
        $result_fetched = array();
        return;
      } 
      $sql = "SELECT itemID FROM bidhistory WHERE BuyerID = {$Competitors_ID[0][0]}";
      foreach ($Competitors_ID as $Value){
        $sql .= " OR BuyerID = $Value[0]";
      }
        $sql .= " GROUP BY itemID";
        $result = mysqli_query($connection,$sql);
        $Bidding_items_by_Competitors = mysqli_fetch_all($result);

      $all_item_ID = array_merge($Bidding_items,$Bidding_items_by_Competitors);
      $item_ID_Recommended = array_filter ($all_item_ID, function($v) use ($Bidding_items) {return ! in_array($v,$Bidding_items);});
      if (empty($item_ID_Recommended)) {
        echo "Currently, there are no recommendations for you.";
        $result_fetched = array();
        return;
      } 
      $sql = "SELECT * FROM auctions WHERE ("; 
      foreach ($item_ID_Recommended as $value){
        $sql .= " itemID = $value[0] OR";
      }
      $sql = substr($sql,0,strlen($sql)-2);
      $sql .= ") AND auctionStatus = 1";

      $result = mysqli_query($connection,$sql);
      $result_fetched= mysqli_fetch_all($result);
      
  }
  else{
    $sql = "SELECT *
            FROM auctions a
            INNER JOIN(
              (SELECT DISTINCT itemID
              FROM bidhistory
              WHERE buyerID = {$buyerid})
            ) AS t
            ON (t.itemID = a.itemID)";
            // // todo: after status is ready to change, add the constraint where the auction is open
    $r = mysqli_query($connection, $sql);
    $result_fetched = mysqli_fetch_all($r);
    if (empty($result_fetched)) {
      echo "Currently, there are no recommendations for you.";
      $result_fetched = array();
      return;
    } 
    $cat_col = array();
    foreach ($result_fetched as $index => $content) {
      $cat_col[$index] = $content[3];
    }
    $sql = "SELECT *
          FROM (SELECT *
                FROM auctions
                WHERE auctionStatus = 1) AS a
          WHERE 0 ";
    foreach ($cat_col as $index => $content) {
      $sql .= "OR (a.category = '$content') ";
    }
    $result_fetched = mysqli_fetch_all(mysqli_query($connection, $sql));
  }
  // // TODO: Loop through results and print them out as list items.

?>


<!-- Sort column for different type of recommendations -->
<div class="container mt-5" >

<!-- TODO: If result set is empty, print an informative message. Otherwise... -->
<?php 
?>
<ul class="list-group">

<!-- TODO: Use a while loop to print a list item for each auction listing
     retrieved from the query -->

<?php
  foreach ($result_fetched as $index => $infos) {

    $bids_number_query = "SELECT count(*) FROM `bidhistory` WHERE itemID = $infos[0]";
    if(mysqli_query($connection, $sql)){
      $bid_number_result = mysqli_query($connection, $bids_number_query);
      $bid_number_row = mysqli_fetch_row($bid_number_result);
      $num_bids = $bid_number_row[0];
    } else {
        $num_bids = 0;
    }

    $item_id = $infos[0];
    $title = $infos[1];
    $description = $infos[2];
    $current_price = $infos[8];
    
    $end_date = new DateTime($infos[6]); // // todo: make it a valid datetime format

    $image = $infos[11];
    $seller_id = $infos[7];
    $get_seller_rating = "SELECT AVG(rating) FROM `ratings` r, `auctions` a WHERE r.itemID = a.itemID AND a.sellerID = $seller_id;";
    if(mysqli_query($connection, $get_seller_rating)){
      $rating_result = mysqli_query($connection, $get_seller_rating);
      $ratings = mysqli_fetch_row($rating_result);
      $rating = $ratings[0];
    } else {
        $rating = false;
    }
    

    print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date, $image, $rating);
  }

?>

<?php


    /* TODO: Use above values to construct a query. Use this query to 
      retrieve data from the database. (If there is no form data entered,
      decide on appropriate default value/default query to make. */
    
    /* For the purposes of pagination, it would also be helpful to know the
      total number of results that satisfy the above query */


    $num_results = sizeof($result_fetched); // // TODO: Calculate me for real

    $results_per_page = 10;
    $max_page = ceil($num_results / $results_per_page);
    if (!isset($_GET['page'])) {
      $curr_page = 1;
    }
    else {
      $curr_page = $_GET['page'];
    }
?>

</ul>

<!-- Pagination for results listings -->
<nav aria-label="Search results pages" class="mt-5">
  <ul class="pagination justify-content-center">
  
<?php

  // Copy any currently-set GET variables to the URL.
  $querystring = "";
  foreach ($_GET as $key => $value) {
    if ($key != "page") {
      $querystring .= "$key=$value&amp;";
    }
  }
  
  $high_page_boost = max(3 - $curr_page, 0);
  $low_page_boost = max(2 - ($max_page - $curr_page), 0);
  $low_page = max(1, $curr_page - 2 - $low_page_boost);
  $high_page = min($max_page, $curr_page + 2 + $high_page_boost);
  
  if ($curr_page != 1) {
    echo('
    <li class="page-item">
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
        <span aria-hidden="true"><i class="fa fa-arrow-left"></i></span>
        <span class="sr-only">Previous</span>
      </a>
    </li>');
  }
    
  for ($i = $low_page; $i <= $high_page; $i++) {
    if ($i == $curr_page) {
      // Highlight the link
      echo('
    <li class="page-item active">');
    }
    else {
      // Non-highlighted link
      echo('
    <li class="page-item">');
    }
    
    // Do this in any case
    echo('
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
    </li>');
  }
  
  if ($curr_page != $max_page) {
    echo('
    <li class="page-item">
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
        <span aria-hidden="true"><i class="fa fa-arrow-right"></i></span>
        <span class="sr-only">Next</span>
      </a>
    </li>');
  }
?>

  </ul>
</nav>


</div>
<style>
    .prevIcon {
      color: #09f;
    }
</style>



<?php include_once("footer.php")?>