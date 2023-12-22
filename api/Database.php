<?php

    class Database{
        private $host = "localhost";
        private $db_name = "catalogo_productos";
        private $db_user = "root";
        private $db_pass = "";
        private $conn;

        public function connect()
        {
            $this->conn = null;
            try
            {
                $this->conn = new PDO('mysql:host='.$this->host.';db_name='.
                    $this->db_name,$this->db_user,$this->db_pass);
            }catch(PDOException $e){
                echo "Error en la conexión: ".$e->getMessage();
            }

            return $this->conn;
        }
    }

?>