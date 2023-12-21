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
    <title>Shipping Companies</title>
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
                    <h4 style="color: cornflowerblue"> Welcome <span style="color: lightgreen"><?= $_SESSION["username"] ;?></span> <i class="fas fa-light fa-face-grin-hearts" style="color: #d66b8b;"></i> </h4>
                    <a  href ="#" onclick="addNewCompany()" style="color: #d66b8b; text-decoration: none">+Add New Company</a>
                </div>
            </div>
        </div>

        <div id="shippingCompaniesGrid"
             style="height: 500px; width: 75%;"
             class="ag-theme-alpine my-3">
        </div>

        <div class="modal fade" id="newComapnyModal" tabindex="-1" aria-labelledby="newComapnyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-l">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Insert Company Information</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="d-flex justify-content-center modal-body">
                        <div class=" col-lg-10">
                            <form action="addNewCompany.php" method="post" enctype="multipart/form-data">
                                <label for="name" class="form-label">Company Name:</label>
                                <input type="text" class="form-control " name="company_name">
                                <label for="shipping_cost" class="form-label">Shipping Cost:</label>
                                <input type="text" class="form-control " name="shipping_cost">
                                 <div class="d-flex justify-content-end">
                                     <button type="submit" name="submit" value="Submit" class="btn btn-primary my-3">Save</button>
                                 </div>
                            </form>
                        </div>
                    </div>
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
    <script src="/ecommerce/jsCode/shippingCompany.js"></script>
</body>
</html>
