<?php


    namespace AdminDashboard;
    use PDO;
    use PDOException;
    include_once  '../AdminDashboard/DatabaseConnection.php';
    //product class inherits Database Connection class and they are in "AdminDashboard" namespace.
    //to use setConnection and getConnection functions to connect to the database
    //it helps in alot off functions that we will want!
        class product extends DatabaseConnection
        {
            //product class has 9 properities.
            public $id;
            public $product_name;
            public $description;
            public $price;
            public $cost_price;
            public $available_quantity;
            public $product_image;
            public $tax_rate;
            public $error;

            //to set new product properities and call insertIntoProductsTable().
            public function setNewProduct($name, $description, $price, $cost_price, $available_quantity,
                                          $product_image, $tax_rate){
                $this->product_name = $name;
                $this->description = $description;
                $this->price = $price;
                $this->cost_price = $cost_price;
                $this->available_quantity = $available_quantity;
                $this->product_image = $product_image;
                $this->tax_rate = $tax_rate;
                return $this->insertIntoProductsTable();
            }

            //setting exist product properities and call updateProduct().
            public function setProduct($id, $name, $description,$price, $cost_price, $available_quantity,
                                       $tax_rate, $product_image){
                $this->id = $id;
                $this->product_name = $name;
                $this->description = $description;
                $this->price = $price;
                $this->cost_price = $cost_price;
                $this->available_quantity = $available_quantity;
                $this->tax_rate = $tax_rate;
                $this->product_image = $product_image;
                return $this-> updateProduct();
            }

            //used to insert new product into my database
            public function insertIntoProductsTable(){
                try {
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $sql = "INSERT INTO products (product_name, description, price,cost_price, available_quantity, product_image,tax_rate)
                                VALUES ('$this->product_name', '$this->description', '$this->price', '$this->cost_price',
                                        '$this->available_quantity', '$this->product_image','$this->tax_rate')";
                    $connection->exec($sql);
                    $connection = null;
                    return true;
                }catch(PDOException $e) {
                    $this->setError($e->getMessage());
                }
            }

            //getting all Products from products table in my admindb
            //and display them in an Agdrid.
            public function getAllProducts(){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt = $connection->prepare("SELECT * FROM products");
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

            //getting product data  according to his id.
            public function getWhere($id){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt = $connection->prepare("SELECT * FROM products WHERE id = '$id'");
                    $stmt->execute();
                    while($rows = $stmt->fetchAll(PDO::FETCH_ASSOC)){
                        $dataarr = $rows;
                    }
                    $connection = null;
                    return json_encode($dataarr);
                }catch(PDOException $e) {
                    $this->setError($e->getMessage());
                }
            }

            //updating Product properities values according to his id
            public function updateProduct(){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt = $connection->prepare("UPDATE products 
                                                  SET product_name = '$this->product_name', description = '$this->description',
                                                   price = '$this->price', cost_price = '$this->cost_price',
                                                   available_quantity = '$this->available_quantity',tax_rate = '$this->tax_rate', product_image = '$this->product_image'
                                                  WHERE id = '$this->id'");
                    $stmt->execute();
                    $connection = null;
                    return true;
                }catch (PDOException $e){
                    $this->setError($e->getMessage());
                }
            }

            //deleting a product accoring to his "id" from orders and products tables
            //as orders table has a Foreign  key product_id
            public function where($q){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt_order = $connection->prepare("DELETE FROM orders WHERE product_id =  '$q'");
                    if($stmt_order->execute()){
                        $stmt_product = $connection->prepare("DELETE FROM products WHERE id = '$q'");
                        if($stmt_product->execute()){
                            return "Record deleted successfully";
                        }else {
                            echo "Error deleting record: ";
                        }
                        $connection = null;
                    }
                }catch (PDOException $e){
                    $this->setError($e->getMessage());
                }
            }

            //function used the display error message
            public function setError($errorMassage){
                $this->error = $errorMassage ;
            }
        }