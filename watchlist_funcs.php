 <?php
 
include_once('database.php');
<<<<<<< Updated upstream
//session_start();
=======
>>>>>>> Stashed changes

if (!isset($_POST['functionname']) || !isset($_POST['arguments'])) {
  return;
}

// Extract arguments from the POST variables:
$item_id = $_POST['arguments'];
echo $item_id;
$userID = $_SESSION["user_id"];
echo $userID;

if ($_POST['functionname'] == "add_to_watchlist") {
  // TODO: Update database and return success/failure.


  $sql_add_to_watchlist = "INSERT INTO `watchlist`(`watchlistID`, `itemID`, `userID`) VALUES (1,$item_id, $userID)";
  $result = mysqli_query($connection,$sql_add_to_watchlist);

  $res = "success";
}
else if ($_POST['functionname'] == "remove_from_watchlist") {
  // TODO: Update database and return success/failure.

  $res = "success";
}

// Note: Echoing from this PHP function will return the value as a string.
// If multiple echo's in this file exist, they will concatenate together,
// so be careful. You can also return JSON objects (in string form) using
// echo json_encode($res).
echo $res;

?>