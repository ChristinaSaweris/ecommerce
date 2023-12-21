<?php
session_start();
    include "../AdminDashboard/product.php";
    use AdminDashboard\product;

    //updating product properities according to the entered inputs from the form and using setProduct();
    //to set existing product properities with new values;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productid = $_POST["id"];
            $productName = $_POST["product_name"];
            $productdescription = $_POST["description"];
            $productprice = $_POST["price"];
            $productcost_price = $_POST["cost_price"];
            $productavailable_quantity = $_POST["quantity"];
            $tax_rate = $_POST["tax_rate"];
            $image_path = $_POST["product_image"];
            $product = new product();
            $updatedProduct = $product->setProduct($productid, $productName, $productdescription, $productprice,
                                                    $productcost_price, $productavailable_quantity,$tax_rate, $image_path);
            if ($updatedProduct){
                header("Location: products.php");
                exit();
            }else{
                echo $product->error ;
            }
        }
