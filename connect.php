<?php
class dataConnection{

    public function __construct()
    {
        $dsn="mysql:host=localhost;dbname=center";
        $user="root";
        $pass="";
        $option=[PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'];

        try{
            $this->con=new PDO($dsn,$user,$pass,$option);
            $this->con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo "error" . $e->getMessage();
        }
    }

    public function select($All,$table,$where = NULL,$and = NULL,$order = NULL)
    {
        $getAll=$this->con->prepare("SELECT $All FROM $table $where $and $order");
        $getAll->execute();
        $all=$getAll->fetch();
        return $all;
    }

    public function select2($All,$table,$where = NULL,$and = NULL,$order)
    {
        $getAll=$this->con->prepare("SELECT $All FROM $table $where $and $order");
        $getAll->execute();
        $all=$getAll->fetchAll();
        return $all;
    }

    public function oneJoin($join,$table,$tableOne,$cond,$where = NULL,$and = NULL,$order)
    {
        $onejoin=$this->con->prepare("SELECT $join FROM $table INNER JOIN $tableOne ON $cond $where $and $order");
        $onejoin->execute();
        $oneAll=$onejoin->fetchAll();
        return $oneAll;
    }

    public function twoJoin($join,$table,$tableOne,$cond,$tabletwo,$condt,$where = NULL,$and = NULL,$order)
    {  
        $twojoin=$this->con->prepare("SELECT $join FROM $table INNER JOIN $tableOne ON $cond INNER JOIN $tabletwo ON $condt $where $and $order");
        $twojoin->execute();
        $twoAll=$twojoin->fetchAll();
        return $twoAll;
    }

    public function threeJoin($join,$table,$tableOne,$cond,$tabletwo,$condt,$tablethree,$condtt,$where = NULL,$and = NULL,$order)
    {  
        $threejoin=$this->con->prepare("SELECT $join FROM $table INNER JOIN $tableOne ON $cond INNER JOIN $tabletwo ON $condt INNER JOIN $tablethree ON $condtt $where $and $order");
        $threejoin->execute();
        $threeAll=$threejoin->fetchAll();
        return $threeAll;
    }


    public function insert($table,$columns,$values)
    {
        $stmt=$this->con->prepare("INSERT INTO $table($columns)VALUES($values)");
        $stmt->execute();
    }

    public function update($table,$fileds,$Oid,$Sid)
    {
        $stmt=$this->con->prepare("UPDATE $table SET $fileds WHERE $Oid = $Sid");
        $stmt->execute();
    }

    public function delete($table,$Oid,$Sid)
    {
        $stmt=$this->con->prepare("DELETE FROM $table WHERE $Oid = $Sid");
        $stmt->execute();
    }

    public function checkItem($select,$from,$value)
    {
        $stmtTwo=$this->con->prepare("SELECT $select FROM $from WHERE $value");
        $stmtTwo->execute();
        $count=$stmtTwo->rowCount();
        return $count;
    }

    public function countItems($item,$table,$where)
    {
        $stmt=$this->con->prepare("SELECT COUNT($item) FROM $table $where");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}


?>