<?php include('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Reset PHP</title>
    <link rel="stylesheet" href="style.css">
    <script src='https://www.google.com/recaptcha/api.js'> </script>
</head>
<body>
	<form class="login-form" action="enter_email.php" method="post">
		<h2 class="form-title">Reset password</h2>
		<!-- form validation messages -->
		<?php include('errors.php'); ?>
		<div class="form-group">
			<label>Your email address</label>
			<input type="email" name="email">
        </div>
        <div class="g-recaptcha" data-sitekey="6LeeIcYUAAAAAPyRM023aYHxGyk7Ij_XOuhnq73v"> </div>
		<div class="form-group">
			<button type="submit" name="reset-password" class="login-btn">Submit</button>
		</div>
	</form>
</body>
</html>