<?php
$page_title = "Contact Us | Theory of Webolution";
$page_desc = "Contact Theory of Webolution today to let us get started building the web presence you desire.";
$body_class = "contact-us";
include_once('includes/header.php');
?>



<article class="main-article">
<h1>Contact Us</h1>
<p>Call us at <span class="logo-blue">(405) 326-5300</span> or use the form below to send us a message.</p>
<hr />

<?php
$name = "";
$email = "";
$category = "";
$message = "";

function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;	
}

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){
	
	//check for empty fields
	if(!empty(trim($_POST['name'])) && !empty(trim($_POST['email'])) && !empty(trim($_POST['category'])) && !empty(trim($_POST['message']))){
	
	//validate form data
	$name = test_input($_POST['name']);
	$email = test_input($_POST['email']);
	$category = test_input($_POST['category']);
	$message = test_input($_POST['message']);
	
	//validate Name
	if(preg_match("/^[a-zA-Z ]*$/", $name)){
		
	//validate Email
	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		
		$admin_email = "jared@theoryofwebolution.com";
		$to_email = "jared@theoryofwebolution.com";
		$subject = "Message From Theory of Webolution";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <jared@theoryofwebolution.com>' . "\r\n";
		$headers .= 'Cc: jared_burdick10@yahoo.com' . "\r\n";
		$formatted_message = "
<!doctype html>
<head>
<title>Message From Theory of Webolution</title>
</head>
<body>
<h1>Message From Theory of Webolution</h1>
<h3>Hello Jared,</h3>
<p>You have received a message From: <b>$name</b>.<br />
Their email address is: <b>$email</b>.<br />
The Category is: <b>$category</b>.<br />
Heres what they had to say:</p>
<p><b>$message</b></p>
</body>
		";
		
		//send email
		if(mail($to_email, $subject, $formatted_message, $headers)){
			$success_msg = "Thank you for contacting us. We will be in touch shortly.";
			
			//$url = "contact-us.php?success_msg=" . urlencode($success_msg);
			$url = "contact-us/success/" . urlencode($success_msg);
			redirect($url);
			//reset all values back to empty
			$name = "";
			$email = "";
			$message = "";
		}else{
			echo "<h3 class='error'>Unable to send your message, please try again later.</h3>";	
		}
		
	}else{
		echo "<h3 class='error'>Invalid Email Format.</h3>";
	}
		
	}else{
		echo "<h3 class='error'>Only letters and white space allowed for name field.</h3>";	
	}
	
	}else{
		echo "<h3 class='error'>All Fields Are Required.</h3>";	
	}
}
?>

<?php
if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['success_msg'])){
	$success_message = urldecode($_GET['success_msg']);
	echo "<h3 class='success'>$success_message</h3>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="contact">
	<div class="form-control">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required="required"  />
    </div>
    
    <div class="form-control">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required="required"  />
    </div>
    
    <div class="form-control">
    <label for="category">Category:</label>
    <select id="category" name="category">
    	<option value="new-site">New Site Design</option>
        <option value="update-site">Update Site</option>
        <option value="redesign">Re-design Site</option>
        <option value="seo">SEO (Search Engine Optimisation)</option>
        <option value="branding">Identity/Branding</option>
        <option value="logo">Logo Design</option>
        <option value="other">Other</option>
    </select>
    </div>
    
    <div class="form-control">
    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="10" required="required">
    <?php
	if(isset($message) && !empty($message)) {
		echo $message;	
	}
	?>
    </textarea>
    </div>
    
    <input type="submit" type="submit" name="submit" id="subit" value="Submit" />
</form>


</article>


<?php
include_once('includes/footer.php');
?>