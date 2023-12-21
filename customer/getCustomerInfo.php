<?php
    include "../AdminDashboard/customer.php";
    use AdminDashboard\customer;

        //getting specific customer data according to his id
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // Retrieve the selected option value from the AJAX request
            $selectedOption = $_GET["id"];
            $customer = new customer();
            echo $customer->getWhere($selectedOption);
        }
