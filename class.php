<?php

    class DB extends Mysqli{
        // conection DB data
        private $host = "localhost";
        private $db_user = "root";
        private $db_pass = "";
        private $db_name = "react_crud";

        //Overall data
        private $method;
        private $data;
        private $id;

        public function __construct($method, $data, $id = false){
            $this -> method = $method;
            $this -> data = $data;
            $this -> id = $id;
            parent:: __construct(
                $this -> host,
                $this -> db_user,
                $this -> db_pass,
                $this -> db_name
            );

            switch($this -> method){
                case 'POST':
                   echo( $this -> add());
                break;
                case 'GET':
                   echo $this -> get();
                break;
                case 'PUT':
                   echo $this -> update();
                break;
                case 'DELETE':
                    // $product_to_delete = $_GET['id'];
                   echo $this -> delete();
                break;
            } 

        }
        private function add(){
            $json_data = json_decode($this -> data);
            $resul['message'] = $this -> Query("INSERT INTO products 
            (name, 
            description, 
            quantity, 
            price) 
            VALUES(
            '$json_data->name', 
            '$json_data->description', 
            $json_data->quantity,
            $json_data->price)");

            return json_encode($resul);
        }
        private function get(){
            // $resul['message'] = "GET works!";
            $resul = $this -> Query("SELECT * FROM products");
            $products = [];
            while($row = mysqli_fetch_array($resul)){
                $newproduct["id"] = $row['id'];
                $newproduct["name"] = $row['name'];
                $newproduct["description"] = $row['description'];
                $newproduct["quantity"] = $row['quantity'];
                $newproduct["price"] = $row['price'];

                array_push($products, $newproduct);

            }
            return json_encode($products);
        }
        private function update(){
            $json_data = json_decode($this->data);
            $resul['message'] = $this -> Query("UPDATE products SET name='$json_data->name',description='$json_data->description',quantity='$json_data->quantity',price='$json_data->price' WHERE id = $this->id");
            return json_encode($resul);
        }
        private function delete(){
            $resul['message'] = $this -> Query("DELETE FROM products WHERE id = $this->id");
            return json_encode($resul);
        }


    }

?>