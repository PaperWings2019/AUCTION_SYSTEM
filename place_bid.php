<?php
include_once('database.php');
//Include required PHPMailer files
require('utilities.php');


session_start();

// TODO: Extract $_POST variables, check they're OK, and attempt to make a bid.
// Notify user of success/failure and redirect/give navigation options.

$item_id = $_POST['item_id']; //itemID is not null

if ($_SESSION['logged_in']==false || $_SESSION['account_type'] != 'buyer'){            
    echo ("You must be logged in as a buyer berfore biding!");
    header("refresh:3;url=listing.php?item_id=$item_id");
    return;                  //To confirm whether users have login
}else{
    //TODO????: WHAT IF THE AUCTION END AT THE TIME TYPING THE BID PRICE?
  $_POST['bidInput'];
  $bidInput = $_POST ['bidInput'];

  $sql = "SELECT highestBid FROM auctions WHERE itemID = $item_id";
  $result = mysqli_query($connection,$sql);
  $row = mysqli_fetch_row($result);
  $highestBid = $row[0];

if (empty($bidInput)){
    echo ("You didn't enter any number");
    header("refresh:3;url=listing.php?item_id=$item_id");
    return;
}elseif($bidInput <= $highestBid){
    echo ("You can not enter a bid price that less than the current highest bid price");
    // header("refresh:3;url=listing.php?item_id=$item_id");
}else{
    $get_item_info_query_pre = "SELECT * FROM auctions WHERE itemID=$item_id";
    $item_result = mysqli_query($connection, $get_item_info_query_pre);
    $item_info_pre = mysqli_fetch_array($item_result);

    $SESSION_id = $_SESSION['user_id'];
    $bidSubmitTime = strtotime("now");
    $close_date = strtotime($item_info_pre[6]);
    if ($close_date < $bidSubmitTime) {
        echo "Sorry, the auction has been closed! Your bid is not successful";
        header("refresh:3;url=listing.php?item_id=$item_id");
        return;
    }
    $bidSubmitTime = date('Y-m-d H:i:s', $bidSubmitTime);

    // email to inform previous bidder about outbid

    $prev_buyer = $item_info_pre[10];
    $prev_bid = $item_info_pre[8];
    //check if there is previous buyer
    if($prev_buyer != NULL){
        $get_buyer_info = "SELECT * FROM user WHERE userID=$prev_buyer";
        $buyer_info_result = mysqli_query($connection, $get_buyer_info);
        $buyer_info = mysqli_fetch_array($buyer_info_result);
        $buyer_email = $buyer_info[2];

        //send email to previous bidder
        $recipient = $buyer_email;
        $subject = "You have been outbid!";
        $content = "<h1>You have been outbid by another user! </h1></br>
                        <p>Bid info: <br>
                        Item: ".$item_info_pre[1]."<br>
                        Seller: ".$item_info_pre[7]."<br>
                        Your Original Bid amount: £".$prev_bid."<br>
                        New Bid amount: £".$bidInput." <br>
                        Timestamp: ".$bidSubmitTime."</p>";
        sendmail($recipient, $subject, $content);
    }

    //update auctions table with new bid and buyer
    $update_sql = "UPDATE auctions SET highestBid = $bidInput, buyerID = $SESSION_id where itemID = $item_id";
    $update_result = mysqli_query($connection,$update_sql);

    $bid_id = "SELECT * FROM bidhistory WHERE bidID=(SELECT MAX(bidID) FROM bidhistory)";
    $result_id = mysqli_query($connection,$bid_id);
    $row_id = mysqli_fetch_array($result_id);




if($row_id){
    $bid_id_iput=$row_id['bidID']+1;
}else{
    //For first user registration
    $bid_id_iput=1;
}
    $insert_sql = "INSERT INTO bidhistory(`bidID`,`buyerID`,`itemID`,`bidPrice`,`bidTime`) VALUES ($bid_id_iput,'$SESSION_id','$item_id','$bidInput','$bidSubmitTime')";
    $insert_result = mysqli_query($connection,$insert_sql);
    echo ("Congratulations! You have sucessfully submit your bid!");
    // header("refresh:3;url=listing.php?item_id=$item_id");

    //get current item info
    $get_item_info_query = "SELECT * FROM auctions WHERE itemID=$item_id";
    $item_result = mysqli_query($connection, $get_item_info_query);
    $item_info = mysqli_fetch_array($item_result);

    $get_new_bidder_info = "SELECT * FROM user WHERE userID=$SESSION_id";
    $bidder_info_result = mysqli_query($connection, $get_new_bidder_info);
    $bidder_info = mysqli_fetch_array($bidder_info_result);
    
    

    //send email to bidder
    $recipient = $bidder_info[2];
    $subject = "Bid placed!";
    $content = "<h1>Your bid has been placed successfully! </h1></br>
                    <p>Bid info: <br>
                    Item: ".$item_info[1]."<br>
                    Seller: ".$item_info[7]."<br>
                    Bid amount: £".$bidInput."<br>
                    Time placed: ".$bidSubmitTime."</p>";
    sendmail($recipient, $subject, $content);
    
    
}
header("refresh:1;url=listing.php?item_id=$item_id");
}
?>