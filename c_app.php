<?php 

	include('config/db_connect.php');

	session_start();

	if($_SESSION['c_code']) {
		// escape sql chars
		$c_code = mysqli_real_escape_string($conn, $_SESSION['c_code']);

		// query for all applications
		$sql = "SELECT app_id, s_name, status FROM application WHERE c_code='$c_code'";

		// get the result set (set of rows)
		$result = mysqli_query($conn, $sql);

		// fetch the resulting rows as an array
		$apps = mysqli_fetch_all($result, MYSQLI_ASSOC);

		// free $result
		mysqli_free_result($result);

		// close connection
		mysqli_close($conn);	
	}

	// session_unset();
	// session_destroy();


?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/logout.php'); ?>

	<h2 class="center white-text">Applications</h2>

	<div class="container">
		<div class="row">

			<?php foreach($apps as $app): ?>

				<div class="col s6 m4" style="font-family:Arial, Helvetica, sans-serif; font-size:20px;">
					<div class="card z-depth-0">
						<div class="card-content center">
							<h4><?php echo htmlspecialchars($app['app_id']); ?></h4>
							<h8><?php echo htmlspecialchars($app['s_name']); ?></h8>
							<p><?php echo htmlspecialchars($app['status']); ?><p>
						</div>
						<form class="white center" action="c_verify.php" method="POST" >
							<input type="hidden" name="app_id" value=<?php echo $app['app_id']; ?> /> 
							<input type="submit" name="submit" value="More info" class="submit_btn">
						</form>
					</div>
				</div>

			<?php endforeach; ?>

		</div>
	</div>

	<?php include('templates/footer.php'); ?>

</html>