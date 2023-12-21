<?php
    include '../AdminDashboard/product.php';
    use AdminDashboard\product;

        //getting new product data from the form in products.php page.
        //and making new product object that setNewproduct Properities
        // and insert the new product into products table and back to products.php page.
        $product_name = $description = $price =  $cost_price = $available_quantity =
        $product_image_path = $tax_rate = $target_file ="";

        //here we choose product image and get the $target_file.
        if(isset($_POST["submit"])) {
            $target_dir = "../images/";
            $target_file = $target_dir . basename($_FILES["product_image"]["name"]);

            if(move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["product_image"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $product_name = $_POST["product_name"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $cost_price = $_POST["cost_price"];
            $available_quantity = $_POST["quantity"];
            $product_image_path = $target_file;
            $tax_rate = $_POST["tax_rate"];
            $product = new product();
            $newProduct = $product->setNewProduct($product_name, $description, $price,
                                                  $cost_price, $available_quantity, $product_image_path, $tax_rate);
            if ($newProduct){
                header("Location: products.php");
                exit();
            }else{
                echo $product->error ;
            }
        }