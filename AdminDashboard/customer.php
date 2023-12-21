<?php

    namespace AdminDashboard;
    use PDO;
    use PDOException;
    include_once  '../AdminDashboard/DatabaseConnection.php';
    //customer class inherits Database Connection class and they are in "AdminDashboard" namespace.
    //to use setConnection and getConnection functions to connect to the database
    //it helps in alot off functions that we will want!
        class customer extends DatabaseConnection
        {
            //customer class has 8 properities.
            public $id;
            public $name;
            public $phone1;
            public $phone2;
            public $fb_account;
            public $ins_account;
            public $address;
            public $error;

            //to set new customer properities and call insertIntoCustomerTable().
            public function setNewCustomer($name, $phone1, $phone2, $fb_account, $ins_account, $address){
                $this->name = $name;
                $this->phone1 = $phone1;
                $this->phone2 = $phone2;
                $this->fb_account = $fb_account;
                $this->ins_account = $ins_account;
                $this->address = $address;
                return $this->insertIntoCustomerTable();
            }

            //setting exist Admin properities and call updateCustomer().
            public function setCustomer($id, $name, $phone1,$phone2, $fb_account, $ins_account, $address){
                $this->id = $id;
                $this->name = $name;
                $this->phone1 = $phone1;
                $this->phone2 = $phone2;
                $this->fb_account = $fb_account;
                $this->ins_account = $ins_account;
                $this->address = $address;
                return $this-> updateCustomer();
            }

            //used to insert new customer into my database
            public function insertIntoCustomerTable(){
                try {
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $sql = "INSERT INTO customer (name, phone1, phone2,fb_account, ins_account, address)
                                VALUES ('$this->name', '$this->phone1', '$this->phone2', '$this->fb_account',
                                        '$this->ins_account','$this->address')";
                    $connection->exec($sql);
                    $connection = null;
                    return true;
                }catch(PDOException $e) {
                    $this->setError($e->getMessage());
                }
            }

            //getting all customers from customer table in my admindb
            //and display them in an Agdrid.
            public function getAllCustomers(){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt = $connection->prepare("SELECT * FROM customer");
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

            //updating cutomer properities values according to his id
            public function updateCustomer(){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt = $connection->prepare("UPDATE customer 
                                                  SET name = '$this->name', phone1 = '$this->phone1',
                                                   phone2 = '$this->phone2', fb_account = '$this->fb_account',
                                                   ins_account = '$this->ins_account', address = '$this->address'
                                                  WHERE id = '$this->id'");
                    $stmt->execute();
                    $connection = null;
                    return true;
                }catch (PDOException $e){
                    $this->setError($e->getMessage());
                }
            }

            //deleting a customer accoring to his "id" from orders and customer tables
            //as orders table has a Foreign  key customer_id
            public function where($q){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt_order = $connection->prepare("DELETE FROM orders WHERE customer_id = '$q'");
                    if($stmt_order->execute()){
                        $stmt_customer = $connection->prepare("DELETE FROM customer WHERE id = '$q'");
                        if($stmt_customer->execute()){
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

            //getting customer data  according to his id.
            public function getWhere($id){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt = $connection->prepare("SELECT * FROM customer WHERE id = '$id'");
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

            //function used the display error message
            public function setError($errorMassage){
                $this->error = $errorMassage ;
            }
        }