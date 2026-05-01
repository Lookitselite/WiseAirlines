<?php
session_start();
//Goal of this page
//Search for any plane tickets within the database by city names
//display those tickets in a card like box, that stack on top of each other
//on each card there should be two actions that can be made, add to cart, ticket count
//There should be a nav like space on the right that will be our shopping cart
//The cart will show all tickets added to the cart, should have an option to remove
//There should be a total cost, and a checkout button, leading to a credit card form
//this page wont work.


//this was just a test print
/*if ($_SERVER["REQUEST_METHOD"] === "POST") {
	echo "<pre>";
	echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "<br>";

	print_r($_POST);
	print_r($_SESSION['tickets']);
	//print_r($_SESSION['totalPrice']);

	echo "</pre>";

}*/




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
//stores search values

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


	// we must prompt the database to find tickets

	$query = $connect->prepare("Select flight_id, origin, destination, cost from flights where origin=? and destination=?");
	$query->bind_param("ss", $_SESSION['search']['departure'], $_SESSION['search']['destination']);
	$query->execute();
	$result = $query->get_result();

	
	$_SESSION['tickets'] = [];
	

	while ($row = $result->fetch_assoc()) {
		$_SESSION['tickets'][]= $row;

	}
}




//create our shopping cart

//book button post method, this adds our ticket to shoppingCart
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['book'])) {

	$cur_flight_id = (int) $_POST['flight_id'];
	$ticket_count = (float) $_POST['ticket_count'];

	if (isset($_SESSION['temp_ticket'])) {
		$_SESSION['temp_ticket']=[];
	}
	//$_SESSION['totalPrice']= 0.00;//number_format(0,2,'.',',');  


	if (!isset($_SESSION['totalPrice'])) {
		$_SESSION['totalPrice'] = 0.00;//number_format(0,2,'.',',');
	}

	//unset($_SESSION['totalPrice']);
	
	$_SESSION['temp_ticket'] = [];
	
	if (isset($_SESSION['tickets'])) {//check if search has been made
		foreach ($_SESSION['tickets'] as $ticket) {//run through each ticket
			 //find ticket with matching id number
			if ($ticket['flight_id'] === $cur_flight_id) {
				//sets our search if no search session has been created.
				$_SESSION['temp_ticket'] = $ticket;
				break;					
			}	
		}

		$_SESSION['temp_ticket']['ticket_count'] = $ticket_count;
		$_SESSION['temp_ticket']['cost'] = (float) ($_SESSION['temp_ticket']['cost'] * $ticket_count);//,2,'.',',');


		$ticket_price = (float)$_SESSION['temp_ticket']['cost'];
		$totalPrice = (float)$_SESSION['totalPrice'];

		$_SESSION['totalPrice'] = $totalPrice + $ticket_price;//,2,'.',',');


		
		if (!isset($_SESSION['shoppingCart'])) { //sets our search if no search session has been created.
			$_SESSION['shoppingCart'] = [];
		}	
	
		$_SESSION['shoppingCart'][] = $_SESSION['temp_ticket'];

		unset($_SESSION['temp_ticket']);

	}


}





//remove a ticket from the shopping cart
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['remove'])) {

	$cur_index = (int) $_POST['index'];//our index (set when added to the cart)

	$ticket_price = (float)$_SESSION['shoppingCart'][$cur_index]['cost'];
	$totalPrice = (float)$_SESSION['totalPrice'];

	$_SESSION['totalPrice'] = $totalPrice - $ticket_price;//,2,'.',','); //decrease our total price

	unset($_SESSION['shoppingCart'][$cur_index]);//gets rid of our ticket

	$_SESSION['shoppingCart'] = array_values($_SESSION['shoppingCart']); //prevents gaps

	if (empty($_SESSION['shoppingCart'])) {
		$_SESSION['totalPrice'] = 0.00;
	}
}


//add our shopping cart into the database!
//We now have an ARRAY of $_SESSION['shoppingCart'] it contains tickets we want to add this
//information into our database
//we will send us to a checkout page for this task, first we will make sure we have all out information


//when CHECHOUT is clicked we must first INSERT a transaction
//it looks like this:
//transaction_id---> auto increment we dont need to worry
//account_id--->$_SESSION['id']  int(11)
//transaction_date--->  todaysdate, our database handles this
//total---> will be 0 at first, we will make a trigger that increases this value as tickets are inserted

//NEEDED?? JUST $_SESSION['id'] which we have already on the authentication page

//When CHECKOUT is clicked it should send tickets to the transaction_tickets table
//it looks like this:
//transaction_ticket_it---->auto increment, don't need to worry
//transaction_id ---->transaction table INT(11) Will grab after transaction insert
//flight_id---> $_SESSION['shoppingCart'][$cur_index]['flight_id]
//cost--> $_SESSION['shoppingCart'][$cur_index]['cost']

//NEEDED???  $_SESSION['shoppingCart'][$cur_index]['flight_id'], 
//NEEDED???  $_SESSION['shoppingCart'][$cur_index]['cost'], 
//NEEDED???  transaction_id QUERY

//AFTER EVERYTHING IS IN THE DATABASE unset shopping cart and everything attached to it, This way we can make new transactions.

//Checkout button should send you to our checkout page
//pretty simple
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['checkout'])) {
	header("Location:checkout.php");
} 



?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Flights</title>
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
							<a class="nav-link active" href="packages.php">Packages</a>
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




		<!-- This is the same search bar from the index page, the difference between this page and the last is the shopping cart feature.-->
		
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
		</div>

<!-- this container has TWO sides, the ticket display side, and the Shopping cart side-->
<!-- We want our Shopping cart be a Double layered array, i think
 lets think it out
 we have a ticket, the ticket is an associative array when the book button is pressed it will be added to the cart[].
 we add a "count"=? to the ticket

 when its added to the array then our cart should display it.
 when displayed there should be an option to delete from the cart.
 bottom of the cart should have a checkout button.
 -->

		<div class="container-fluid mt-4">
			<div class="row">
				<div class="col-md-8">
<!-- This will be our containers for our tickets. The goal is to display tickets after each search-->
					<div class="d-flex flex-column gap-3 mt-5 ms-2">
						<!-- within here we need to make a php if statement and a subsequent loop for each ticket in tickets.-->

						<?php
						if (isset($_SESSION['tickets']) && !(empty($_SESSION['tickets']))) { //this is our ticket display adds our variables we grabbed from the database
							foreach ($_SESSION['tickets'] as $ticket) {
										echo "<div class=\"d-flex justify-content-center\">
											<form method=\"POST\" action=\"\">
												<div class=\"row bg-secondary bg-opacity-75 rounded-3 p-3\">

														<div class=\"col\">
															<label class=\"form-label fw-bold\">Flight I.D. Number: </label>
															<label class=\"form-label fw-bold bg-white p-2 rounded\">" . htmlspecialchars($ticket['flight_id']) . "</label>						
														</div>

														<div class=\"col\">
															<label class=\"form-label fw-bold\">Departure Location: </label>
															<label class=\"form-label fw-bold bg-white p-2 rounded\">" . htmlspecialchars($ticket['origin']) . "</label>						
														</div>

														<div class=\"col\">
															<label class=\"form-label fw-bold\">Destination: </label>
															<label class=\"form-label fw-bold bg-white p-2 rounded\">" . htmlspecialchars($ticket['destination']) . "</label>
														</div>

														<div class=\"col\">
															<label class=\"form-label fw-bold\">Departure Date: </label>
															<label class=\"form-label fw-bold bg-white p-2 rounded\">" . htmlspecialchars($ticket['destination']) . "</label>
														</div>

														<div class=\"col\">
															<label class=\"form-label fw-bold\">Return Date: </label>
															<label class=\"form-label fw-bold bg-white p-2 rounded\">" . htmlspecialchars($ticket['destination']) . "</label>
														</div>

														<div class=\"col\">
															<label class=\"form-label fw-bold\">Price: </label>
															<label class=\"form-label fw-bold bg-white p-2 rounded\">$" . htmlspecialchars($ticket['cost']) . "</label>
														</div>

														<div class=\"col\">
																<input 
																	type=\"hidden\" 
																	name=\"flight_id\" 
																	value=\"" . htmlspecialchars($ticket['flight_id']) . "\"
																>		
														</div>

														<div class=\"col\">
															<select 
																name=\"ticket_count\"	
																class=\"form-select\"
																id=\"ticket_count\"
															>
																<option value=\"1\">1</option>
																<option value=\"2\">2</option>
																<option value=\"3\">3</option>
																<option value=\"4\">4</option>
																<option value=\"5\">5</option>
																<option value=\"6\">6</option>
															</select>
														</div>

														<div class=\"col\">
															<button 
																type=\"submit\" 
																id=\"book\"
																name=\"book\" 
																class=\"btn btn-primary btn-lg w-100\" 
																aria-label=\"Submit\"
															>Book</button>
														</div>
													
												</div>
											</form>			
										</div>";


							}
						}
						?>
					</div>
				</div>
<!-- THIS IS our shopping cart-->
				<div class="col-md-4">
					<div class="d-flex flex-column gap-3 mt-5">
						<div class="card sticky-top" style="top: 80px;background-color: darkblue;">
							<label class="form-label fw-bold fs-2 ms-3 text-white">Shopping cart</label>
						</div>

						<!-- now this will be displaying anthing added from our tickets, this means our tickets need to be a post method.-->
						<?php
						if (isset($_SESSION['shoppingCart']) && !(empty($_SESSION['shoppingCart']))) { //this is our ticket display adds our variables we grabbed from the database
							foreach ($_SESSION['shoppingCart'] as $index => $ticket) {
								echo "<div class=\"card sticky-top\" style=\"top: 80px;background-color: white;\">
										<form method=\"POST\" action=\"\">
											<div class=\"row align-items-center\">
												<div class=\"col\">
													<p class=\"mb-1\">I.D.:" . htmlspecialchars($ticket['flight_id']) . "</p>	
												</div>
												<div class=\"col\">
													<p class=\"mb-1\">From: " . htmlspecialchars($ticket['origin']) ."</p>	
												</div>
												<div class=\"col\">
													<p class=\"mb-1\">To: " . htmlspecialchars($ticket['destination']) . "</p>	
												</div>
												<div class=\"col\">
													<p class=\"mb-1\">Tickets: " . htmlspecialchars($ticket['ticket_count']) . "</p>	
												</div>
												<div class=\"col\">
																<button 
																	type=\"submit\" 
																	id=\"remove\"
																	name=\"remove\" 
																	class=\"btn btn-danger\" 
																	aria-label=\"Submit\"
																>Remove</button>
															</div>
												<div class=\"col\">
													<p class=\"mb-1\">Price: $" . htmlspecialchars($ticket['cost']) . "</p>
												</div>
											</div>
											<input 
												type=\"hidden\" 
												name=\"index\" 
												value=\"" . htmlspecialchars($index) . "\"
											>	

														
										</form>
								</div>";
							}
						}
						?>
						<div class="card sticky-top" style="top: 80px;background-color: darkblue;">
							<div class="row align-items-center">
								<div class= "col">
									<label class="col form-label fw-bold fs-5 ms-3 text-white">Total:</label>
									<?php
									if (isset($_SESSION['totalPrice'])) {
										echo"<label class=\"col form-label fw-bold fs-5 ms-3 text-white\">$" . htmlspecialchars($_SESSION['totalPrice']) . "</label>";
									}
									?>
								</div>
								<div class="col-auto ms-auto me-3 mt-2 mb-2">
									<form method="POST" action="">							
										<button 
											type="submit" 
											id="checkout"
											name="checkout" 
											class="btn btn-primary" 
											aria-label="Submit"
										>Checkout</button>
									</form>									
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>


		<!--This is just a print for checking values stored-->
		<div class="d-flex flex-column">
			<?php
			
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
			}
			echo "<pre>";
			echo"<p>shoppingcart</p>"; 
			print_r($_SESSION['shoppingCart']);
			echo"<p>searchlist</p>"; 
			print_r($_SESSION['tickets']);
			echo"<p>tempticket</p>"; 
			print_r($_SESSION['temp_ticket']);
			print_r($_SESSION['temp_ticket']['cost']);
			echo"<p>totalPrice</p>";
			print_r($_SESSION['totalPrice']);
			echo "</pre>";
			
			
			?>
			
		</div>






		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</body>
</html>
