<?php
session_start();

/*
What do we want?


To have all ticket information That our user has bought.
Transaction information
All tickets

Want to refund a transaction?
Add Refund into Refund Transaction
Remove Tickets from database on refund

What do we need to get our information?
- transactions
- tickets

Transactions needs $_SESSION['id'] this is our unique id that can find all transactions linked to it
-stuff that into an array (think how we search for tickets same process can probably yoink the display from transactions)

Tickets needs all transaction ids, This will be in our transaction array.
- rinse and repeat for our tickets.

one array that holds transaction information
We will run a loop that creates and displays tickets in that transaction
*/


//connection to our database
include('/home/apw1043/p/dhb.inc');
// Connect to MySQL
$connect = mysqli_connect($db_server,$user,$password,$db_names);

// Connection error check
if ($connect->connect_error) {
	die("Could not connect: " . $connect->connect_error);
}


//finds user transactions
$query = $connect->prepare("Select transaction_id, transaction_date, total from transactions where account_id=?");
$query->bind_param("i",$_SESSION['id']);
$query->execute();

$result = $query->get_result();

	
$_SESSION['transactions'] = [];
	
//places them in array
while ($row = $result->fetch_assoc()) {
	$_SESSION['transactions'][]= $row;
}


//finds user tickets places them in array
$_SESSION['account_tickets'] = [];

foreach($_SESSION['transactions'] as $transaction) {
	$query = $connect->prepare("Select tt.transaction_ticket_id, tt.transaction_id, tt.cost, f.origin, f.destination from transaction_tickets tt join flights f on tt.flight_id = f.flight_id where transaction_id=?");
	$query->bind_param("i", $transaction['transaction_id']);
	$query->execute();
	$result = $query->get_result();
	while ($row = $result->fetch_assoc()) {
		$_SESSION['account_tickets'][]= $row;
	}
}





/*echo '<pre>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
print_r($_SESSION['transactions']);
print_r($_SESSION['account_tickets']);

echo '</pre>';*/



?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>My Info</title>
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
		
		<?php
		if (isset($_SESSION['logstatus'])) {
			$username = $_SESSION['username'];
			//$num_flights =

			//what info do we need for logic?
			//$_SESSION['transactions']
			//$_SESSION['account_tickets']
			//we make a loop that within a loop
			echo //note: why not just justify content center? fix at some point.
			'<div class="d-flex flex-column"> 
				<h3 class="text-center mt-5 pt-5 fw-bold">Your Account</h3>
				<h4 class="text-center mt-2">Hello ' . $username . '</h4>';
			if (!(isset($_SESSION['adminStatus']) && $_SESSION['adminStatus'] === 1)) {
				echo
				'<a class="btn btn-primary w-auto mx-auto" href="LoginSystem/adminSignup.php" role="button">Register as Admin</a>';
			}
			echo '</div>';
		} else { 
			echo 
			'<div class="d-flex flex-column">
				<h3 class="text-center mt-5 pt-5 fw-bold">Your Account</h3>
				<h4 class="text-center mt-2">Sorry, we can not seem to find your account information.</h4>
				<p class="text-center mt-2">To see your flights and account details, please sign in.</p>
				<a class="btn btn-primary w-25 mx-auto" href="LoginSystem/signin.php" role="button">Sign In</a>
			</div>';
		}
		echo '<div class="d-flex flex-column align-items-center align-self-center mt-3">
			  <h3 class="text-center fw-bold">Your Transactions</h3>';

		if (isset($_SESSION['logstatus'])) {
			echo '<div class="container-fluid mt-4">
					<div class="row">';
						foreach ($_SESSION['transactions'] as $transaction) {
									echo '<div class="col">
											<div class="card sticky-top">
												<div class="row align-items-center">
													<div class="col">
														<p class="mb-1">Transaction I.D. Number: #' . htmlspecialchars($transaction['transaction_id']) . '</p>	
													</div>
													<div class="col">
														<p class="mb-1">Transaction Date: ' . htmlspecialchars($transaction['transaction_date']) . '</p>	
													</div>
													<div class="col">
														<p class="mb-1">Total Price Paid: $' . htmlspecialchars($transaction['total']) . '</p>	
													</div>
													</div>';
																										

														foreach ($_SESSION['account_tickets'] as $ticket) {
															if ($ticket['transaction_id'] === $transaction['transaction_id']) {
																echo'<div class="row align-items-center">
																		<div class="col">
																			<p class="mb-1">Ticket I.D. Number: #' . htmlspecialchars($ticket['transaction_ticket_id']) . '</p>	
																		</div>
																		<div class="col">
																			<p class="mb-1">From: ' . htmlspecialchars($ticket['origin']) . '</p>	
																		</div>
																		<div class="col">
																			<p class="mb-1">To: ' . htmlspecialchars($ticket['destination']) . '</p>	
																		</div>
																		<div class="col">
																			<p class="mb-1">Ticket Price: $' . htmlspecialchars($ticket['cost']) . '</p>	
																		</div>																
																	</div>';

															}

									echo '		
											</div>
										</div>';
									}



							}
			echo '  </div>
				  </div>';
		}
		echo '</div>';
		?>
		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</body>
</html>
