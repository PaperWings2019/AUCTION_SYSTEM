<?php
include_once('database.php');
session_start();

// TODO: Extract $_POST variables, check they're OK, and attempt to make a bid.
// Notify user of success/failure and redirect/give navigation options.
$item_id = $_POST['item_id']; //itemID is not null

if ($_SESSION['logged_in']==false || $_SESSION['account_type'] != 'buyer'){            
    echo ("Please login as buyer berfore biding");
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
    $SESSION_id = $_SESSION['user_id'];
    $bidSubmitTime = date_format(new DateTime(), 'Y-m-d H:i:s');
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
}
header("refresh:1;url=listing.php?item_id=$item_id");
}
?>