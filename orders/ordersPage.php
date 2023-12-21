<?php
    use AdminDashboard\product;
    use AdminDashboard\customer;
    use AdminDashboard\shippingCompany;
    use AdminDashboard\order;
    include_once  "../AdminDashboard/product.php";
    include_once  "../AdminDashboard/customer.php";
    include_once  "../AdminDashboard/shippingCompany.php";
    include_once  "../AdminDashboard/order.php";

    session_start();

        $product = new product();
        $productResult = $product->getAllProducts();
        $productData = json_decode($productResult, true);

        $customer = new customer();
        $customerResult = $customer->getAllCustomers();
        $customerData = json_decode($customerResult, true);

        $company = new shippingCompany();
        $companyResult = $company->getAllShippingCompanies();
        $companyData = json_decode($companyResult, true);

        $customer_id = $product_id = $tax_rate = $tax_value = $shipping_price = $product_price = $product_Tax_price = $total =  "";
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $customer_id = $_POST["customerid"];
            $product_id = $_POST["productid"];
            $tax_rate = $_POST["hidden_tax_rate"];
            $product_price = $_POST["product_price"];
            $shipping_price = $_POST["hidden_shipping_cost"];
            $tax_value = $product_price * ($tax_rate / 100);
            $product_Tax_price = $product_price + $tax_value;
            $total = $shipping_price + $product_Tax_price;
            $order = new order();
            $newOder = $order->setNewOder($customer_id, $product_id, $tax_value, $shipping_price, $product_price, $total);
            if ($newOder){
                header("Location: ordersPage.php");
                exit();
            }else{
                echo $order->error ;
            }
        }

?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Order</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
          crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script>
    <!-- Include the core CSS, this is needed by the grid -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-grid.css"/>
    <!-- Include the theme CSS, only need to import the theme you are going to use -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-theme-alpine.css"/>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg" style="background-color: aliceblue;">
            <div class="container-fluid">
                <a class="navbar-brand" style="color: #d66b8b"><i class="fas fa-duotone fa-house"></i></a>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../home.php" style="color: darkblue">HOME</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-lg-6">
                <div>
                    <h4 style="color: cornflowerblue"> Welcome <span style="color: lightgreen"><?= $_SESSION["username"] ;?></span>
                        <i class="fas fa-light fa-face-grin-hearts" style="color: #d66b8b;"></i>
                    </h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="container d-flex justify-content-center mt-3">
                    <div class="border border-info" style="height:500px; width: 100%">
                        <div class=" mt-3 m-5">
                            <form action="ordersPage.php" method="post">
                                <div class="text-center">
                                    <h2>New Order</h2>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6  mt-4">
                                        <label for="products">Products:</label>
                                        <select class="form-control" name="products" id="products" onchange="getProductOptionValue(this.value)">
                                            <option selected>Select a Product...</option>
                                            <?php
                                            foreach ($productData as $option) {
                                                echo '<option value="' . htmlspecialchars($option['id'])  . '">' . htmlspecialchars($option['product_name']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="quantity" class="form-label mt-3">Available Quantity:</label>
                                        <input type="text" class="form-control " name="quantity" id="quantity" onchange="validateInput();">
                                        <span id="result" style="color: red ; display: none" ></span>
                                        <label for="cost_price" class="form-label">Price:</label>
                                        <input type="text" class="form-control " name="cost_price" id="cost_price" disabled>
                                        <input type="hidden" class="form-control " name="product_price" id="product_price">
                                        <label for="tax_rate" class="form-label mt-1">Tax Rate (%):</label>
                                        <input type="text" class="form-control " name="tax_rate" id="tax_rate" disabled>
                                        <input type="hidden" class="form-control " name="hidden_tax_rate" id="hidden_tax_rate">
                                        <input type="hidden" class="form-control"  name="productid" id="productid" >
                                        <input type="hidden" class="form-control"  name="compare_quantity" id="compare_quantity" >
                                    </div>
                                    <div class="col-lg-6 mt-4" >
                                        <label for="customer">Customer:</label>
                                        <select class="form-control" name="customer" id="customer" onchange="getCustomerOptionValue(this.value)">
                                            <option selected>Select a Customer...</option>
                                            <?php
                                            foreach ($customerData as $option) {
                                                echo '<option value="' . htmlspecialchars($option['id'])  . '">' . htmlspecialchars($option['name']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" class="form-control"  name="customerid" id="customerid" >
                                        <label for="company" class="mt-4">Shipping Company:</label>
                                        <select class="form-control" name="company" id="company" onchange="getcompanyOptionValue(this.value)">
                                            <option selected>Select a Company...</option>
                                            <?php
                                            foreach ($companyData as $option) {
                                                echo '<option value="' . htmlspecialchars($option['shipping_company_id'])  . '">' . htmlspecialchars($option['company_name']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="shipping_cost" class="form-label">Shipping Cost:</label>
                                        <input type="text" class="form-control"  name="shipping_cost" id="shipping_cost" disabled>
                                        <input type="hidden" class="form-control"  name="hidden_shipping_cost" id="hidden_shipping_cost">
                                        <input type="hidden" class="form-control"  name="companyid" id="companyid" >
                                        <div class="d-flex justify-content-center mt-2">
                                            <button type="submit" name="submit" value="Submit" class="btn btn-primary my-3">Order</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div id="ordersGrid"
                     style="height: 500px; width: 100%;"
                     class="ag-theme-alpine my-3">
                </div>
            </div>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
<script src="/ecommerce/jsCode/orders.js"></script>
</body>
</html>
