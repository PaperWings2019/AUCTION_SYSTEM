<?php include_once("header.php")?>


<div class="container my-5">

<?php



// This function takes the form data and adds the new auction to the database.

/* TODO #1: Connect to MySQL database (perhaps by requiring a file that
            already does this). */
    
    include_once('database.php');
    


/* TODO #2: Extract form data into variables. Because the form was a 'post'
            form, its data can be accessed via $POST['auctionTitle'], 
            $POST['auctionDetails'], etc. Perform checking on the data to
            make sure it can be inserted into the database. If there is an
            issue, give some semi-helpful feedback to user. */
    

    if(isset($_POST['auctionTitle'])){
        print_r($_POST);
     }else{
       echo "no data submitted";}

    $auction_title = $_POST['auctionTitle'];
    $auction_details = $_POST['auctionDetails'];
    $auction_category = $_POST['auctionCategory'];
    $start_price = $_POST['auctionStartPrice'];
    $reserve_price = $_POST['auctionReservePrice'];
    $end_date = $_POST['auctionEndDate'];    



    
    

/* TODO #3: If everything looks good, make the appropriate call to insert
            data into the database. */
    
    $query = "INSERT INTO `auctions` (`itemID`, `itemName`, `itemDescription`, `category`, `startingPrice`, `reservePrice`, `endDate`, `sellerID`, `highestBid`, `auctionStatus`) VALUES (NULL, '$auction_title', '$auction_details', '$auction_category', '$start_price', '$reserve_price', '$end_date',NULL, NULL, NULL);";
    
    if(!mysqli_query($connection,$query)){
        die('Error: ' . mysqli_error($connection));
    }else{

    }



// If all is successful, let user know.
echo('<div class="text-center">Auction successfully created! <a href="FIXME">View your new listing.</a></div>');


?>

</div>


<?php include_once("footer.php")?>