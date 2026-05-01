<?php
	include('/home/tr1158/p/secret.php');
	session_start();
	// Connect to MySQL
	$connect = mysqli_connect($db_server,$user,$password,$db_names);

	// Connection error check
	if ($connect->connect_error) {
		die("Could not connect: " . $connect->connect_error);
	}

	// Handle form submissions for sign in
	$messages = array();

	if ($_SERVER['REQUEST_METHOD'] === 'POST') { //	this checks if our button is submitted
		$usrcheck = $connect->prepare("Select employee_id, role, rate, hours from employees where employee_id = ?");
		$usrcheck->bind_param("i", $_SESSION['id']);
		$usrcheck->execute();
		$result = $usrcheck->get_result();

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$messages[] = "You are already an employee with the role of " . $row['role'] . " and a pay rate of $" . $row['rate'] . " per hour for " . $row['hours'] . " work.";
			$dup = TRUE;
		}
		$adpassword	=  isset($_POST['adpassword'])    ? $_POST['adpassword']    : '';
		$role	=  isset($_POST['role'])    ? $_POST['role']    : '';
		//are our boxes full
		if ($adpassword !== $adminpassword) { //is the admin password correct
			$messages[] = "Admin Regestration Password is incorrect";
		} else if (!$dup) { //adds escape keys to characters that might break our sql		
			$employee_id = $_SESSION['id'];

			$rate = $_POST['role'] === "System Admin" ? 28.00 : 22.00; 
			$hours = $_POST['role'] === "System Admin" ? "full-time" : "part-time"; 

			$upquery = $connect->prepare("UPDATE accounts SET adminStatus = 1 WHERE username = ? AND password = ?;");
			$query = $connect->prepare("insert into employees (employee_id, role, rate, hours) values (?,?,?,?)");
			$upquery->bind_param("ss", $_SESSION['username'], $_SESSION['password']);
			$query->bind_param('isds',$employee_id, $role, $rate, $hours); //need id from account table	

			$_SESSION['adminStatus'] = True:
				
			if ($query->execute() && $upquery->execute()) { //executes our query
				header("Location:../account.php");
				exit();
			} 
			else {
				$messages[] = "Error: " . mysqli_error($connect); //uho! something went wrong
			}
		}
	}
	$connect->close();
	
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Regester</title>
		<meta charset="utf-8">
		<link href="index.css" type="text/css" rel="stylesheet">
		<meta username="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="../imgs/favicon.jpg">
	</head>

	<body>
		<nav class="navbar navbar-dark navbar-expand-lg bg-body-tertiary" style="background-color: darkblue;">
  			<div class="container-fluid">
    			<a class="navbar-brand" href="#">
					<img src="../imgs/favicon.jpg" alt="logo" width="30" height="30" class="d-inline-block align-text-top">
					Wise Airlines
				</a>
    			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      				<span class="navbar-toggler-icon"></span>
    			</button>
   				<div class="collapse navbar-collapse" id="navbarText">
     				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="../index.php">Home</a>
						</li>
						<?php
						if (isset($_SESSION['adminStatus'] === 1)) {
							echo '
						<li class="nav-item">
							<a class="nav-link active" href="../adminAccount.php">My Info</a>
						</li>';
						} else {
							echo '
						<li class="nav-item">
							<a class="nav-link active" href="../account.php">My Info</a>
						</li>';
						}
						?>
						<li class="nav-item">
							<a class="nav-link" href="../packages.php">Packages</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contact Us</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="../contact.php">Email</a>
							</div>
						</li>
					</ul>
      				<span class="sign-in">
        				<?php
						if (isset($_SESSION['logstatus'])) {
							echo '<a class="btn btn-primary" href="logout.php" role="button">Log Out</a>';
						} else {
        					echo '<a class="btn btn-primary" href="signin.php" role="button">Sign In</a>';
						}
						?>
      				</span>
    			</div>
 			</div>
		</nav>

		<?php
		// Show messages
		if (!empty($messages)) {
			echo "<div>";
			foreach ($messages as $m) {
				echo "<p>" . $m . "</p>";
			}
			echo "</div>";
		}
		?>

		<div class="d-flex flex-column align-items-center align-self-center mt-3">
			<h2 class="text-center">Admin Regestration</h2> 
			<h3 class="text-center">Welcome valued employees, regester for admin privlages here</h3>
			<h4 class="text-center">Note: "Admin Regestration Password" denotes the company security password.
				This is required to differentiate you from a customer. If you do not know it, ask your superior.
			</h4> <!--redo phrasing later-->
			<form method="post" id="regester" class="mt-5 w-25 rounded-5">
				<div class="form-group">
					<label for="adpassword">Admin Regestration Password</label>
					<input name="adpassword" type="password" class="form-control" id="adpassword" placeholder="Admin Password">
				</div>
				<div class="form-group mb-2 w-50">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role">
                        <option>Sales</option>
                        <option>Customer service</option>
                        <option>System Admin</option>
                    </select>
                </div>
				<button type="submit" class="btn btn-primary mt-3">Submit</button>
			</form>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</body>
</html>
