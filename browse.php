<?php include_once("header.php")?>
<?php require("utilities.php")?>
<?php include_once("database.php")?>

<div class="container">

<h2 class="my-3">Browse listings</h2>

<div id="searchSpecs">
<!-- When this form is submitted, this PHP page is what processes it.
     Search/sort specs are passed to this page through parameters in the URL
     (GET method of passing data to a page). -->
<form method="get" action="browse.php"  >
  <div class="row">
    <div class="col-md-5 pr-0">
      <div class="form-group">
        <label for="keyword" class="sr-only">Search keyword:</label>
	    <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-transparent pr-0 text-muted">
              <i class="fa fa-search"></i>
            </span>
          </div>
          <input type="text" class="form-control border-left-0"   name="keyword" id="keyword" placeholder="Search for anything">
        </div>
      </div>
    </div>
    <div class="col-md-3 pr-0">
      <div class="form-group">
        <label for="cat" class="sr-only">Search within:</label>
        <select class="form-control"  id="cat" name="cat">
          <option selected value="all">All categories</option>
          <?php
            // // todo: get all categories and echo the corresponding option
            $sql_cat = "SELECT DISTINCT a.category
                        FROM auctions a
                        ";
            $result_cat = mysqli_query($connection, $sql_cat);
            $result_cat_fetched = mysqli_fetch_all($result_cat);
            
            foreach ($result_cat_fetched as $index => $cats) {
              echo "<option value=$cats[0]>$cats[0]</option>";
            }
          ?>
        </select>
      </div>
    </div>
    <div class="col-md-3 pr-0">
      <div class="form-inline">
        <label class="mx-2" for="order_by">Sort by:</label>
        <select class="form-control"  id="order_by" name="order_by">
          <option selected value="pricelow">Price (low to high)</option>
          <option value="pricehigh">Price (high to low)</option>
          <option value="datelow">Soonest expiry</option>
          <option value="datehigh">Slowest expiry</option>
        </select>
      </div>
    </div>
    <div class="col-md-1 px-0">
      <button type="submit" class="btn btn-primary" name="searched" value="true">Search</button>
    </div>
  </div>
</form>
</div> <!-- end search specs bar -->


</div>

<?php
  // echo var_dump($_GET);
  // Retrieve these from the URL
  // var_dump($result_cat_fetched);
  if (!isset($_GET['keyword'])) {
    // // TODO: Define behavior if a keyword has not been specified.
    $keyword = '';
    
    // todo: the default value may be the recommendation
  }
  else {
    $keyword = $_GET['keyword'];
  }

  if (!isset($_GET['cat'])) {
    // // TODO: Define behavior if a category has not been specified.
    $category = 'all';
  }
  else {
    $category = $_GET['cat'];
  }
  if (!isset($_GET['order_by'])) {
    // // TODO: Define behavior if an order_by value has not been specified.
    $order_by = 'pricelow';
  }
  else {
    $order_by = $_GET['order_by'];
  }

  if (!isset($_GET['page'])) {
    $curr_page = 1;
  }
  else {
    $curr_page = $_GET['page'];
  }

    /* TODO: Use above values to construct a query. Use this query to 
      retrieve data from the database. (If there is no form data entered,
      decide on appropriate default value/default query to make. */
    
    /* For the purposes of pagination, it would also be helpful to know the
      total number of results that satisfy the above query */
    $sql = "SELECT DISTINCT *
            FROM auctions a
            WHERE (a.itemDescription LIKE '%$keyword%'
            OR a.itemName LIKE '%$keyword%') ";
    if ($category != 'all') {
      $sql .= "AND a.category = '$category'";
    }
    if ($order_by == "pricelow") {
      $sql .= "ORDER BY a.highestBid ASC";
    } elseif ($order_by == 'pricehigh') {
      $sql .= "ORDER BY a.highestBid DESC";
    } elseif ($order_by == 'datehigh') {
      $sql .= "ORDER BY a.endDate DESC";
    } elseif ($order_by == 'datelow') {
      $sql .= "ORDER BY a.endDate ASC";
    } 
    $result = mysqli_query($connection, $sql);
    // var_dump($result);
    $result_fetched = mysqli_fetch_all($result);
    // var_dump($result_fetched);
    $num_results = $result->num_rows; // // TODO: Calculate me for real
    // var_dump($num_results);
    $results_per_page = 10;
    $max_page = ceil($num_results / $results_per_page);
?>

<div class="container mt-5">

<!-- TODO: If result set is empty, print an informative message. Otherwise... -->

<ul class="list-group">

<!-- TODO: Use a while loop to print a list item for each auction listing
     retrieved from the query -->

<?php
  foreach ($result_fetched as $index => $infos) {

    $bids_number_query = "SELECT count(*) FROM `bidhistory` WHERE itemID = $infos[0]";
    if(true){
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