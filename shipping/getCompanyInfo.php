<?php
    include "../AdminDashboard/shippingCompany.php";
    use AdminDashboard\shippingCompany;

        //getting specific company data according to it's id
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // Retrieve the selected option value from the AJAX request
            $selectedOption = $_GET["shipping_company_id"];
            $company = new shippingCompany();
            echo $company->getWhere($selectedOption);
        }
