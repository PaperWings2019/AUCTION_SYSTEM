<?php include_once("header.php")?>


<div class="container my-5">

<?php


    $seller_id = $_SESSION["user_id"];
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
        $auction_title = $_POST['auctionTitle'];    
     }

    
     if(isset($_POST['auctionDetails'])){
        $auction_details = $_POST['auctionDetails'];
     }
        
    if(isset($_POST['auctionCategory'])){
        $auction_category = $_POST['auctionCategory'];
    }
    
    if(isset($_POST['auctionStartPrice'])){
        $start_price = $_POST['auctionStartPrice'];
    }
    


     
    if (!$_POST['auctionReservePrice'] == null){
        $reserve_price = $_POST['auctionReservePrice'];
    } else {
        $reserve_price = 2147483647;
    }
    
    if(isset($_POST['auctionEndDate'])){
        $end_date = $_POST['auctionEndDate'];   
    }
     



    
    

/* TODO #3: If everything looks good, make the appropriate call to insert
            data into the database. */
    
    
    $query = "INSERT INTO `auctions` (`itemID`, `itemName`, `itemDescription`, `category`, `startingPrice`, `reservePrice`, `endDate`, `sellerID`, `highestBid`, `auctionStatus`, `buyerID`) 
    VALUES (NULL, '$auction_title', '$auction_details', '$auction_category', '$start_price', '$reserve_price', '$end_date', '$seller_id', '$start_price', NULL, NULL);";
    
    if(!mysqli_query($connection,$query)){
        die('Error: ' . mysqli_error($connection));
    }
    



// If all is successful, let user know.
    $get_id = "SELECT MAX(itemID) FROM `auctions` WHERE sellerID = $seller_id;";
    $result = mysqli_query($connection,$get_id);
    $item_id = mysqli_fetch_array($result);
    
    $address = "listing.php?item_id=".strval($item_id[0]);
    echo('<div class="text-center">Auction successfully created! <a href='.$address.'>View your new listing.</a></div>');


?>

</div>


<?php include_once("footer.php")?>