<?php
    include '../AdminDashboard/shippingCompany.php';
    use AdminDashboard\shippingCompany;

    //getting all Companies data from the server and send them to shippingCompanies.php page
    //to use javascript code in shippingCompany.js to display them in an agGrid.
        $company = new shippingCompany();
        echo $company->getAllShippingCompanies();
