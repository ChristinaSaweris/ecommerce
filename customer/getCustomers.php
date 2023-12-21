<?php
    include "../AdminDashboard/customer.php";
    use AdminDashboard\customer;

    //getting all customers data from the server and send them to home.php page
    //to use javascript code in customer.js to display them in an agGrid.
        $customer = new customer();
        echo $customer->getAllCustomers();

