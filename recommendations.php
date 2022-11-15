<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include_once("database.php")?>

<div class="container">

<h2 class="my-3">Recommendations for you</h2>

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
  
  // TODO: Perform a query to pull up auctions they might be interested in.
  // pull from bid history
  $buyerid = $_SESSION['user_id'];
  $sql = "SELECT *
          FROM auctions a
          INNER JOIN(
            (SELECT DISTINCT itemID
            FROM bidhistory
            WHERE buyerID = {$buyerid})
            UNION
            (SELECT DISTINCT itemID
            FROM watchlist
            WHERE userID = {$buyerid})
          ) AS t
          ON (t.itemID = a.itemID)";
          // // todo: after status is ready to change, add the constraint where the auction is open
  $r = mysqli_query($connection, $sql);
  $result_fetched = mysqli_fetch_all($r);
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
    $sql .= "OR (a.category = {$content}) ";
  }
  $result_fetched = mysqli_fetch_all(mysqli_query($connection, $sql));
  // // TODO: Loop through results and print them out as list items.

?>



<div class="container mt-5">

<!-- TODO: If result set is empty, print an informative message. Otherwise... -->

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

    print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);
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



<?php include_once("footer.php")?>