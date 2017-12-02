<?php
/**
* Google Recaptcha Implementation Example with php curl
* @author Abdul Awal Uzzal
* @link https://abdulawal.com/google-recaptcha-example-implementation-php-curl/
* 
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<title>Google Recaptcha implementation with html forms and verify using php curl</title>
</head>
<body>
<?php
// Google Recaptcha Sitekey and Secret. You can store those values in database as well.
$recaptcha_site_key 	= ""; // Populate with your site key. get it from https://www.google.com/recaptcha/admin
$recaptcha_site_secret 	= ""; // Populate with your site secret. get it from https://www.google.com/recaptcha/admin

if (isset($_POST) && !empty($_POST)) {
	$captcha_response 		= htmlspecialchars($_POST['g-recaptcha-response']);

	$curl = curl_init();
	
	$captcha_verify_url = "https://www.google.com/recaptcha/api/siteverify";
	
	curl_setopt($curl, CURLOPT_URL,$captcha_verify_url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=".$recaptcha_site_secret."&response=".$captcha_response);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
	$captcha_output = curl_exec ($curl);

	curl_close ($curl);

	$decoded_captcha = json_decode($captcha_output);

	$captcha_status = $decoded_captcha->success; // store validation result to a variable.

	if($captcha_status === FALSE){
		echo "<div class='alert'>The Captcha is invalid. Please try again.</div>";
		return; // Return if the captcha is invalid
	}

	// Process the form here. This part will only execute if captcha validation is passed.
	$get_first_name = htmlspecialchars($_POST['first_name']);
	$get_last_name  = htmlspecialchars($_POST['last_name']);
	$get_email		= htmlspecialchars($_POST['email']);
	$get_username	= htmlspecialchars($_POST['username']);
	$get_password	= htmlspecialchars($_POST['password']);

	// Now do whatever you want to do with the data received. You can store in database or send email or anything else.
}
?>
<form action="" method="POST">
	<div class="field-group">
		<label for="first-name">First Name</label>
		<input type="text" placeholder="Your First Name" id="first-name" name="first_name"/>
	</div>

	<div class="field-group">
		<label for="last-name">Last Name</label>
		<input type="text" placeholder="Your Last Name" id="last-name" name="last_name"/>
	</div>

	<div class="field-group">
		<label for="email">Your Email</label>
		<input type="email" placeholder="Your Email" id="email" name="email"/>
	</div>

	<div class="field-group">
		<label for="username">Your Username</label>
		<input type="text" placeholder="Your Username" id="username" name="uhm_username"/>
	</div>

	<div class="field-group">
		<label for="password">Your Password</label>
		<input type="password" placeholder="Your Password" id="password" name="password" />
	</div>

	<div class="field-group">
		<div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div>
	</div>

	<div class="field-group">
		<input type="submit" name="submit" id="submit" value="Submit" />
	</div>
</form>
</body>
</html>