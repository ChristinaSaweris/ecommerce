<?php
    include 'AdminDashboard/Admin.php';
    use AdminDashboard\Admin;
    $phone = "";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $phone = $_POST["phone"];
        $myObject = new Admin();
        $myObject->where($phone);
        session_start();
        $_SESSION['username'] = $myObject->name; // Store username in session for later use
        header("Location: home.php");
        exit();
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
          crossorigin="anonymous">
    <style>
        body {
            background-image: url('images/05.12.2023_12.38.16_REC.png');
            background-size: cover;
            background-position: center;
            background-repeat: repeat;
        }
    </style>
</head>
    <body>
        <div class="container">
            <div class="mx-5 mt-4 rounded-4" style="background-color: white">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="container mx-4">
                            <p class="fw-bold mt-5">Welcome back !!!</p>
                            <h2 class="fw-bold my-3">Log In</h2>
                            <form action="login.php" method="post">
                                <div class="col-lg-8">
                                    <label for="phone" class="form-label">Phone:</label>
                                    <input type="text" class="form-control " name="phone">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="password" class="form-control " name="password">
    <!--                                <span style="color: red">--><?php //echo $loginError;?><!--</span>-->
                                    <div class="d-flex justify-content-center mt-2">
                                        <button type="submit" name="submit" value="Submit" class="btn rounded-pill my-3" style="background-color: #d885a3">  log in  </button>
                                    </div>
                                 </div>
                            </form>
                            <div class="mx-5 mt-2">
                                <p >Don't have an account yet?  <a href="signup.php" style="text-decoration: none;color: #d885a3">Sign up for free</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 rounded-4" style="background-color:#c0dbea">
                        <div class="position-absolute top-25 start-50 py-5  my-5 mx-5">
                        <img class="mt-5"  src="images/05.12.2023_12.36.55_REC-removebg-preview.png" style="width: 200px">
                        <img class="mt-5" src="images/05.12.2023_12.37.14_REC-removebg-preview.png" style="width: 200px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
