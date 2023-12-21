<?php
    include '../AdminDashboard/customer.php';
    use AdminDashboard\customer;
        //getting new customer data from the form in home.php page.
        //and making new customer object that setNewCustomer Properities
        // and insert the new customer into customer table and back to home.php page.
        $name = $phone1 = $phone2 =  $fb_account = $ins_account = $address = "";
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $name = $_POST["name"];
            $phone1 = $_POST["phone1"];
            $phone2 = $_POST["phone2"];
            $fb_account = $_POST["fb_account"];
            $ins_account = $_POST["ins_account"];
            $address = $_POST["address"];
            $customer = new customer();
            $new = $customer->setNewCustomer($name, $phone1, $phone2, $fb_account, $ins_account, $address);
            if ($new){
                header("Location: ../home.php");
                exit();
            }else{
                echo $customer->error ;
            }
        }
