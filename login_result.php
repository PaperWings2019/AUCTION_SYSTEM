<?php

use LDAP\Result;

//include_once("Config.php");

// TODO: Extract $_POST variables, check they're OK, and attempt to login.
// Notify user of success/failure and redirect/give navigation options.

// For now, I will just set session variables and redirect.

//connect to mySQL
include_once('database.php');

$email_input=$_POST['email'];
$password_input=$_POST['password']; 

session_start();

//determine if input is legal
if($email_input==null){
    echo('Please enter your email');
    $_SESSION['logged_in'] = false;

}elseif($password_input==null){
    echo('Please enter your password');
    $_SESSION['logged_in'] = false;

//check if entered data matah the ones in database
}elseif(isset($email_input)&&isset($password_input)){
    $query = "SELECT * FROM user WHERE email='$email_input' and password=SHA('$password_input')";
    $result = mysqli_query($connection,$query);
    $row = mysqli_fetch_array($result);

    if($row){                       //?????????????????????????????????
        echo('<div class="text-center">You are now logged in! You will be redirected shortly.</div>');

        //Session setup for successful login
        $_SESSION['logged_in'] = true;
        $_SESSION['id'] = $row['id'];

        if($row['account_type']==0){
            $_SESSION['account_type'] = "buyer";
        }else{
            $_SESSION['account_type'] = "seller";
        }
        
    }else{
        echo('Wrong email or password entered');
        $_SESSION['logged_in'] = false;
    }
}


// Redirect to index after 5 seconds
header("refresh:0.3;url=index.php");

?>