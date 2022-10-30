<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to create
// an account. Notify user of success/failure and redirect/give navigation 
// options.

session_start();

$connection = mysqli_connect('localhost','root','','auction_system');

//collect registration information
$account_type_input=$_POST['accountType'];
$email_input=$_POST['email'];
$password_input=$_POST['password'];
$password_confirmation_input=$_POST['passwordConfirmation'];

$query = "SELECT * FROM user WHERE email='$email_input'";
$result = mysqli_query($connection,$query);
$row = mysqli_fetch_array($result);

//Determine whether the registration information is legal
if($password_input!=$password_confirmation_input){
    echo ('Unmatched repeated password!');
    header("refresh:3;url=register.php");
}elseif($row){
    echo ('Email address already existed, please login.');
    header("refresh:3;url=browse.php");
}else{
if($account_type_input==='buyer'){
    $account_type_input=0;
}else{
    $account_type_input=1;
}

//Attribute a id for new user
$query_id = "SELECT * FROM user WHERE id=(SELECT MAX(id) FROM user)";
$result_id = mysqli_query($connection,$query_id);
$row_id = mysqli_fetch_array($result_id);
$id_iput=$row_id['id']+1;

$query_register = "INSERT INTO user(`id`, `password`, `email`, `account_type`) VALUES ($id_iput,'$password_input','$email_input','$account_type_input')";
$result_register = mysqli_query($connection,$query_register);

echo("Welcome, your id is $id_iput");


//Automatic login after registration
$_SESSION['logged_in'] = true;
$_SESSION['id'] = $id_iput;
if($account_type_input===0){
     $_SESSION['account_type'] = "buyer";
}else{
    $_SESSION['account_type'] = "seller";
}

header("refresh:3;url=browse.php");

}

?>