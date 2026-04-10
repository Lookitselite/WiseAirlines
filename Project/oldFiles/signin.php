<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Sign In</title>
		<meta charset="utf-8">
		<link href="index.css" type="text/css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="imgs/favicon.jpg">
	</head>

	<body>
		<nav class="navbar navbar-dark navbar-expand-lg bg-body-tertiary" style="background-color: darkblue;">
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
						<li class="nav-item">
							<a class="nav-link" href="account.php">My Info</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="packages.php">Packages</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contact Us</a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="contact.php">Email</a>
							</div>
						</li>
					</ul>
      				<span class="mt-3">
        				<a class="btn btn-primary" href="signin.html" role="button">Sign In</a>
      				</span>
    			</div>
 			</div>
		</nav>

		<div class="d-flex flex-column align-items-center align-self-center">
			<form id="sign-in" class="mt-5 w-80 rounded-5">
				<div class="form-group">
					<h2 class="text-center">Sign In</h2>
					<h3 class="text-center">You'll be flying with us soon!</h3>
					<label for="email">Email address</label>
					<input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
				</div>
				<div class="form-check mb-2">
					<input type="checkbox" class="form-check-input" id="exampleCheck1">
					<label class="form-check-label" for="exampleCheck1">Remember me</label>
				</div>
				<p>No Account? <a href="regester.php">Regester Today!</a></p>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</body>
</html>
