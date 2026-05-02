<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Contact Us</title>
		<meta charset="utf-8">
		<link href="index.css" type="text/css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="imgs/favicon.jpg">
	</head>

	<body>
		<nav class="navbar fixed-top navbar-dark navbar-expand-lg bg-body-tertiary" style="background-color: darkblue;">
  			<div class="container-fluid">
    			<a class="navbar-brand" href="#">
					<img src="imgs/favicon.jpg" alt="logo" width="30" height="30" class="d-inline-block align-text-top">
					Wise Airlines
				</a>
    			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      				<span class="navbar-toggler-icon"></span>
    			</button>
   				<div class="collapse navbar-collapse" id="navbarText">
     				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="index.php">Home</a>
						</li>
						<?php
						if (isset($_SESSION['adminStatus']) && $_SESSION['adminStatus'] === 1) {
							echo '
						<li class="nav-item">
							<a class="nav-link active" href="adminAccount.php">My Info</a>
						</li>';
						} else {
							echo '
						<li class="nav-item">
							<a class="nav-link active" href="account.php">My Info</a>
						</li>';
						}
						?>
						<li class="nav-item">
							<a class="nav-link" href="packages.php">Packages</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contact Us</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="contact.php">Email</a>
							</div>
						</li>
					</ul>
      				<span class="sign-in">
        				<?php
						if (isset($_SESSION['logstatus'])) {
							echo '<a class="btn btn-primary" href="LoginSystem/logout.php" role="button">Log Out</a>';
						} else {
        					echo '<a class="btn btn-primary" href="LoginSystem/signin.php" role="button">Sign In</a>';
						}
						?>
      				</span>
    			</div>
 			</div>
		</nav>

		<div class="d-flex flex-column">
            <h1 class="text-center mt-5 pt-4 fw-bold">Questions? Concerns? Offers?</h1>
            <h2 class="text-center mb-5">let us know! We would love to hear from you.</h2>

            <form class="d-flex flex-column align-items-center w-75 align-self-center">
                <div class="form-group mb-2 w-50">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="form-group mb-2 w-25">
                    <label for="subject">Subject</label>
                    <select multiple class="form-control" id="subject">
                        <option>Refund</option>
                        <option>Concerns</option>
                        <option>Legal Action</option>
                        <option>Job Application</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="form-group mb-3 w-75">
                    <label for="message">Message</label>
                    <textarea class="form-control" id="message" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</body>
</html>
