<?php 

    namespace App;

    class Connection {

        public static function getDB() {
            try {

                $conn = new \PDO(
                    "mysql:host=localhost;dbname=security",
                    "security",
                    "security"
                );

                return $conn;

            } catch (\PDOException $e) {
                echo "OPS!".$e;
            }
        }
    }


?>