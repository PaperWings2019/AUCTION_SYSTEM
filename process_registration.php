<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to create
// an account. Notify user of success/failure and redirect/give navigation 
// options.

session_start();

include_once('database.php');
//require('register.php');   

//collect registration information
$account_type_input=$_POST['accountType'];
$email_input=$_POST['email'];
$username_input = $_POST['username'];
$password_input=$_POST['password'];
$password_confirmation_input=$_POST['passwordConfirmation'];
$verification_input = $_POST['verification'];

$password_pattern='/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[\w\W]{8,20}$/';

$query = "SELECT * FROM user WHERE email='$email_input'";
$result = mysqli_query($connection,$query);
$row = mysqli_fetch_array($result);

$query_username = "SELECT * FROM user WHERE username='$username_input'";
$result_username = mysqli_query($connection,$query_username);
$row_username = mysqli_fetch_array($result_username);

//Determine whether the registration information is legal
if(!$username_input){
    echo ('Please enter a username!');
    header("refresh:3;url=register.php");
}elseif(!$email_input){
    echo ('Please enter an email!');
    header("refresh:3;url=register.php");
}
elseif($password_input!=$password_confirmation_input){
    echo ('Unmatched repeated password!');
    header("refresh:3;url=register.php");
}elseif($row_username){
    echo ('Username already existed, please try another one.');
    header("refresh:3;url=browse.php");
}
elseif($row){
    echo ('Email address already existed, please login.');
    header("refresh:3;url=browse.php");
}elseif(!filter_var($email_input, FILTER_VALIDATE_EMAIL)){
    echo "$email_input is NOT a valid email address.";
    header("refresh:3;url=register.php");
}elseif(!preg_match($password_pattern,$password_input)){
    echo ('Please entere a password with 8-20 characters including a number, an upper case letter, and a lower case letter');
    header("refresh:3;url=register.php");
}
else{
if($account_type_input==='buyer'){
    $account_type_input=0;
}else{
    $account_type_input=1;
}

//Attribute a id for new user
$query_id = "SELECT * FROM user WHERE userID=(SELECT MAX(userID) FROM user)";
$result_id = mysqli_query($connection,$query_id);
$row_id = mysqli_fetch_array($result_id);

if($row_id){
    $id_iput=$row_id['userID']+1;
}else{
    //For first user registration
    $id_iput=1;
}


$query_register = "INSERT INTO user(`userID`, `username`, `password`, `email`, `accountType`) VALUES ($id_iput, '$username_input', SHA('$password_input'),'$email_input','$account_type_input')";
$result_register = mysqli_query($connection,$query_register);

echo("Welcome, $username_input, your id is $id_iput");


//Automatic login after registration
$_SESSION['logged_in'] = true;
$_SESSION['user_id'] = $id_iput;
$_SESSION['username']=$username_input;
if($account_type_input===0){
     $_SESSION['account_type'] = "buyer";
}else{
    $_SESSION['account_type'] = "seller";
}

header("refresh:3;url=browse.php");

}

?>