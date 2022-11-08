<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include_once("database.php")?>

<div class="container">

<h2 class="my-3">My bids</h2>

<?php
  // This page is for showing a user the auctions they've bid on.
  // It will be pretty similar to browse.php, except there is no search bar.
  // This can be started after browse.php is working with a database.
  // Feel free to extract out useful functions from browse.php and put them in
  // the shared "utilities.php" where they can be shared by multiple files.
  
  
  // TODO: Check user's credentials (cookie/session).
  if ($_SESSION['logged_in']==false || $_SESSION['account_type'] != 'buyer') {
    header('Location: browse.php');
  }

  if(isset($_SESSION['id']  )){
    $buyer_id = $_SESSION['id'];
  } else {
    echo 'no id error';
  }
  
  
  // TODO: Perform a query to pull up the auctions they've bidded on.

  $query = " SELECT itemID 
  FROM `bidhistory` 
  WHERE buyerID = $buyer_id
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
    

    $item_id = $infos[0];
    $title = $infos[1];
    $description = $infos[2];
    $current_price = $infos[8];
    $num_bids = 1;
    $end_date = new DateTime($infos[6]); // // todo: make it a valid datetime format

    print_listing_li($item_id, $title, $description, $current_price, $num_bids, $end_date);
  }

?>

<?php include_once("footer.php")?>