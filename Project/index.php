<?php
session_start();

//Our Universal Search will put all our information in SESSION variables.
//Then when the Search button is clicked the user will be directed to the Transaction page.
//The TRANSACTION PAGE will search for available tickets in the database and display them.
//This will display TICKETs, with a COUNT and an ADD when a number is added and ADD is pressed it will be added to a CART
//Fun stuff

//I'd like to send a quiry to the database and collect a list of all ticket's Departure locatoins and destinations.
//Stuff them in a array and be able to use this for options in the inputs
//kind of like a drop down or auto complete, then they can pick an input that will actually be 
//in the database






//connection to our database
include('/home/tr1158/p/secret.php');
// Connect to MySQL
$connect = mysqli_connect($db_server,$user,$password,$db_names);

// Connection error check
if ($connect->connect_error) {
	die("Could not connect: " . $connect->connect_error);
}






//we want to create an array that contains our departure and destination cities.
//will be used for the autocomplete dropdown in the search (so fomatting is propper to find flights)


$locations = $connect->query("SELECT DISTINCT origin FROM `flights`;");
//creates array of all DISTINCT origin cities
while ($row = $locations->fetch_assoc()) {
	$origin[] = $row['origin'];
}

$locations = $connect->query("SELECT DISTINCT destination FROM `flights`;");
//creates array of all DISTINCT destinations
while ($row = $locations->fetch_assoc()) {
	$arrival[] = $row['destination']; //a weird syntax but this gives us our string names of the cities
}







//SESSION variabls
//must change our inputs to post then once our button is pressed we will add them as session variables
//then send us to our transaction page. 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search'])) {

	$departure = $_POST['departure'];
	$destination = $_POST['destination'];
	$dDate = $_POST['d_date'];
	$rDate = $_POST['r_date'];


	if (!isset($_SESSION['search'])) { //sets our search if no search session has been created.
		$_SESSION['search'] = [];
	}

	$_SESSION['search'] = [ //sets our data
			"departure" => $departure,
			"destination" => $destination,
			"dDate" => $dDate,
			"rDate" => $rDate
	];

	//then we will send us to the transaction page, THIS BLOCK ONLY RUNS WHEN THE SEARCH button is pressed.
	
	if (isset($_SESSION['logstatus'])) {
		header("Location:transaction.php");
	} else {
    	header("Location:LoginSystem/signin.php");
	}
}

?>




<!--The start of our page html -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Wise Airlines</title>
		<meta charset="utf-8">
		<link href="index.css" type="text/css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="icon" type="image/x-icon" href="imgs/favicon.jpg">
	</head>




<!--Navigation, same on each page -->

	<body>
		<nav class="navbar fixed-top navbar-dark navbar-expand-lg bg-body-tertiary">
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
							<a class="nav-link active" aria-current="page" href="index.php">Home</a>
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
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contact Us</a>
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






<!--Our Search Post method being used, I would like to add other options like round trip or one way, 
the dates don't do anything at the moment, we would have to add rows to the database if we really wanted 
to use it. -->
		<div class="d-flex flex-column">
			<div class="d-flex justify-content-center">
				<div id="form-bg" class="mt-5 w-100">
					<div class="flight-form">
						<h3 class="text-center mb-4 fw-bold">Ready to Fly?</h3>
						<form method="POST" action="">
							<div class="row bg-light bg-opacity-75 rounded-3 p-3">
								<div class="col">
									<label class="form-label fw-bold">Departure Location</label>
<!--This is the spot where we add our auto complete list, using the list="originList" attribute -->
									<input 
										name="departure" 
										id="departure"
										type="text" 
										class="form-control" 
										aria-label="departing"
										list="originList"
										placeholder="Choose Departure City"
									>
<!--Datalist element is the other half of this, we echo the option element for each city in origin, setting its attribute, value, to each city name -->
									<datalist id="originList">
										<?php 
										foreach ($origin as $city) {
											echo "<option value=\"" . htmlspecialchars($city) . "\">";
										}
										?>

									</datalist>
								</div>
								<div class="col">
									<label class="form-label fw-bold">Destination</label>
<!--This is the spot where we add our auto complete list, using the list="arrivalList" attribute -->
									<input 
										name="destination"
										id="destination" 
										type="text" 
										class="form-control" 
										aria-label="destination"
										list="arrivalList"
										placeholder="Choose Arrival City"
									>
<!--Datalist element is the other half of this, we echo the option element for each city in origin, setting its attribute, value, to each city name -->
									<datalist id="arrivalList">
										<?php 
										foreach ($arrival as $city) {
											echo "<option value=\"" . htmlspecialchars($city) . "\">";
										}
										?>
									</datalist>
								</div>
								<div class="col">
									<label class="form-label fw-bold">Departure Date</label>
									<input name="d_date" type="date" class="form-control" aria-label="departure-date">
								</div>
								<div class="col">
									<label class="form-label fw-bold">Return Date</label>
									<input name="r_date" type="date" class="form-control" aria-label="return-date">
								</div>
								<div class="col">
									<button type="submit" name="search" class="btn btn-primary btn-lg w-100" aria-label="Submit">Search</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>




			<!--This is just a print for checking values stored
			<div class="d-flex flex-column">
				<?php
				/*
				//print so I can see it on the website.
				//prints our search array (contains the inputs of the user in search bar)
				if (!empty($_SESSION['search'])) {
					foreach ($_SESSION['search'] as $info) {
						echo"<p>$info</p>";
					}
				}
				//prints our array of all cities (origin and arrival cities) just a check to see if I'm making the list properly from the database
				foreach ($origin as $place) {
					echo"<p>$place</p>"; 
				}
				foreach ($arrival as $place) {
					echo"<p>$place</p>"; 
				}*/

				?>
				
			</div>
-->
			


			<h2 class="text-center mt-5 fw-bold ">Deals For YOU!</h2>
			<h3 class="text-center mt-2">Like what you see? Check out our packages!</h3>
			<div id="dealCarousel" class="carousel slide carousel-dark w-50 mx-auto my-5" data-bs-ride="false">
				<div class="carousel-indicators">
					<button type="button" data-bs-target="#dealCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
					<button type="button" data-bs-target="#dealCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
					<button type="button" data-bs-target="#dealCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
				</div>
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img src="imgs/germany.png" class="d-block w-100 img-fluid" alt="germany">
						<div class="carousel-caption bg-dark bg-opacity-75 rounded-3 p-2 text-light">
							<h4>Germany: $1500</h4>
							<p>img src: public domain</p>
						</div>
					</div>
					<div class="carousel-item">
						<img src="imgs/japan.jpg" class="d-block w-100 img-fluid" alt="japan">
						<div class="carousel-caption bg-dark bg-opacity-75 rounded-3 p-2 text-light">
							<h4>Japan: $2700</h4>
							<p>img src: CC by 4.0, Photo by Luke Lawreszuk - Sprayedout.com (CC BY 4.0) via Shinjuku Tokyo Cityscape at Dusk.</p>
						</div>
					</div>
					<div class="carousel-item">
						<img src="imgs/puertoRico.jpg" class="d-block w-100 img-fluid" alt="puerto rico">
						<div class="carousel-caption bg-dark bg-opacity-75 rounded-3 p-2 text-light">
							<h4>Puerto Rico: $1000</h4>
							<p>img src: public domain</p>
						</div>
					</div>
				</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#dealCarousel" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#dealCarousel" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</body>
</html>
