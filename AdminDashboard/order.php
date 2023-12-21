<?php
    namespace AdminDashboard;
    use PDO;
    use PDOException;
    include_once  '../AdminDashboard/DatabaseConnection.php';
    //order class inherits Database Connection class and they are in "AdminDashboard" namespace.
    //to use setConnection and getConnection functions to connect to the database
    //it helps in alot off functions that we will want!
        class order extends  DatabaseConnection
        {
            //order class has 7 properities.
            public $customer_id;
            public $product_id;
            public $tax_value;
            public $shipping_price;
            public $product_price;
            public $total;
            public $error;

            //to set new order properities and call insertIntoOrdersTable().
            public function setNewOder($customer_id, $product_id, $tax_value, $shipping_price, $product_price, $total){
                $this->customer_id = $customer_id;
                $this->product_id = $product_id;
                $this->tax_value = $tax_value;
                $this->shipping_price = $shipping_price;
                $this->product_price = $product_price;
                $this->total = $total;
                return $this->insertIntoOrdersTable();
            }

            //used to insert new order into my database
            public function insertIntoOrdersTable(){
                try {
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $sql = "INSERT INTO orders (customer_id, product_id,tax_value, shipping_price, product_price,total)
                                VALUES ('$this->customer_id', '$this->product_id', '$this->tax_value',
                                        '$this->shipping_price', '$this->product_price','$this->total')";
                    $connection->exec($sql);
                    $connection = null;
                    return true;
                }catch(PDOException $e) {
                    $this->setError($e->getMessage());
                }
            }

            //getting all orders from orders table in my admindb
            //and display them in an Agdrid.
            public function getAllOrders(){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt = $connection->prepare("SELECT * FROM orders");
                    $stmt->execute();
                    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                        $dataarr = $rows;
                    }
                    return json_encode($dataarr);
                    $connection = null;
                }catch(PDOException $e) {
                    $this->setError($e->getMessage());
                }
            }

            //deleting an order accoring to it's "id" from orders table
            public function where($q){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt_order = $connection->prepare("DELETE FROM orders WHERE order_id =  '$q'");
                    if($stmt_order->execute()){
                            return "Record deleted successfully";
                    }else {
                        echo "Error deleting record: ";
                    }
                        $connection = null;

                }catch (PDOException $e){
                    $this->setError($e->getMessage());
                }
            }

            //function used the display error message
            public function setError($errorMassage){
                $this->error = $errorMassage ;
            }

        }