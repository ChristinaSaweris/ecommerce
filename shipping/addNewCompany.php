<?php
    include '../AdminDashboard/shippingCompany.php';
    use AdminDashboard\shippingCompany;

        //getting new company data from the form in shippingCompanies.php page.
        //and making new company object that setNewcompany Properities
        // and insert the new company into shippingCompanies table and back to shippingCompanies.php page.
        $product_name = $shipping_cost = "";
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $product_name = $_POST["company_name"];
            $shipping_cost = $_POST["shipping_cost"];
            $company = new shippingCompany();
            $newCompany = $company->setNewCompany($product_name, $shipping_cost);
            if ($newCompany){
                header("Location: shippingCompanies.php");
                exit();
            }else{
                echo $company->error ;
            }
        }
