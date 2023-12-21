<?php
    include "../AdminDashboard/shippingCompany.php";
    use AdminDashboard\shippingCompany;

    //getting the company id from $.ajax request and then making new company object and
    // delete that record using where();
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $companyId = $_GET["shipping_company_id"];
            $company = new shippingCompany();
            $new = $company->where($companyId);
            if ($new){
                header("Location: shippingCompanies.php");
                exit();
            }else{
                echo $company->error ;
            }
        }
