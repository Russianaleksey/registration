<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL</title>
	<script src='https://www.google.com/recaptcha/api.js'> </script>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="header">
		<h2>Register</h2>
	</div>

	<form method="post" action="register.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username" value="<?php echo $username; ?>">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password_1">
		</div>
		<div class="input-group">
			<label>Confirm password</label>
			<input type="password" name="password_2">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="text" name="email" value="<?php echo $email; ?>">
		</div>
		<div class="input-group">
			<label>Confirm Email</label>
			<input type="text" name="email_c" value="<?php echo $email_c; ?>">
		</div>
		<div class="input-group">
			<label>First Name</label>
			<input type="text" name="firstname" value="<?php echo $firstname; ?>">
		</div>
		<div class="input-group">
			<label>Last Name</label>
			<input type="text" name="lastname" value="<?php echo $lastname; ?>">
		</div>
		<div class="input-group">
			<label>Course</label>
			<input type="text" name="course" value="<?php echo $course; ?>">
		</div>
		<div class="input-group">
			<label>Sponsor</label>
			<input type="text" name="sponsor" value="<?php echo $sponsor; ?>">
		</div>

		<div class="input-group">
			<label>Gender</label>
			<select name="gender">
				<option value="">Select...</option>
				<option value="M">Male</option>
				<option value="F">Female</option>
			</select>
		</div>
		<div class="g-recaptcha" data-sitekey="6LeeIcYUAAAAAPyRM023aYHxGyk7Ij_XOuhnq73v"> </div>
		<div class="input-group">
			<button type="submit" class="btn" name="reg_user">Register</button>
		</div>
		<p>
			Already a member? <a href="login.php">Sign in</a>
		</p>
	</form>
</body>

</html>