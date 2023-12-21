<?php
    include "../AdminDashboard/order.php";
    use AdminDashboard\order;
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $orderId = $_GET["order_id"];
            $order = new order();
            $new = $order->where($orderId);
            if ($new){
                header("Location: ordersPage.php");
                exit();
            }else{
                echo $order->error ;
            }
        }
