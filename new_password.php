<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Reset PHP</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<form class="login-form" action="new_password.php" method="post">
		<h2 class="form-title">New password</h2>
		<!-- form validation messages -->
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>New password</label>
			<input type="password" name="new_pass">
		</div>
		<div class="input-group">
			<label>Confirm new password</label>
			<input type="password" name="new_pass_c">
		</div>
		<div class="input-group">
			<label>Token</label>
			<input type="text" name="token" value='<?php echo $_GET['token'] ?>' readonly>
		</div>
		<div class="form-group">
			<button type="submit" name="new_password" class="login-btn">Submit</button>
		</div>
</form>
</body>
</html>