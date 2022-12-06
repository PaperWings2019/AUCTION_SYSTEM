<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include_once("database.php")?>

<div class="container">

<h2 class="my-3">Watchlist for you</h2>

<?php

if ($_SESSION['logged_in']==false || $_SESSION['account_type'] != 'buyer') {
    header('Location: browse.php');
}

$user_id=$_SESSION['user_id'];
$query = "SELECT `itemID` FROM `watchlist` WHERE userID=$user_id";

if (mysqli_query($connection, $query)){
    $item_id_results = mysqli_query($connection, $query);
  } else{
    die('Error: ' . mysqli_error($connection));
  } 
  $result_fetched = mysqli_fetch_all($item_id_results);
  $num_results = $item_id_results->num_rows; 
  $results_per_page = 10;
  $max_page = ceil($num_results / $results_per_page);
  
  foreach ($result_fetched as $index => $item) {
    $start = 0;
    if (isset($_GET['page'])) {
      $p = intval($_GET['page']);
      $start = ($p - 1) * $results_per_page;
    }
    if ($index < $start || $index >= $start + $results_per_page) {
      continue;
    }
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

    $item_id = $infos[0] ?? null;
    $title = $infos[1] ?? null;
    $description = $infos[2] ?? null;
    $current_price = $infos[8] ?? null;
    $end_date = new DateTime($infos[6] ?? null); 

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

<style>
    .prevIcon {
      color: #09f;
    }
</style>



<?php include_once("footer.php")?>