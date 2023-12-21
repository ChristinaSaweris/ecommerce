<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
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
                            <a class="nav-link active" aria-current="page" href="home.php" style="color: darkblue">Customers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../ecommerce/productsPages/products.php" style="color: darkblue">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="orders/ordersPage.php" style="color: darkblue">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="shipping/shippingCompanies.php" style="color: darkblue">Shipping Companies</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-lg-6">
                <div>
                    <h4 style="color: cornflowerblue"> Welcome <span style="color: lightgreen"><?php echo $_SESSION["username"] ;?>
                        </span> <i class="fas fa-light fa-face-grin-hearts" style="color: #d66b8b;"></i>
                    </h4>
                </div>
            </div>
            <div class="col-lg-6 d-flex justify-content-end mt-3">
                <div>
                    <a  href ="#" onclick="addNewCustomer()" style="color: #d66b8b; text-decoration: none">+Add New Customer</a>
                </div>
            </div>
        </div>
        <div id="myGrid"
             style="height: 500px; width: 100%;"
             class="ag-theme-alpine my-3">
        </div>
        <div class="modal fade" id="newCustomerModal" tabindex="-1" aria-labelledby="newCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-l">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Insert Customer Information</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../ecommerce/customer/addNewCustomer.php" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="hidden" class="form-control " name="id">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control " name="name">
                                    <label for="phone1" class="form-label">Phone1:</label>
                                    <input type="text" class="form-control " name="phone1">
                                    <label for="phone2" class="form-label">Phone2:</label>
                                    <input type="text" class="form-control " name="phone2">
                                </div>
                                <div class="col-lg-6">
                                    <label for="fb_account" class="form-label">FaceBook Account:</label>
                                    <input type="text" class="form-control " name="fb_account">
                                    <label for="ins_account" class="form-label">Instagram Account:</label>
                                    <input type="text" class="form-control " name="ins_account">
                                    <label for="address" class="form-label">Address:</label>
                                    <input type="text" class="form-control " name="address">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" name="submit" value="Submit" class="btn btn-primary my-3">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- hidden Model that i made in it's body form in "customer.js" -->
        <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-l">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Customer Information</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modalContent" ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="jsCode/customer.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>
</html>
