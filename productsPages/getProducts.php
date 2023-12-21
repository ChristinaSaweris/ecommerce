<?php
    include "../AdminDashboard/product.php";
    use AdminDashboard\product;

    //getting all Products data from the server and send them to products.php page
    //to use javascript code in productJsCode.js to display them in an agGrid.
        $product = new product();
        echo $product->getAllProducts();


