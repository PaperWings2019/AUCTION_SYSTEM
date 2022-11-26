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
        $auction_title = addslashes($_POST['auctionTitle']);
        if (strlen($auction_title) > 100){
            echo '<script>alert("Auction title must not exceed 100 characters!")</script>';
            echo '<script>window.history.go(-1)</script>';
        }   
     }

    
     if(isset($_POST['auctionDetails'])){
        $auction_details = addslashes($_POST['auctionDetails']);
        if (strlen($auction_details) > 3000){
            echo '<script>alert("Auction description must not exceed 3000 characters!")</script>';
            echo '<script>window.history.go(-1)</script>';
        }
     }
        
    if(isset($_POST['auctionCategory'])){
        $auction_category = $_POST['auctionCategory'];
    }
    
    if(isset($_POST['auctionStartPrice'])){
        $start_price = $_POST['auctionStartPrice'];
        
    }
    


     
    if (!$_POST['auctionReservePrice'] == null){
        $reserve_price = $_POST['auctionReservePrice'];
        if ($reserve_price < $start_price){
            echo '<script>alert("Reserve price must be higher than the start price! ")</script>';
            echo '<script>window.history.go(-1)</script>';
        }
    } 

    
    if(isset($_POST['auctionEndDate'])){
        $end_date = strtotime($_POST['auctionEndDate']);
        if ($end_date < strtotime("now")) {
            echo '<script>alert("You should enter a time that is later than the current time!")</script>';
            echo '<script>window.history.go(-1)</script>';
            
            
            return;
        }
        $end_date = date('Y-m-d H:i:s', $end_date);   
    }

    // var_dump($_POST);
    // var_dump($_FILES);
    // if(isset($_POST['image'])){ 
        
        
        if(!empty($_FILES["image"]["name"])) { 
            // Get file info 
            $fileName = basename($_FILES["image"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
            
            
            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            if(in_array($fileType, $allowTypes)){ 
                $image = $_FILES['image']['tmp_name']; 
                $imgContent = base64_encode(file_get_contents($image)); 
                           
                
            }else{ 
                echo '<script>alert("Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.")</script>';
                echo '<script>window.history.go(-1)</script>';
            }
        
        }else{ 
            echo '<script>alert("Please select an image file to upload.")</script>';
            echo '<script>window.history.go(-1)</script>';
        }
    // } else {
    //     // echo '<script>alert("Please select an image file to upload!")</script>';
    //     // echo '<script>window.history.go(-1)</script>';

    // }
 
     



    
    

/* TODO #3: If everything looks good, make the appropriate call to insert
            data into the database. */
    
    
    $query = "INSERT INTO `auctions` (`itemID`, `itemName`, `itemDescription`, `category`, `startingPrice`, `reservePrice`, `endDate`, `sellerID`, `highestBid`, `auctionStatus`, `buyerID`, `image`) 
    VALUES (NULL, '$auction_title', '$auction_details', '$auction_category', '$start_price', '$reserve_price', '$end_date', '$seller_id', '$start_price', 1, NULL, '$imgContent');";
    
    if(!mysqli_query($connection,$query)){
        $a = "hi";
    
        echo '<script>alert("'.mysqli_error($connection).'")</script>';
        // die('Error: ' . mysqli_error($connection));
        echo '<script>window.history.go(-1)</script>';
        

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