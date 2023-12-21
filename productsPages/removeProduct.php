<?php
    include "../AdminDashboard/product.php";
    use AdminDashboard\product;

    //getting the product id from $.ajax request and then making new product object and
    // delete that record using where();
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $productId = $_GET["id"];
            $product = new product();
            $new = $product->where($productId);
            if ($new){
                header("Location: products.php");
                exit();
            }else{
                echo $product->error ;
            }
        }
