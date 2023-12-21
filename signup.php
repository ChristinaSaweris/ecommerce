<?php
    include 'AdminDashboard/Admin.php';
    use AdminDashboard\Admin;

        //getting new admin data from the form in signup.php page.
        //and making new admin object that setNewadmin Properities
        // and insert the new admin into admin table and back to login.php page.
        $name = $phone = $password = "";
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $name = $_POST["name"];
            $phone = $_POST["phone"];
            $password = $_POST["password"];
            $myObject = new Admin();
            $new = $myObject->setNewAdmin($name, $phone, $password);
            if ($new){
                header("Location: login.php");
                exit();
            }else{
                echo $myObject->error ;
            }
        }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
          crossorigin="anonymous">
</head>
    <body>
        <div class="container d-flex justify-content-center mt-3">
            <div class="border border-info" style="height:400px; width: 400px">
                <div class="text-center my-3" >
                    <h1 style="color: darkblue">Welcome</h1>
                </div>
                <div class=" col-8 mt-3 m-5">
                    <form action="signup.php" method="post">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control " name="name" >
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="text" class="form-control " name="phone">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control " name="password"  >
                        <button type="submit" name="submit" value="Submit" class="btn btn-primary my-3">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>