<?php

// TODO: Extract $_POST variables, check they're OK, and attempt to create
// an account. Notify user of success/failure and redirect/give navigation 
// options.

session_start();

include_once('database.php');   

//collect registration information
$account_type_input=$_POST['accountType'];
$email_input=$_POST['email'];
$password_input=$_POST['password'];
$password_confirmation_input=$_POST['passwordConfirmation'];

$password_pattern='/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9]{8,20}/';

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
}elseif(!filter_var($email_input, FILTER_VALIDATE_EMAIL)){
    echo "$email_input is NOT a valid email address.";
    header("refresh:3;url=register.php");
}elseif(!preg_match($password_pattern,$password_input)){
    echo ('Please make sure that you entered a password with at least 8 characters, including a number, an upper case letter, and a lower case letter');
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


$query_register = "INSERT INTO user(`userID`, `password`, `email`, `accountType`) VALUES ($id_iput,SHA('$password_input'),'$email_input','$account_type_input')";
$result_register = mysqli_query($connection,$query_register);

echo("Welcome, your id is $id_iput");


//Automatic login after registration
$_SESSION['logged_in'] = true;
$_SESSION['user_id'] = $id_iput;
if($account_type_input===0){
     $_SESSION['account_type'] = "buyer";
}else{
    $_SESSION['account_type'] = "seller";
}

header("refresh:3;url=browse.php");

}

?>