Thought I'd leave this so we can keep track of what's being worked on

## Front-end Work Queue:

### 1: Functional Account Page

- I want to regester to be an admin from the accounts page (as having session variables already set makes this so much easier)
- To do that, the page should at minimum display some account information, making it look nice comes later

#### Status: 

- basic functionality

### 2: Admin Regestration

- All freshly regestered users are set to not be an admin at base, they should need to do second regestration
- Page can function as a modified version of the original regestration, finding the user with their session variables 
- Use admin password linked in DHB for security

#### Status: 

- page exists, not complete

### 3: Booking Flights

- yknow
- like an airline website should
- im gonna think about this more when i get some more sleep

## Misc. Work:

### 1: README

- Good documentation is important

### Game Plan for Transactions. -todd

### Database 
tables constructed with foreign keys and constraints
needs a trigger or two (background process)
# Tables

- accounts (account_id, username,password, email,adminStatus)
- employees (employee_id, role, rate, hours)
- flights(flight_id,origin, destination, cost) may need to update this one, if we want dates and times for flights, we can add that stuff later this also needs to be fleshed out with actual flights we will be 'selling'
- transactions (transaction_id, account_id, transaction_date, total)
- transaction_tickets(transaction_ticket_id,transaction_id,flight_id,cost)  

## Todo  

### Shopping Cart/transaction page  
The functionality of the page based off the database will be as follows:  

Step 1: What information do we need to make a transaction?
- account_id (just prompt database)
- date (should be a way to find todays date)

This is all we need to Transaction insert.

Step 2: What information do we need to book flights?
- transaction_id,(we will grab post transaction insert)
- flight_id(customer chooses flight, we select id)
- cost(customer chooses flight, we select cost)

This is all we need for transaction_ticket insert.  

Once this information is collected, we insert information into the database.  (IN THIS ORDER) 

Transaction insert(account_id, date)

Loop for all tickets
    transaction_ticket insert (transaction_id, flight_id, cost)



