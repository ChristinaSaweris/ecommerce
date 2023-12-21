<?php
    include "../AdminDashboard/order.php";
    use AdminDashboard\order;
        $order = new order();
        echo $order->getAllOrders();
