<?php

require_once "connection.php";

class GetModel{

    ///normal request
    static public function getData($_table, $_select, $_orderBy, $_orderMode, $_startAt, $_endAt){
        ///validate if table and columns exist
        $selectArray = explode(",", $_select);
        if(empty(Connection::getColumnsData($_table, $selectArray))){
            return null;
        }
        ///Not ordered and not limited
        $sql = "SELECT $_select FROM $_table";

        ///ordered and not limited
        if ($_orderBy != null && $_orderMode != null && $_startAt == null && $_endAt == null) 
            $sql = "SELECT $_select FROM $_table ORDER BY $_orderBy $_orderMode";
        
        ///ordered and limited
        if ($_orderBy != null && $_orderMode != null && $_startAt != null && $_endAt != null) 
            $sql = "SELECT $_select FROM $_table ORDER BY $_orderBy $_orderMode LIMIT $_startAt, $_endAt";
        
        ///not ordered and limited
        if ($_orderBy == null && $_orderMode == null && $_startAt != null && $_endAt != null) 
            $sql = "SELECT $_select FROM $_table LIMIT $_startAt, $_endAt";
        
        $stmt = Connection::connect()->prepare($sql);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
 
    ///filtered request
    static public function getDataFiltered($_table, $_select,$_linkTo, $_equalTo, $_orderBy, $_orderMode, $_startAt, $_endAt){

        ///validate if table and columns exist
        $linkToArray = explode(",", $_linkTo);
        $selectArray = explode(",", $_select);

        foreach ($linkToArray as $key => $value) {
            array_push($selectArray, $value);
        }
        $selectArray = array_unique($selectArray);
        
        if(empty(Connection::getColumnsData($_table,$selectArray))){
            return null;
        }
        

        $equalToArray = explode("_", $_equalTo);
        $linkToText = "";
        if (count($linkToArray) > 1) {
            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $linkToText .= "AND ". $value . " = :" . $value . " ";
                }
            }
        }
        ///Not ordered and not limited
        $sql = "SELECT $_select FROM $_table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";
        
        ///ordered and not limited
        if ($_orderBy != null && $_orderMode != null && $_startAt == null && $_endAt == null)
            $sql = "SELECT $_select FROM $_table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $_orderBy $_orderMode";

        ///ordered and limited
        if ($_orderBy != null && $_orderMode != null && $_startAt != null && $_endAt != null) 
            $sql = "SELECT $_select FROM $_table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $_orderBy $_orderMode LIMIT $_startAt, $_endAt";
        
        ///not ordered and limited
        if ($_orderBy == null && $_orderMode == null && $_startAt != null && $_endAt != null) 
            $sql = "SELECT $_select FROM $_table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $_startAt, $_endAt";

        $stmt = Connection::connect()->prepare($sql);
        foreach ($linkToArray as $key => $value) {
            $stmt->bindParam(":" . $value, $equalToArray[$key], PDO::PARAM_STR);
        }
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    ///relations without filters
    static public function getRelData($_rel,$_type, $_select, $_orderBy, $_orderMode, $_startAt, $_endAt){
        $relArray = explode("," , $_rel);
        $typeArray = explode("," , $_type);

        $innerJoinToText = "";
        if(count($relArray)>1){

            foreach ($relArray as $key => $value) {
                ///validate if table and columns exist
                if(empty(Connection::getColumnsData($value, ["*"]))){
                    return null;
                }
                if ($key > 0) {
                    $innerJoinToText .= "INNER JOIN " . $value . " ON " . $relArray[0] . ".id_" . $typeArray[$key] ."_" . $typeArray[0] . " = " . $value . ".id_" . $typeArray[$key] ." ";
                }
            }
        
            ///Not ordered and not limited
            $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText";

            ///ordered and not limited
            if ($_orderBy != null && $_orderMode != null && $_startAt == null && $_endAt == null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText ORDER BY $_orderBy $_orderMode";
            
            ///ordered and limited
            if ($_orderBy != null && $_orderMode != null && $_startAt != null && $_endAt != null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText ORDER BY $_orderBy $_orderMode LIMIT $_startAt, $_endAt";
            
            ///not ordered and limited
            if ($_orderBy == null && $_orderMode == null && $_startAt != null && $_endAt != null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText LIMIT $_startAt, $_endAt";

            
            $stmt = Connection::connect()->prepare($sql);
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                return null;
            }
            
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }
        else{
            return null;
        }

        
    }

    ///relations filtered
    static public function getRelDataFiltered($_rel,$_type, $_select, $_linkTo, $_equalTo, $_orderBy, $_orderMode, $_startAt, $_endAt){
        $relArray = explode("," , $_rel);
        $typeArray = explode("," , $_type);

        $innerJoinToText = "";
        if(count($relArray)>1){
            $linkToArray = explode(",", $_linkTo);
            foreach ($relArray as $key => $value) {
                ///validate if table and columns exist
                if(empty(Connection::getColumnsData($value, ["*"]))){
                    return null;
                }
                if ($key > 0) {
                    $innerJoinToText .= "INNER JOIN " . $value . " ON " . $relArray[0] . ".id_" . $typeArray[$key] ."_" . $typeArray[0] . " = " . $value . ".id_" . $typeArray[$key] ." ";
                }
            }

            
            $equalToArray = explode("_", $_equalTo);
            $linkToText = "";
            if (count($linkToArray) > 1) {
                foreach ($linkToArray as $key => $value) {
                    if ($key > 0) {
                        $linkToText .= "AND ". $value . " = :" . $value . " ";
                    }
                }
            }

            ///Not ordered and not limited
            $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";


            ///ordered and not limited
            if ($_orderBy != null && $_orderMode != null && $_startAt == null && $_endAt == null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $_orderBy $_orderMode";
            
            ///ordered and limited
            if ($_orderBy != null && $_orderMode != null && $_startAt != null && $_endAt != null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $_orderBy $_orderMode LIMIT $_startAt, $_endAt";
            
            ///not ordered and limited
            if ($_orderBy == null && $_orderMode == null && $_startAt != null && $_endAt != null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $_startAt, $_endAt";

            
            $stmt = Connection::connect()->prepare($sql);
            foreach ($linkToArray as $key => $value) {
                $stmt->bindParam(":" . $value, $equalToArray[$key], PDO::PARAM_STR);
    
            }
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                return null;
            }
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }
        else{
            return null;
        }

        
    }

    ///search request wihtout rekations
    static public function getDataSearch($_table, $_select,$_linkTo, $_search, $_orderBy, $_orderMode, $_startAt, $_endAt){
        ///validate if table and columns exist
        $linkToArray = explode(",", $_linkTo);
        $selectArray = explode(",", $_select);

        foreach ($linkToArray as $key => $value) {
            array_push($selectArray, $value);
        }
        $selectArray = array_unique($selectArray);
        
        if(empty(Connection::getColumnsData($_table,$selectArray))){
            return null;
        }
        $searchToArray = explode("_", $_search);
        $linkToText = "";
        if (count($linkToArray) > 1) {
            foreach ($linkToArray as $key => $value) {
                if ($key > 0) {
                    $linkToText .= "AND ". $value . " = :" . $value . " ";
                }
            }
        }
        ///Not ordered and not limited
        $sql = "SELECT $_select FROM $_table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText ";

        ///ordered and not limited
        if ($_orderBy != null && $_orderMode != null && $_startAt == null && $_endAt == null) 
            $sql = "SELECT $_select FROM $_table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText  ORDER BY $_orderBy $_orderMode";
        
        ///ordered and limited
        if ($_orderBy != null && $_orderMode != null && $_startAt != null && $_endAt != null) 
            $sql = "SELECT $_select FROM $_table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText  ORDER BY $_orderBy $_orderMode LIMIT $_startAt, $_endAt";
        
        ///not ordered and limited
        if ($_orderBy == null && $_orderMode == null && $_startAt != null && $_endAt != null) 
            $sql = "SELECT $_select FROM $_table WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText  LIMIT $_startAt, $_endAt";
        
        $stmt = Connection::connect()->prepare($sql);
        foreach ($linkToArray as $key => $value) {
            if($key>0){
                $stmt->bindParam(":" . $value, $searchToArray[$key], PDO::PARAM_STR);
            } 
        }
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    ///relations search filtered
    static public function getRelDataSearch($_rel,$_type, $_select, $_linkTo, $_search, $_orderBy, $_orderMode, $_startAt, $_endAt){
        $relArray = explode("," , $_rel);
        $typeArray = explode("," , $_type);

        $innerJoinToText = "";
        if(count($relArray)>1){
            $linkToArray = explode(",", $_linkTo);
            foreach ($relArray as $key => $value) {
                ///validate if table and columns exist
                if(empty(Connection::getColumnsData($value, ["*"]))){
                    return null;
                }
                if ($key > 0) {
                    $innerJoinToText .= "INNER JOIN " . $value . " ON " . $relArray[0] . ".id_" . $typeArray[$key] ."_" . $typeArray[0] . " = " . $value . ".id_" . $typeArray[$key] ." ";
                }
            }

            
            $searchToArray = explode("_", $_search);
            $linkToText = "";
            if (count($linkToArray) > 1) {
                foreach ($linkToArray as $key => $value) {
                    if ($key > 0) {
                        $linkToText .= "AND ". $value . " = :" . $value . " ";
                    }
                }
            }
        
            ///Not ordered and not limited
            $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText";


            ///ordered and not limited
            if ($_orderBy != null && $_orderMode != null && $_startAt == null && $_endAt == null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText ORDER BY $_orderBy $_orderMode";
            
            ///ordered and limited
            if ($_orderBy != null && $_orderMode != null && $_startAt != null && $_endAt != null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText ORDER BY $_orderBy $_orderMode LIMIT $_startAt, $_endAt";
            
            ///not ordered and limited
            if ($_orderBy == null && $_orderMode == null && $_startAt != null && $_endAt != null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $linkToArray[0] LIKE '%$searchToArray[0]%' $linkToText LIMIT $_startAt, $_endAt";

            $stmt = Connection::connect()->prepare($sql);
            foreach ($linkToArray as $key => $value) {
                if($key>0){
                    $stmt->bindParam(":" . $value, $searchToArray[$key], PDO::PARAM_STR);
                } 
            }
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                return null;
            }
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }
        else{
            return null;
        }

        
    }
    ///range
    static public function getDataRange($_table, $_select, $_linkTo, $_between1, $_between2, $_orderBy, $_orderMode, $_startAt, $_endAt, $_filterTo, $_inTo){
        ///validate if table and columns exist
        $linkToArray = explode(",", $_linkTo);
        $selectArray = explode(",", $_select);
        if ($_filterTo != null) {
            $filterToArray = explode(",", $_filterTo);
        }else{
            $filterToArray = array();
        }

        foreach ($filterToArray as $key => $value) {
            array_push($selectArray, $value);
        }
        foreach ($linkToArray as $key => $value) {
            array_push($selectArray, $value);
        }
        $selectArray = array_unique($selectArray);
        
        if(empty(Connection::getColumnsData($_table,$selectArray))){
            return null;
        }
        $filterText = "";


        if ($_filterTo != null && $_inTo != null){
            $filterText = 'AND '.$_filterTo.' IN ('.$_inTo.') ';
        }
      

        ///Not ordered and not limited
        $sql = "SELECT $_select FROM $_table WHERE $_linkTo BETWEEN $_between1 AND $_between2 $filterText";

        ///ordered and not limited
        if ($_orderBy != null && $_orderMode != null && $_startAt == null && $_endAt == null) 
            $sql = "SELECT $_select FROM $_table WHERE $_linkTo BETWEEN $_between1 AND $_between2 $filterText ORDER BY $_orderBy $_orderMode";
        
        ///ordered and limited
        if ($_orderBy != null && $_orderMode != null && $_startAt != null && $_endAt != null) 
            $sql = "SELECT $_select FROM $_table WHERE $_linkTo BETWEEN $_between1 AND $_between2 $filterText ORDER BY $_orderBy $_orderMode LIMIT $_startAt, $_endAt";
        
        ///not ordered and limited
        if ($_orderBy == null && $_orderMode == null && $_startAt != null && $_endAt != null) 
            $sql = "SELECT $_select FROM $_table WHERE $_linkTo BETWEEN $_between1 AND $_between2 $filterText LIMIT $_startAt, $_endAt";
        
        #return $sql;
        $stmt = Connection::connect()->prepare($sql);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    ///range relations
    static public function getRelDataRange($_rel,$_type, $_select, $_linkTo, $_between1, $_between2, $_orderBy, $_orderMode, $_startAt, $_endAt, $_filterTo, $_inTo){
        $filterText = "";


        if ($_filterTo != null && $_inTo != null){
            $filterText = 'AND '.$_filterTo.' IN ('.$_inTo.') ';
        }

        $relArray = explode("," , $_rel);
        $typeArray = explode("," , $_type);

        $innerJoinToText = "";
        if(count($relArray)>1){
            foreach ($relArray as $key => $value) {
                ///validate if table and columns exist
                if(empty(Connection::getColumnsData($value, ["*"]))){
                    return null;
                }
                if ($key > 0) {
                    $innerJoinToText .= "INNER JOIN " . $value . " ON " . $relArray[0] . ".id_" . $typeArray[$key] ."_" . $typeArray[0] . " = " . $value . ".id_" . $typeArray[$key] ." ";
                }
            }
      

            ///Not ordered and not limited
            $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $_linkTo BETWEEN $_between1 AND $_between2 $filterText";

            ///ordered and not limited
            if ($_orderBy != null && $_orderMode != null && $_startAt == null && $_endAt == null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $_linkTo BETWEEN $_between1 AND $_between2 $filterText ORDER BY $_orderBy $_orderMode";
            
            ///ordered and limited
            if ($_orderBy != null && $_orderMode != null && $_startAt != null && $_endAt != null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $_linkTo BETWEEN $_between1 AND $_between2 $filterText ORDER BY $_orderBy $_orderMode LIMIT $_startAt, $_endAt";
            
            ///not ordered and limited
            if ($_orderBy == null && $_orderMode == null && $_startAt != null && $_endAt != null) 
                $sql = "SELECT $_select FROM $relArray[0] $innerJoinToText WHERE $_linkTo BETWEEN $_between1 AND $_between2 $filterText LIMIT $_startAt, $_endAt";
            
            #return $sql;
            $stmt = Connection::connect()->prepare($sql);
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                return null;
            }
            return $stmt->fetchAll(PDO::FETCH_CLASS);
        }
        else{
            return null;
        }
    }
}