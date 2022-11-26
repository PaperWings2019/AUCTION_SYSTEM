<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include_once("database.php")?>  

<div class="container">

<h2 class="my-3">My listings</h2>

<?php
  // This page is for showing a user the auction listings they've made.
  // It will be pretty similar to browse.php, except there is no search bar.
  // This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.
  
  
  // TODO: Check user's credentials (cookie/session).
  if ($_SESSION['logged_in']==false || $_SESSION['account_type'] != 'seller') {
    header('Location: browse.php');
  }

  if(isset($_SESSION['user_id']  )){
    $seller_id = $_SESSION['user_id'];
  } else {
    echo 'no id error';
  }
  
  // TODO: Perform a query to pull up their auctions.

  $query = " SELECT itemID 
  FROM `auctions` 
  WHERE sellerID = $seller_id
  GROUP BY itemID ";

  if (mysqli_query($connection, $query)){
    $item_id_results = mysqli_query($connection, $query);
  } else{
    die('Error: ' . mysqli_error($connection));
  } 
  $result_fetched = mysqli_fetch_all($item_id_results);
    // var_dump($result_fetched);
  $num_results = $item_id_results->num_rows; 
    // var_dump($num_results);
  $results_per_page = 10;
  $max_page = ceil($num_results / $results_per_page);


  
  // TODO: Loop through results and print them out as list items.
  

  foreach ($result_fetched as $index => $item) {
    $new_query = "SELECT * FROM `auctions` WHERE itemID = $item[0]";
    if(mysqli_query($connection, $new_query)){
      $result = mysqli_query($connection, $new_query);
    } else {
      die('Error: ' . mysqli_error($connection));
    }

    $infos = mysqli_fetch_row($result);

    $bids_number_query = "SELECT count(*) FROM `bidhistory` WHERE itemID = $item[0]";
    if(mysqli_query($connection, $new_query)){
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
    print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date, $image);
  }

?>




<nav aria-label="Search results pages" class="mt-5">
  <ul class="pagination justify-content-center">
  
<?php

  if (!isset($_GET['page'])) {
    $curr_page = 1;
  }
  else {
    $curr_page = $_GET['page'];
  }

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