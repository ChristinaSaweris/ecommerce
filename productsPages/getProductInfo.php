<?php
    include "../AdminDashboard/product.php";
    use AdminDashboard\product;

        //getting specific product data according to his id
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // Retrieve the selected option value from the AJAX request
            $selectedOption = $_GET["id"];
            $product = new product();
            echo $product->getWhere($selectedOption);
        }
