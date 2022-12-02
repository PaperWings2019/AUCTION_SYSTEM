<?php include_once("header.php")?>

<?php 


if ($_SESSION['logged_in']==false || $_SESSION['account_type'] != 'buyer') {
header('Location: browse.php');
}

$buyer_id = $_SESSION["user_id"];
// This function takes the form data and adds the new auction to the database.

/* TODO #1: Connect to MySQL database (perhaps by requiring a file that
        already does this). */

include_once('database.php');


if(isset($_POST['stars'])){
    
    $rating = $_POST['stars'];
    // echo("rating".$rating);
    
}

if(isset($_POST['item_id'])){
    
    $item_id = $_POST['item_id'];
    // echo("itemid".$item_id);
    
}

//check if rating exists
$delete_item = "DELETE FROM `ratings` WHERE itemID = $item_id ;";
mysqli_query($connection,$delete_item);

$insert_item = "INSERT INTO `ratings`(`ratingsID`, `itemID`, `rating`) VALUES ( NULL ,'$item_id','$rating')";
if(!mysqli_query($connection,$insert_item)){
        echo(mysqli_error($connection));
        // echo '<script>alert("'.mysqli_error($connection).'")</script>';
        // die('Error: ' . mysqli_error($connection));
        // echo '<script>window.history.go(-1)</script>';
        

    }





header("refresh:0.1;url=ratings.php");



?>