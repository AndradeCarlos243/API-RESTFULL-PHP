<?php
    class Categoria{
        private $db = new Database;
        private $table = 'categorias';

        //Propiedades
        public $id;
        public $nombre;
        public $fecha_creacion;

        //Constructor con DB
        public function __construct($db){
            $this->db = $db;
        }

        public function getCategorias(){
            //Creamos el query
            $query = 'SELECT id, nombre, fecha_creacion FROM '.$this->table.' ORDER BY fecha_creacion DESC';
            //Preparamos el query
            $stmt = $this->db->prepare($query);
            //Ejecutamos el query
            $stmt->execute();
            return $stmt;
        }

        public function getCategoria(){
            //Creamos el query
            $query = 'SELECT id, nombre, fecha_creacion FROM '.
                $this->table.' WHERE id = ? LIMIT 0,1';
            
            //Preparamos el query
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1,$this->id);
            
            //Ejecutamos el query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id=$row['id'];
            $this->nombre=$row['nombre'];
            $this->fecha_creacion=$row['fecha_creacion'];
            return $stmt;
        }

        public function createCategoria(){
            //Creamos el query
            $query = 'INSERT INTO '.$this->table.' (nombre) VALUES (:nombre)';
            
            //Preparamos el query
            $stmt = $this->db->prepare($query);
            $this->nombre = htmlspecialchars(strip_tags($this->nombre));
            $stmt->bindParam(":nombre",$this->nombre);

            //Ejecutamos el query
            if($stmt->execute())
            {
                return true;
            }else{
                printf("Error: \n". $stmt->error);

            }
           
            return $stmt;
        }

        public function updateCategoria(){
            //Creamos el query
            $query = 'UPDATE '.$this->table.' SET nombre = :nombre WHERE id= :id';
            
            //Limpiamos el query
            $stmt = $this->db->prepare($query);
            $this->nombre = htmlspecialchars(strip_tags($this->nombre));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Preparamos el query
            $stmt->bindParam(":nombre",$this->nombre);
            $stmt->bindParam(":id",$this->id);

            //Ejecutamos el query
            if($stmt->execute())
            {
                return true;
            }else{
                printf("Error: \n". $stmt->error);

            }
           
            return $stmt;
        }

        public function deleteCategoria(){
            //Creamos el query
            $query = 'DELETE FROM '.$this->table.' WHERE id= :id';
            
            //Limpiamos el query
            $stmt = $this->db->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Preparamos el query
            $stmt->bindParam(":id",$this->id);

            //Ejecutamos el query
            if($stmt->execute())
            {
                return true;
            }else{
                printf("Error: \n". $stmt->error);

            }
           
            return $stmt;
        }

    }
?>