<?php
session_start();
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
			echo //note: why not just justify content center? fix at some point.
			'<div class="d-flex flex-column"> 
				<h3 class="text-center mt-5 pt-5 fw-bold">Your Account</h3>
				<h4 class="text-center mt-2">Hello ' . $username . '</h4>
				<h5 class="text-center mt-2">Your role is: ' . $_SESSION['role'] . '</h5>';
			if (isset($_SESSION['role'])) {
				$role = $_SESSION['role'];
				if ($role = 'System admin' || $role = 'Sales') {
				//given flight_id, update flight cost
				} else if ($role = 'System admin' || $role = 'Customer service') {
				//given username, list their tickets
				} else {
					echo 'you are a roleless employee. oops, thats a bug';
				}
			}
			echo '</div>';
		}
		?>

		<div class="row">
			<div class="col-12 d-flex justify-content-center">
				<div class="card card-margin">
					<ul class="nav nav-tabs">
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="adminAccount.php">Your Account</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="adminAccountEmployee.php">Employees</a>
						</li>

						<li class="nav-item">
							<a class="nav-link active" href="adminAccountCustomers.php">Customers</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="adminAccountFlights.php">Flights</a>
						</li>
						
					</ul>
					 <div class="row">
                        <div class="col-lg-12">
                            <div class="employees">
                                <div class="employees-header">
                                    <div class="row">
                                        <div class="col-lg-6">
											<h3 class="text-center mt-5 pt-5 fw-bold">Employee List</h3>
											<hr>

                                        </div>
                                        

                                    </div>
                                </div>
                                <div class="employees-body">
                                    <div class="table-responsive">
                                        <table class="table widget-26">
                                            <tbody>
                                                <tr><!-- The row we will loop for all employees, transactions, flights, tickets, accounts, will contain these table rows -->
                                                    <td>
                                                        <div class="widget-26-job-title"> 
                                                            <a href="#">Senior Software Engineer / Developer</a>
                                                            <p class="m-0"><a href="#" class="employer-name">Axiom Corp.</a> <span class="text-muted time">1 days ago</span></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-info">
                                                            <p class="type m-0">Full-Time</p>
                                                            <p class="text-muted m-0">in <span class="location">London, UK</span></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-salary">$ 50/hr</div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-category bg-soft-base">
                                                            <i class="indicator bg-base"></i>
                                                            <span>Software Development</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-starred">
                                                            <a href="#">
                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    width="24"
                                                                    height="24"
                                                                    viewBox="0 0 24 24"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    class="feather feather-star"
                                                                >
                                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>                                               
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				
			</div>
		</div>





		<!-- Employee list -->
		<div class="row">
        <div class="col-12">
            <div class="card card-margin">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="employees">
                                <div class="employees-header">
                                    <div class="row">
                                        <div class="col-lg-6">
											<h3 class="text-center mt-5 pt-5 fw-bold">Employee List</h3>
											<hr>

                                        </div>
                                        

                                    </div>
                                </div>
                                <div class="employees-body">
                                    <div class="table-responsive">
                                        <table class="table widget-26">
                                            <tbody>
                                                <tr><!-- The row we will loop for all employees, transactions, flights, tickets, accounts, will contain these table rows -->
                                                    <td>
                                                        <div class="widget-26-job-title"> 
                                                            <a href="#">Senior Software Engineer / Developer</a>
                                                            <p class="m-0"><a href="#" class="employer-name">Axiom Corp.</a> <span class="text-muted time">1 days ago</span></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-info">
                                                            <p class="type m-0">Full-Time</p>
                                                            <p class="text-muted m-0">in <span class="location">London, UK</span></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-salary">$ 50/hr</div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-category bg-soft-base">
                                                            <i class="indicator bg-base"></i>
                                                            <span>Software Development</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-starred">
                                                            <a href="#">
                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    width="24"
                                                                    height="24"
                                                                    viewBox="0 0 24 24"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    class="feather feather-star"
                                                                >
                                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>                                               
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		</div>
	<!-- Customer list-->
		<div class="row">
        <div class="col-12">
            <div class="card card-margin">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="employees">
                                <div class="employees-header">
                                    <div class="row">
                                        <div class="col-lg-6">
											<h3 class="text-center mt-5 pt-5 fw-bold">All Customers</h3>
											<hr>

                                        </div>
                                        

                                    </div>
                                </div>
                                <div class="employees-body">
                                    <div class="table-responsive">
                                        <table class="table widget-26">
                                            <tbody>
                                                <tr><!-- The row we will loop for all employees, transactions, flights, tickets, accounts, will contain these table rows -->
                                                    <td>
                                                        <div class="widget-26-job-title"> 
                                                            <a href="#">Senior Software Engineer / Developer</a>
                                                            <p class="m-0"><a href="#" class="employer-name">Axiom Corp.</a> <span class="text-muted time">1 days ago</span></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-info">
                                                            <p class="type m-0">Full-Time</p>
                                                            <p class="text-muted m-0">in <span class="location">London, UK</span></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-salary">$ 50/hr</div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-category bg-soft-base">
                                                            <i class="indicator bg-base"></i>
                                                            <span>Software Development</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-starred">
                                                            <a href="#">
                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    width="24"
                                                                    height="24"
                                                                    viewBox="0 0 24 24"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    class="feather feather-star"
                                                                >
                                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>                                               
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		</div>
<!-- Transactions -->
		<div class="row">
        <div class="col-12">
            <div class="card card-margin">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="employees">
                                <div class="employees-header">
                                    <div class="row">
                                        <div class="col-lg-6">
											<h3 class="text-center mt-5 pt-5 fw-bold">All Transactions</h3>
											<hr>

                                        </div>
                                        

                                    </div>
                                </div>
                                <div class="employees-body">
                                    <div class="table-responsive">
                                        <table class="table widget-26">
                                            <tbody>
                                                <tr><!-- The row we will loop for all employees, transactions, flights, tickets, accounts, will contain these table rows -->
                                                    <td>
                                                        <div class="widget-26-job-title"> 
                                                            <a href="#">Senior Software Engineer / Developer</a>
                                                            <p class="m-0"><a href="#" class="employer-name">Axiom Corp.</a> <span class="text-muted time">1 days ago</span></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-info">
                                                            <p class="type m-0">Full-Time</p>
                                                            <p class="text-muted m-0">in <span class="location">London, UK</span></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-salary">$ 50/hr</div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-category bg-soft-base">
                                                            <i class="indicator bg-base"></i>
                                                            <span>Software Development</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-starred">
                                                            <a href="#">
                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    width="24"
                                                                    height="24"
                                                                    viewBox="0 0 24 24"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    class="feather feather-star"
                                                                >
                                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>                                               
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		</div>
	<!-- tickets -->
		<div class="row">
        <div class="col-12">
            <div class="card card-margin">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="employees">
                                <div class="employees-header">
                                    <div class="row">
                                        <div class="col-lg-6">
											<h3 class="text-center mt-5 pt-5 fw-bold">All Tickets</h3>
											<hr>

                                        </div>
                                        

                                    </div>
                                </div>
                                <div class="employees-body">
                                    <div class="table-responsive">
                                        <table class="table widget-26">
                                            <tbody>
                                                <tr><!-- The row we will loop for all employees, transactions, flights, tickets, accounts, will contain these table rows -->
                                                    <td>
                                                        <div class="widget-26-job-title"> 
                                                            <a href="#">Senior Software Engineer / Developer</a>
                                                            <p class="m-0"><a href="#" class="employer-name">Axiom Corp.</a> <span class="text-muted time">1 days ago</span></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-info">
                                                            <p class="type m-0">Full-Time</p>
                                                            <p class="text-muted m-0">in <span class="location">London, UK</span></p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-salary">$ 50/hr</div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-category bg-soft-base">
                                                            <i class="indicator bg-base"></i>
                                                            <span>Software Development</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="widget-26-job-starred">
                                                            <a href="#">
                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    width="24"
                                                                    height="24"
                                                                    viewBox="0 0 24 24"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    class="feather feather-star"
                                                                >
                                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>                                               
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		</div>

		<div class="container mt-5 pt-4">
			<div class="row align-items-end mb-4 pb-2">
				<div class="col-md-8">
					<div class="section-title text-center text-md-start">
						<h4 class="title mb-4">Find the perfect jobs</h4>
						<p class="text-muted mb-0 para-desc">Start work with Leaping. Build responsive, mobile-first projects on the web with the world's most popular front-end component library.</p>
					</div>
				</div><!--end col-->

				<div class="col-md-4 mt-4 mt-sm-0 d-none d-md-block">
					<div class="text-center text-md-end">
						<a href="#" class="text-primary">View more Jobs <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right fea icon-sm"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
					</div>
				</div><!--end col-->
			</div><!--end row-->

			<div class="row">
				<div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
					<div class="card border-0 bg-light rounded shadow">
						<div class="card-body p-4">
							<span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0">Full time</span>
							<h5>Web Designer</h5>
							<div class="mt-3">
								<span class="text-muted d-block"><i class="fa fa-home" aria-hidden="true"></i> <a href="#" target="_blank" class="text-muted">Bootdey.com LLC.</a></span>
								<span class="text-muted d-block"><i class="fa fa-map-marker" aria-hidden="true"></i> USA</span>
							</div>
							
							<div class="mt-3">
								<a href="#" class="btn btn-primary">View Details</a>
							</div>
						</div>
					</div>
				</div><!--end col-->
				
				<div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
					<div class="card border-0 bg-light rounded shadow">
						<div class="card-body p-4">
							<span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0">Remote</span>
							<h5>Front-end Developer</h5>
							<div class="mt-3">
								<span class="text-muted d-block"><i class="fa fa-home" aria-hidden="true"></i> <a href="#" target="_blank" class="text-muted">Bootdey.com LLC.</a></span>
								<span class="text-muted d-block"><i class="fa fa-map-marker" aria-hidden="true"></i> USA</span>
							</div>
							
							<div class="mt-3">
								<a href="#" class="btn btn-primary">View Details</a>
							</div>
						</div>
					</div>
				</div><!--end col-->
				
				<div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
					<div class="card border-0 bg-light rounded shadow">
						<div class="card-body p-4">
							<span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0">Contract</span>
							<h5>Web Developer</h5>
							<div class="mt-3">
								<span class="text-muted d-block"><i class="fa fa-home" aria-hidden="true"></i> <a href="#" target="_blank" class="text-muted">Bootdey.com LLC.</a></span>
								<span class="text-muted d-block"><i class="fa fa-map-marker" aria-hidden="true"></i> USA</span>
							</div>
							
							<div class="mt-3">
								<a href="#" class="btn btn-primary">View Details</a>
							</div>
						</div>
					</div>
				</div><!--end col-->
				
				<div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
					<div class="card border-0 bg-light rounded shadow">
						<div class="card-body p-4">
							<span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0">WFH</span>
							<h5>Back-end Developer</h5>
							<div class="mt-3">
								<span class="text-muted d-block"><i class="fa fa-home" aria-hidden="true"></i> <a href="#" target="_blank" class="text-muted">Bootdey.com LLC.</a></span>
								<span class="text-muted d-block"><i class="fa fa-map-marker" aria-hidden="true"></i> USA</span>
							</div>
							
							<div class="mt-3">
								<a href="#" class="btn btn-primary">View Details</a>
							</div>
						</div>
					</div>
				</div><!--end col-->
				
				<div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
					<div class="card border-0 bg-light rounded shadow">
						<div class="card-body p-4">
							<span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0">Full time</span>
							<h5>UX / UI Designer</h5>
							<div class="mt-3">
								<span class="text-muted d-block"><i class="fa fa-home" aria-hidden="true"></i> <a href="#" target="_blank" class="text-muted">Bootdey.com LLC.</a></span>
								<span class="text-muted d-block"><i class="fa fa-map-marker" aria-hidden="true"></i> USA</span>
							</div>
							
							<div class="mt-3">
								<a href="#" class="btn btn-primary">View Details</a>
							</div>
						</div>
					</div>
				</div><!--end col-->
				
				<div class="col-lg-4 col-md-6 col-12 mt-4 pt-2">
					<div class="card border-0 bg-light rounded shadow">
						<div class="card-body p-4">
							<span class="badge rounded-pill bg-primary float-md-end mb-3 mb-sm-0">Remote</span>
							<h5>Tester</h5>
							<div class="mt-3">
								<span class="text-muted d-block"><i class="fa fa-home" aria-hidden="true"></i> <a href="#" target="_blank" class="text-muted">Bootdey.com LLC.</a></span>
								<span class="text-muted d-block"><i class="fa fa-map-marker" aria-hidden="true"></i> USA</span>
							</div>
							
							<div class="mt-3">
								<a href="#" class="btn btn-primary">View Details</a>
							</div>
						</div>
					</div>
				</div><!--end col-->

				<div class="col-12 mt-4 pt-2 d-block d-md-none text-center">
					<a href="#" class="btn btn-primary">View more Jobs <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right fea icon-sm"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
				</div><!--end col-->
			</div><!--end row-->
		</div>

		
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	</body>
</html>
