<?php
include_once("database.php");
<<<<<<< Updated upstream
require("utilities.php");

$time_check_query = "SELECT * FROM `auctions` WHERE auctionStatus is null or auctionStatus=0" ;
$time_check_result = mysqli_query($connection,$time_check_query);
$time_check_row = mysqli_fetch_all($time_check_result);
// var_dump($time_check_row);

// to send email to winner buyer and seller
foreach ($time_check_row as $index => $content) {
    // var_dump($content);
    $auction_id = $content[0];
    $item_name = $content[1];
    $price = $content[8];
    $buyer = $content[10];
    if ($buyer == NULL) {
        continue;
    }
    // var_dump($buyer);
    $seller = $content[7];
    // var_dump($seller);

    $sql = "SELECT email
            FROM user
            WHERE userID = $buyer";
    $buyer_email = mysqli_fetch_all(mysqli_query($connection, $sql))[0][0];
    // var_dump($buyer_email);
    $content2 = "<h1>Congratulations! YOU are the winner of the item ".$item_name." </h1><br>
                <p>Your offered price: ￡".$price."</p>";
    sendmail($buyer_email, "Congratulations!", $content2);
    $sql = "SELECT email
            FROM user
            WHERE userID = $seller";
    $seller_email = mysqli_fetch_all(mysqli_query($connection, $sql))[0][0];
    // var_dump($seller_email);
    $content2 = "<h1>Congratulations! YOU have sold the item ".$item_name." </h1><br>
                <p>Highest offered price: ￡".$price."</p>";
    sendmail($seller_email, "Congratulations!", $content2);

    $sql = "UPDATE auctions
            SET auctions.auctionStatus = -1
            WHERE itemID = $auction_id";
    mysqli_query($connection, $sql);
=======

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
>>>>>>> Stashed changes
}
?>