<?php
include_once("database.php");

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
    $seller = $content[7];
    if ($buyer == NULL) {
        $sql = "SELECT email
                FROM user
                WHERE userID = $seller";
        $seller_email = mysqli_fetch_all(mysqli_query($connection, $sql))[0][0];
        // var_dump($seller_email);
        $content56 = "<h1>OH NO! YOU have not sold the item ".$item_name." because no one have even placed a bid! </h1><br>
                <p>Highest offered price: ￡".$price."</p>";
        sendmail($seller_email, "OH NO!", $content56);

        $sql = "UPDATE auctions
                SET auctions.auctionStatus = -1
                WHERE itemID = $auction_id";
        mysqli_query($connection, $sql);
        continue;
    }
    // var_dump($buyer);
    
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

}
?>