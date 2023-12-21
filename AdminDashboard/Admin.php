<?php
    namespace AdminDashboard;
    use PDO;
    use PDOException;
    include_once  'AdminDashboard/DatabaseConnection.php';
        //Admin class inherits Database Connection class and they are in "AdminDashboard" namespace.
        //to use setConnection and getConnection functions to connect to the database
        //it helps in alot off functions that we will want!
        class Admin extends DatabaseConnection
        {
            //Admin class has 4 properities name,phone,password and error.
            public $name;
            public $phone;
            private $password;
            public $error;

            //to set new admin properities and call insertIntoAdminTable().
            public function setNewAdmin($name, $phone, $password){
                $this->name = $name;
                $this->phone = $phone;
                $this->password = $password;
                $this->insertIntoAdminTable();
            }

            //setting exist Admin properities
            public function setAdmin($name, $phone, $password){
                $this->name = $name;
                $this->phone = $phone;
                $this->password = $password;
            }

            //finding an admin according to his "$id" and getting his properities values
            // and uses setAdmin and setError functions
            public function find($id){
                try{
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $stmt = $connection->prepare("SELECT * FROM admin WHERE phone = '$id'");
                    $stmt->execute();
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if(!empty($rows)){
                        $name = $rows[0]['name'];
                        $phone = $rows[0]['phone'];
                        $password = $rows[0]['password'];
                        $this->setAdmin($name, $phone, $password);
                    }else{
                        $this->setError('لا يوجد معلومات ');
                    }
                    $connection = null;
                }catch (PDOException $e){
                    $this->setError($e->getMessage());
                }
            }

            //display an admin properities where his phone is '$q' and getting his properities values
            // and uses setAdmin and setError functions
            public function where($q){
               try{
                   $this->setConnection();
                   $connection = $this->getConnection();
                   $stmt = $connection->prepare("SELECT * FROM admin WHERE phone = '$q'");
                   $stmt->execute();
                   $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                   if(!empty($rows)){
                       $name = $rows[0]['name'];
                       $password = $rows[0]['password'];
                       $this->setAdmin($name, $q, $password);
                   }else{
                       $this->setError('لا يوجد معلومات ');
                   }
                   $connection = null;
               }catch (PDOException $e){
                   $this->setError($e->getMessage());
               }
            }

            //used to insert new admin into my database
            public function insertIntoAdminTable(){
                try {
                    $this->setConnection();
                    $connection = $this->getConnection();
                    $hashedPassword = md5($this->password);
                    $sql = "INSERT INTO admin (name, phone, password)
                                VALUES ('$this->name', '$this->phone', '$hashedPassword')";
                    $connection->exec($sql);
                    $connection = null;
                    header("Location: login.php");
                    exit();
                }catch(PDOException $e) {
                    $this->setError($e->getMessage());
                }
            }

            //function used the display error message
            public function setError($errorMassage){
                $this->error = $errorMassage ;
            }
        }