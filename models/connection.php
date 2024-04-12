<?php

class Connection{
    
    static public function infoDatabase(){
        $infoDB = array(
            'database' =>'bts_weather',
            'user' => 'root',
            'pass' => '',

        );
        return $infoDB;
    }

    static public function connect(){
        try {
            $link = new PDO(
                'mysql:host=localhost;dbname=' . Connection::infoDatabase()['database'],
                Connection::infoDatabase()['user'],
                Connection::infoDatabase()['pass'],
            );

            $link->exec('set names utf8');
        } catch (PDOException $e) {
            die('Error:'. $e->getMessage());
        }
        return $link;
    }

    ///validate if table exist
    static public function getColumnsData($_table, $_columns){
        $database = Connection::infoDatabase()['database'];
        $validate = Connection::connect() -> query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$_table'")
        ->fetchAll(PDO::FETCH_OBJ);

        ///if a table exist
        if(empty($validate) ){
            return null;
        }else{
            ///allow global selection
            if($_columns[0] == "*"){
                array_shift($_columns);
            }
            ///if the columns exist
            $sum = 0;
            foreach ($validate as $key => $value) {
                $sum += in_array($value->item, $_columns);
            }
            return $sum == count($_columns) ? $validate : null;
        }

    }
}