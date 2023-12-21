<?php
    namespace AdminDashboard;
    use PDO;
    use PDOException;
        //DatabaseConnection produced to let connection using easy by
        // extends it and using set and get connection
        //and checking if tables exist or not if not exist will creat them.
        class DatabaseConnection
        {
            //public connection varaible
            public $conn ="";

            //in this function we setting connection to our admin database using PDO
            public function setConnection(){
                $db_server = 'localhost';
                $db_username = 'root';
                $db_password = '';
                $db_name = 'admindb';

                //check if the database is exis or not and if not exist create it
                try {
                    // Connect to MySQL/MariaDB server
                    $this->conn = new PDO("mysql:host=$db_server", $db_username, $db_password);

                    // Set the PDO error mode to exception
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // Check if the database exists
                    $stmt = $this->conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'");

                    // If the query executes without errors, the database exists
                    if($stmt){
                        try {
                            $this->conn = new PDO("mysql:host=$db_server;dbname=$db_name", $db_username, $db_password);
                            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            // check if orders table exist or not if not exist create it.
                            $orderstable = "orders";

                            // Check if the table exists
                            $ordersstmt = $this->conn->prepare("SHOW TABLES LIKE :table");
                            $ordersstmt->bindParam(':table', $orderstable, PDO::PARAM_STR);
                            $ordersstmt->execute();
                            $orderstableExists = $ordersstmt->fetch(PDO::FETCH_ASSOC);

                            //if orders table not exist it creat it
                            if (!$orderstableExists) {
                                $sql = "CREATE TABLE orders (
                                order_id INT PRIMARY KEY AUTO INCREMENT,
                                customer_id INT,
                                product_id INT,
                                tax_value INT,
                                shipping_price INT,
                                product_price INT,
                                total INT,
                                order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                FOREIGN KEY (customer_id) REFERENCES customer(id),
                                FOREIGN KEY (product_id) REFERENCES products(id))";
                                $this->conn->exec($sql);
                            }

                            // check if shippingCompanies table exist or not if not exist create it.
                            $shippingCompaniestable = "shippingCompanies";
                            // Check if the table exists
                            $shippingCompaniesstmt = $this->conn->prepare("SHOW TABLES LIKE :table");
                            $shippingCompaniesstmt->bindParam(':table', $shippingCompaniestable, PDO::PARAM_STR);
                            $shippingCompaniesstmt->execute();
                            $shippingCompaniestableExists = $shippingCompaniesstmt->fetch(PDO::FETCH_ASSOC);

                            //if $shippingCompaniestable table not exist it creat it
                            if (!$shippingCompaniestableExists) {
                                $sql = "CREATE TABLE shippingCompanies (
                                shipping_company_id INT PRIMARY KEY AUTO INCREMENT ,
                                company_name VARCHAR (25),
                                shipping_cost INT
                                )";
                                $this->conn->exec($sql);
                            }

                            // check if Admin table exist or not if not exist create it.
                            $admintable = "admin";
                            // Check if the table exists
                            $admintablestmt = $this->conn->prepare("SHOW TABLES LIKE :table");
                            $admintablestmt->bindParam(':table', $admintable, PDO::PARAM_STR);
                            $admintablestmt->execute();
                            $admintableExists = $admintablestmt->fetch(PDO::FETCH_ASSOC);

                            //if $admintable table not exist it creat it
                            if (!$admintableExists) {
                                $sql = "CREATE TABLE admin (
                                id INT(11) PRIMARY KEY AUTO INCREMENT ,
                                name VARCHAR (25),
                                phone VARCHAR (15) UNIQUE,
                                password char(255) 
                                )";
                                $this->conn->exec($sql);
                            }

                            // check if customer table exist or not if not exist create it.
                            $customertable = "customer";
                            // Check if the table exists
                            $customertablestmt = $this->conn->prepare("SHOW TABLES LIKE :table");
                            $customertablestmt->bindParam(':table', $customertable, PDO::PARAM_STR);
                            $customertablestmt->execute();
                            $customertableExists = $customertablestmt->fetch(PDO::FETCH_ASSOC);

                            //if $customertable table not exist it creat it
                            if (!$customertableExists) {
                                $sql = "CREATE TABLE customer (
                                id INT(11) PRIMARY KEY AUTO INCREMENT ,
                                name VARCHAR (25),
                                phone1 VARCHAR (15),
                                phone2 VARCHAR (15),
                                fb_account char(255),
                                ins_account char(255),
                                address char(255) 
                                )";
                                $this->conn->exec($sql);
                            }

                            // check if products table exist or not if not exist create it.
                            $productstable = "products";
                            // Check if the table exists
                            $productstablestmt = $this->conn->prepare("SHOW TABLES LIKE :table");
                            $productstablestmt->bindParam(':table', $productstable, PDO::PARAM_STR);
                            $productstablestmt->execute();
                            $productstableExists = $productstablestmt->fetch(PDO::FETCH_ASSOC);

                            //if $productstable table not exist it creat it
                            if (!$productstableExists) {
                                $sql = "CREATE TABLE products (
                                id INT(11) PRIMARY KEY AUTO INCREMENT ,
                                product_image blob,
                                product_name VARCHAR (25),
                                description char (255),
                                price int(11),
                                cost_price int(11),
                                available_quantity int(11),
                                 tax_rate float
                                )";
                                $this->conn->exec($sql);
                            }
                        } catch (PDOException $e) {
                            die("Connection failed: " . $e->getMessage());
                        }
                    }


                } catch (PDOException $e) {
                    // If the exception is about the database not existing, create it
                    if ($e->getCode() == 1049) {
                        try {
                            $this->conn->exec("CREATE DATABASE $db_name");
                            echo "Database '$db_name' created successfully.";
                        } catch (PDOException $ex) {
                            echo "Error creating database: " . $ex->getMessage();
                        }
                    } else {
                        echo "Error: " . $e->getMessage();
                    }
                }

//                // Close the database connection
//                $this->conn = null;
            }

            //function that makes our connection variable public and used anywhere.
            public function getConnection() {
                return $this->conn;
            }
        }