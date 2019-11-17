<?php 

    namespace App;

    class Connection {

        public static function getDB() {
            try {

                $conn = new \PDO(
                    "mysql:host=127.0.0.1;dbname=security",
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
