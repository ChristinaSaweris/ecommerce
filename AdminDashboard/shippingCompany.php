<?php
    namespace AdminDashboard;
    use PDO;
    use PDOException;
    include_once  '../AdminDashboard/DatabaseConnection.php';
    //shippingCompany class inherits Database Connection class and they are in "AdminDashboard" namespace.
    //to use setConnection and getConnection functions to connect to the database
    //it helps in alot off functions that we will want!
        class shippingCompany extends DatabaseConnection
        {
            //shippingCompany class has 3 properities.
            public $name;
            public $shipping_cost;
            public $error;

            //to set new company properities and call insertIntoShippingCompaniesTable().
            public function setNewCompany($name, $shipping_cost){
                $this->name = $name;
                $this->shipping_cost = $shipping_cost;
                return $this->insertIntoShippingCompaniesTable();
            }

            //used to insert new shipping company into my database
            public function insertIntoShippingCompaniesTable(){
                try {
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $sql = "INSERT INTO shippingCompanies (company_name, shipping_cost)
                                VALUES ('$this->name', '$this->shipping_cost')";
                    $connection->exec($sql);
                    $connection = null;
                    return true;
                }catch(PDOException $e) {
                    $this->setError($e->getMessage());
                }
            }

            //getting all ShippingCompanies from shippingCompanies table in my admindb
            //and display them in an Agdrid.
            public function getAllShippingCompanies(){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt = $connection->prepare("SELECT * FROM shippingCompanies");
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

            //deleting a company accoring to it's "id"
            public function where($q){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt_company = $connection->prepare("DELETE FROM shippingCompanies WHERE shipping_company_id = '$q'");
                    if($stmt_company->execute()){
                        return "Record deleted successfully";
                    }else{
                            echo "Error deleting record: ";
                    }
                    $connection = null;
                }catch (PDOException $e){
                    $this->setError($e->getMessage());
                }
            }

            //getting company data  according to his id.
            public function getWhere($id){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt = $connection->prepare("SELECT * FROM shippingCompanies WHERE shipping_company_id = '$id'");
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