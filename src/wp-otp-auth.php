<?php
	/*
		Plugin Name: Wordpress OTP Authenticator
		Author: nonameHDT
		Description: Login to Wordpress with OTP code.
		Version: 1.0
		Author URI: http://www.vnsysadmin.org/
		Plugin URI: http://www.vnsysadmin.org/
		https://github.com/lelag/otphp/
	*/
	
	require_once "base32.php";
	require_once "otp.php";
	require_once "totp.php";

	function addLoginFormField()
	{
		?>
			<label for="user_OTP">OTP<br />
            <input type="text" name="user_OTP" id="user_extra" class="input" value="" size="25" /></label>
		<?php
	}
	
	function checkOTP($user, $username, $password)
	{
		if (isset($_POST['user_OTP']))
		{
			$totp = new \OTPHP\TOTP("SECRET_KEY_HERE");
			if ($totp->verify($_POST['user_OTP']))
				return new WP_User($user);
			else 
				return new WP_Error('OTP_fail', "OTP code is incorrect.");
		}
		else return new WP_User($user);
	}
	
	add_action('login_form', 'addLoginFormField');
	add_filter('authenticate', 'checkOTP', 30, 3);
	

?>