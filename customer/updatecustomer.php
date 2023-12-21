<?php
    session_start();
    include '../AdminDashboard/customer.php';
    use AdminDashboard\customer;

    //updating customer properities according to the entered inputs from the form and using setCustomer();
    //to set existing customer properities with new values;
        $name = $phone1 = $phone2 =  $fb_account = $ins_account = $address = "";
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST["id"];
            $name = $_POST["name"];
            $phone1 = $_POST["phone1"];
            $phone2 = $_POST["phone2"];
            $fb_account = $_POST["fb_account"];
            $ins_account = $_POST["ins_account"];
            $address = $_POST["address"];
            $customer = new customer();
            $new = $customer->setCustomer($id, $name, $phone1, $phone2, $fb_account, $ins_account, $address);
            if ($new){
                header("Location: ../home.php");
                exit();
            }else{
                echo $customer->error ;
            }
        }
