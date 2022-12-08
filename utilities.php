<?php

require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';
//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//mail function , needs recipient email address, subject, and html content of the email
function sendmail($recipient, $subject, $content, $headerinfor = True){
    $mail = new PHPMailer();
	$mail->isSMTP();

	$mail->Host = "smtp.gmail.com";

	$mail->SMTPAuth = true;

	$mail->SMTPSecure = "tls";

	$mail->Port = "587";

	$mail->Username = "auctionsite10101@gmail.com";

	$mail->Password = "hjdknabxcydsfppn";

	$mail->Subject = $subject;

	$mail->setFrom('auctionsite10101@gmail.com');

	$mail->isHTML(true);
//Attachment
	// $mail->addAttachment('img/attachment.png');
//Email body
	$mail->Body = $content;
//Add recipient
	$mail->addAddress($recipient);
  if ( $mail->send() ) {
    if ($headerinfor){
    echo "Email Sent..!";
    }
  }
  else{
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
      
  $mail->smtpClose();
}



// display_time_remaining:
// Helper function to help figure out what time to display
function display_time_remaining($interval) {

    if ($interval->days == 0 && $interval->h == 0) {
      // Less than one hour remaining: print mins + seconds:
      $time_remaining = $interval->format('%im %Ss');
    }
    else if ($interval->days == 0) {
      // Less than one day remaining: print hrs + mins:
      $time_remaining = $interval->format('%hh %im');
    }
    else {
      // At least one day remaining: print days + hrs:
      $time_remaining = $interval->format('%ad %hh');
    }

  return $time_remaining;

}

// print_listing_li:
// This function prints an HTML <li> element containing an auction listing
function print_listing_li($item_id, $title, $desc, $price, $num_bids, $end_time, $image, $rating)
{
  
  $rating = floatval($rating);
  $rounded_rating = round($rating, 1);
  $rating = ceil($rating);
  // Truncate long descriptions
  if (strlen($desc) > 250) {
    $desc_shortened = substr($desc, 0, 250) . '...';
  }
  else {
    $desc_shortened = $desc;
  }
  
  // Fix language of bid vs. bids
  if ($num_bids == 0 or 1) {
    $bid = ' bid';
  }
  else {
    $bid = ' bids';
  }
  
  // Calculate time to auction end
  $now = new DateTime();
  if ($now > $end_time) {
    $time_remaining = 'This auction has ended';
  }
  else {
    // Get interval:
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = display_time_remaining($time_to_end) . ' remaining';
  }
  
  
  // Print HTML
  echo('
    <li class="list-group-item d-flex justify-content-between">
    <img src="data:image/jpg;charset=utf8;base64,'.$image.'" width="300" height="300"/>
    <div class="p-2 mr-5"><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5>' . $desc_shortened . '</div>
    <div class="text-center text-nowrap"><span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>' . $num_bids . $bid . '<br/>' . $time_remaining . '<br/><br/>');
    
  if ($rating){
    
    echo('Seller rating: <br/>');
    if($rating=="1"){
      echo('<span class="prevIcon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span> 
    <span class="icon">★</span>
    <span class="icon">★</span> ');
    } else if($rating=="2"){
      echo('<span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="icon">★</span> 
    <span class="icon">★</span>
    <span class="icon">★</span>
     ');
    }else if($rating=="3"){
      echo('<span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span> ');
    }else if($rating=="4"){
      echo('<span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
     <span class="prevIcon">★</span>
    <span class="icon">★</span> ');
    }else if($rating=="5"){
      echo('<span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="prevIcon">★</span>  ');
    }
    
  } else {
    echo('This seller has no ratings');
  }
    
  
    
    
  echo(
    '</br>'.$rounded_rating.'
  </div>
  </li>'
  
  );
}

function print_listing_ratings($item_id, $title, $desc, $price, $num_bids, $end_time, $image, $buyerID, $prev_rating)
{
  // Truncate long descriptions
  if (strlen($desc) > 250) {
    $desc_shortened = substr($desc, 0, 250) . '...';
  }
  else {
    $desc_shortened = $desc;
  }
  
  // Fix language of bid vs. bids
  if ($num_bids == 0) {
    $bid = ' bid';
  }
  else {
    $bid = ' bids';
  }
  
  // Calculate time to auction end
  $now = new DateTime();
  if ($now > $end_time) {
    $time_remaining = 'This auction has ended';
  }
  else {
    // Get interval:
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = display_time_remaining($time_to_end) . ' remaining';
  }
  
  
  // Print HTML
  echo('

    
    <li class="list-group-item d-flex justify-content-between">
    <img src="data:image/jpg;charset=utf8;base64,'.$image.'" width="300" height="300"/>
    <div class="p-2 mr-5"><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5> 
    <h5> Rate the item and seller: </h5>
    <form name ="rating" id="myForm" class="rating" method="POST" action="submitRating.php">
    <div>
  <label>
    <input type="radio" name="stars" value="1" onchange="this.form.submit()"/>
    <input type="hidden" name="item_id" value="'.$item_id.'"/>
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" value="2" onchange="this.form.submit()"/>
    <input type="hidden" name="item_id" value="'.$item_id.'"/>
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" value="3" onchange="this.form.submit()"/>
    <input type="hidden" name="item_id" value="'.$item_id.'"/>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>   
  </label>
  <label>
    <input type="radio" name="stars" value="4" onchange="this.form.submit()"/>
    <input type="hidden" name="item_id" value="'.$item_id.'"/>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  <label>
    <input type="radio" name="stars" value="5" onchange="this.form.submit()"/>
    <input type="hidden" name="item_id" value="'.$item_id.'"/>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span>
  </label>
  

  </div>
  
  
  </form>');
  
  if ($prev_rating){
    
    echo('<h5> Your previous rating: </h5>');
    if($prev_rating=="1"){
      echo('<span class="prevIcon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span> 
    <span class="icon">★</span>
    <span class="icon">★</span> ');
    } else if($prev_rating=="2"){
      echo('<span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="icon">★</span> 
    <span class="icon">★</span>
    <span class="icon">★</span>
     ');
    }else if($prev_rating=="3"){
      echo('<span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="icon">★</span>
    <span class="icon">★</span> ');
    }else if($prev_rating=="4"){
      echo('<span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
     <span class="prevIcon">★</span>
    <span class="icon">★</span> ');
    }else if($prev_rating=="5"){
      echo('<span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="prevIcon">★</span>
    <span class="prevIcon">★</span>  ');
    }
    
  } else {
    echo('<h5> No previous rating for this item </h5>');
  }
 
    
    echo('</div>

    <div class="text-center text-nowrap"><span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>' . $num_bids . $bid . '<br/>' . $time_remaining . '</div>
  </li>
    
    '

  
  );
}



?>