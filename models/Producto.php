<?php
    class Categoria{
        private $db = new Database;
        private $table = 'productos';

        //Propiedades
        public $id;
        public $categoria_id;
        public $categoria_nombre;
        public $titulo;
        public $texto;
        public $fecha_creacion;

        //Constructor con DB
        public function __construct($db){
            $this->db = $db;
        }

        public function getProductos(){
            //Creamos el query
            $query = 'SELECT c.nombre as nombre_categoria, p.id, p.categoria_id, p.titulo, 
                p.texto, p.fecha_creacion FROM '.$this->table.' LEFT JOIN categorias c ON p.categoria_id
                = c.id ORDER BY p.fecha_creacion DESC';
            //Preparamos el query
            $stmt = $this->db->prepare($query);
            //Ejecutamos el query
            $stmt->execute();
            return $stmt;
        }

        public function getProducto(){
            //Creamos el query
            $query = 'SELECT c.nombre as nombre_categoria, p.id, p.categoria_id, p.titulo, 
                p.texto, p.fecha_creacion FROM '.$this->table.' LEFT JOIN categorias c ON p.categoria_id
                = c.id WHERE p.id = ? LIMIT 0,1';
            
            //Preparamos el query
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1,$this->id);
            
            //Ejecutamos el query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->titulo = $row['titulo'];
            $this->texto = $row['texto'];
            $this->categoria_id = $row['categoria_id'];
            $this->categoria_nombre = $row['categoria_nombre'];
            $this->id=$row['id'];
            $this->nombre=$row['nombre'];
            $this->fecha_creacion=$row['fecha_creacion'];
            return $stmt;
        }

        public function createProducto(){
            //Creamos el query
            $query = 'INSERT INTO '.$this->table.' (titulo, texto, categoria_id) VALUES 
            (:titulo, :texto, :categoria_id)';
            
            //Preparamos el query
            $stmt = $this->db->prepare($query);
            $this->titulo = htmlspecialchars(strip_tags($this->titulo));
            $this->texto = htmlspecialchars(strip_tags($this->texto));
            $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
            $stmt->bindParam(":titulo",$this->titulo);
            $stmt->bindParam(":texto",$this->texto);
            $stmt->bindParam(":categoria_id",$this->categoria_id);

            //Ejecutamos el query
            if($stmt->execute())
            {
                return true;
            }else{
                printf("Error: \n". $stmt->error);

            }
           
            return $stmt;
        }

        public function updateProducto(){
            //Creamos el query
            $query = 'UPDATE '.$this->table.' SET titulo = :titulo, texto = :texto, 
            categoria_id = :categoria_id WHERE id = :id';
            
            //Preparamos el query
            $stmt = $this->db->prepare($query);

            $this->titulo = htmlspecialchars(strip_tags($this->titulo));
            $this->texto = htmlspecialchars(strip_tags($this->texto));
            $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":titulo",$this->titulo);
            $stmt->bindParam(":texto",$this->texto);
            $stmt->bindParam(":categoria_id",$this->categoria_id);
            $stmt->bindParam("id",$this->id);

            //Ejecutamos el query
            if($stmt->execute())
            {
                return true;
            }else{
                printf("Error: \n". $stmt->error);

            }
           
            return $stmt;
        }

        public function deleteProducto(){
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