<?php
include_once("database.php");

while(true){
    $now = new DateTime();



    $time_check_query = "SELECT itemID, endDate FROM `auctions` WHERE auctionStatus is null or auctionStatus=1" ;
    $time_check_result = mysqli_query($connection,$time_check_query);
    $time_check_row = mysqli_fetch_all($time_check_result);

    foreach($time_check_row as $value){
        $auction_time = new DateTime($value[1]);
        if($now>$auction_time){          
            $end_auction_query = "UPDATE `auctions` SET auctionStatus= 0 WHERE itemID=$value[0]" ;
            $end_auction_result = mysqli_query($connection,$end_auction_query);

        }
    }


}

?>