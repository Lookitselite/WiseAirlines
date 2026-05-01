<?php
session_start();

//connection to our database
include('/home/tr1158/p/secret.php');
// Connect to MySQL
$connect = mysqli_connect($db_server,$user,$password,$db_names);

// Connection error check
if ($connect->connect_error) {
	die("Could not connect: " . $connect->connect_error);
}

//add our shopping cart into the database!

//In an Ideal world, we display our tickets similarly to the cart in the previous page
//But then we would just send to another page that displays Congrats! your transaction was made
//Instead we will just do all the heavy database work here
//This will be our congrats page with an option to look at your transaction via the my info page.

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
// this creates our transaction
$query = $connect->prepare("Insert into transactions (account_id, transaction_date) values (?,CURDATE())");
$query->bind_param("i",$_SESSION['id']);
$query->execute();

$transaction_id = $connect->insert_id; //this grabs our auto increment from the most recent insert, very helpful


//When CHECKOUT is clicked it should send tickets to the transaction_tickets table
//it looks like this:
//transaction_ticket_it---->auto increment, don't need to worry
//transaction_id ---->transaction table INT(11) Will grab after transaction insert
//flight_id---> $_SESSION['shoppingCart'][$cur_index]['flight_id]
//cost--> $_SESSION['shoppingCart'][$cur_index]['cost']

//NEEDED???  $_SESSION['shoppingCart'][$cur_index]['flight_id'], 
//NEEDED???  $_SESSION['shoppingCart'][$cur_index]['cost'], 
//NEEDED???  transaction_id QUERY

foreach ($_SESSION['shoppingCart'] as $ticket) {
    $query_cost = $connect->prepare("Select cost from flights where flight_id=?");
    $query_cost->bind_param("i", $ticket['flight_id']);
    $query_cost->execute();

    $result = $query_cost->get_result();
    $row =  $result->fetch_assoc();

    $cost = $row['cost'];

    for ($i = 0; $i < $ticket['ticket_count']; $i++) {
        $query = $connect->prepare("Insert into transaction_tickets (transaction_id, flight_id, cost) values (?,?,?)");
        $query->bind_param("iii",$transaction_id, $ticket['flight_id'], $cost);
        $query->execute();
    }

}


//AFTER EVERYTHING IS IN THE DATABASE unset shopping cart and everything attached to it, This way we can make new transactions.
if (isset($_SESSION['shoppingCart'])) {
    unset($_SESSION['shoppingCart']);
}
if (isset($_SESSION['totalPrice'])) {
    unset($_SESSION['totalPrice']);
}

header("Location:completeCheckout.php");
?>