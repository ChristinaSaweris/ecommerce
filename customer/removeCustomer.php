<?php
    include '../AdminDashboard/customer.php';
    use AdminDashboard\customer;

    //getting the customer id from $.ajax request and then making new customer object and
    // delete that record using where();
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $customerId = $_GET["id"];
            $customer = new customer();
            $new = $customer->where($customerId);
            if ($new){
                header("Location: ../home.php");
                exit();
            }else{
                echo $customer->error ;
            }
        }

