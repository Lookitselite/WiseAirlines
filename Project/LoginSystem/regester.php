<?php
	include('/home/apw1043/p/dhb.inc');
	// Connect to MySQL
	$connect = mysqli_connect($db_server,$user,$password,$db_names);

	// Connection error check
	if ($connect->connect_error) {
		die("Could not connect: " . $connect->connect_error);
	}

	// Handle form submissions for sign in
	$messages = array();

	if ($_SERVER['REQUEST_METHOD'] === 'POST') { //	this checks if our button is submitted

		//registure our customer

		$username	=  isset($_POST['username'])    ? $_POST['username']    : '';
		$email		=  isset($_POST['email'])    ? $_POST['email']    : '';
		$password	=  isset($_POST['password'])    ? $_POST['password']    : '';
		$repassword	=  isset($_POST['repassword'])    ? $_POST['repassword']    : '';
		//are our boxes full
		if ($username === '' || $email === '' || $password === '' || !($repassword === $password)) {
			$messages[] = "Fill out all feilds correctly";
		} else { //adds escape keys to characters that might break our sql		

			$query = $connect->prepare("insert into accounts (username, password, email) values (?,?,?)");
			$query->bind_param('sss',$username, $password, $email);
				
			if ($query->execute() === TRUE && !($_POST['adRequest'])) { //executes our query
				header("Location:signin.php");
				exit();
			} 
			/*elseif ($_POST['adRequest']) { //if user selects 
				header("Location:adminRegester.php");
				exit();
			} 
			*/
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
		<meta name="viewport" content="width=device-width, initial-scale=1">
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
						<li class="nav-item">
							<a class="nav-link" href="../account.php">My Info</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="packages.php">Packages</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contact Us</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="../contact.php">Email</a>
							</div>
						</li>
					</ul>
      				<span class="mt-3">
        				<a class="btn btn-primary" href="signin.php" role="button">Sign In</a>
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

		<div class="d-flex flex-column align-items-center align-self-center">
			<form method="post" id="regester" class="mt-5 w-80 rounded-5">
				<div class="form-group">
					<h2 class="text-center">Register With Us!</h2> 
					<h3 class="text-center">You'll be flying with us soon!</h3>
					<label for="username">Username</label>  
					<input name="username" type="text" class="form-control" id="username" placeholder="Enter Username">
				</div>
				<div class="form-group"> 
					<label for="email">Email address</label>
					<input name="email" type="email" class="form-control" id="email" placeholder="Enter email">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input name="password" type="password" class="form-control" id="password" placeholder="Password">
				</div>
				<div class="form-group">
					<label for="repassword">Repeat Password</label>
					<input name="repassword" type="password" class="form-control" id="repassword" placeholder="Repeat Password">
				</div>
				<!-- TODO: rework into account page
				<div class="form-group mt-3">
					<input class="form-check-input" name="adRequest" type="checkbox" value="adRequest" id="adRequest">
					<label class="form-check-label" for="adRequest">
						Request Admin Account
					</label>
				</div>
				-->
				<button type="submit" class="btn btn-primary mt-3">Submit</button>
			</form>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</body>
</html>
