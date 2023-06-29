<?php

	include('config/db_connect.php');

	$c_code = $c_password = '';
	$errors = array('c_code' => '', 'c_password' => '');

	if(isset($_POST['submit'])){
		
		// check college code
		if(empty($_POST['c_code'])){
			$errors['c_code'] = 'College code is required';
		} else{
			$c_code = $_POST['c_code'];
		}

		// check Password
		if(empty($_POST['c_password'])){
			$errors['c_password'] = 'Password is required';
		} else{
			$c_password = $_POST['c_password'];
		}


		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$c_code = mysqli_real_escape_string($conn, $_POST['c_code']);
			$c_password = mysqli_real_escape_string($conn, $_POST['c_password']);

			// create sql
			$sql1 = "SELECT c_password from college WHERE c_code ='$c_code'";
			$sql2 = "SELECT c_code from college WHERE c_code='$c_code'";

			// get the query result for password
			$pass = mysqli_query($conn, $sql1);
			$c_user = mysqli_query($conn, $sql2);

			// fetch result in array format
			$pass_arr = mysqli_fetch_assoc($pass);
			$c_user_arr = mysqli_fetch_assoc($c_user);

			// check c_code
			if ($c_user_arr['c_code'] == $c_code) {
				header('Location: #');
			} else {
				$errors['c_code'] = 'No user found';
			}

			// check password
			if ($pass_arr['c_password'] == $c_password){
				session_start();
				$_SESSION['c_code'] = $c_code;
				header('Location: c_app.php');
			} else {
				$errors['password'] = 'Wrong Password';
			}

			// close sql connection
			mysqli_free_result($pass);
			mysqli_free_result($c_user);
			mysqli_close($conn);
		
		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container white-text">
		<h2 class="center">College Login</h2>
		<form class="white" action="collegeLogin.php" method="POST">
			<label>College ID</label>
			<input type="text" name="c_code" value="<?php echo htmlspecialchars($c_code) ?>">
			<div class="red-text"><?php echo $errors['c_code']; ?></div>
			<label>Password</label>
			<input type="password" name="c_password" value="<?php echo htmlspecialchars($c_password) ?>">
			<div class="red-text"><?php echo $errors['c_password']; ?></div>
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="submit_btn">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>