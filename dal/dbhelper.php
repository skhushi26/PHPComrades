<?php
    # $myVar = "123";
    
    class DBHelper {
        const DB_USER = 'root';
        const DB_PASSWORD =  '123456';
        const DB_HOST =  'localhost:3307';
        const DB_NAME = 'homedecor';
        const CHARSET = 'utf8mb4';
        
        protected $sqlStatement = "";
        protected $params=null;
        protected $stmt=null;
        
        static protected $connection=null;
        
        static function initializeDatabase()
        {
            try
            {
                $data_source_name = "mysql:host=".self::DB_HOST.";charset=".self::CHARSET;
                $pdo = new PDO($data_source_name, self::DB_USER, self::DB_PASSWORD);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                
                $pdo->query("drop database if exists homedecor");
                $pdo->query("create database homedecor");
                $pdo->query("use homedecor");
                
                $pdo->query("CREATE TABLE `users` (
                                  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
                                  `email` varchar(255) NOT NULL,
                                  `password` varchar(50) NOT NULL,
                                  `name` varchar(100) NOT NULL,
                                  `phone` varchar(20) NOT NULL,
                                  `province` varchar(2) NOT NULL,
                                  PRIMARY KEY (`user_id`)
                                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;");
                
            }
            catch(PDOException $e)
            {
                echo $e ->getMessage();
            }
        }
     
     function __construct()
     {
         # global $myVar;
         if(self::$connection==null)
         {
            try
            {
                $data_source_name = "mysql:host=".self::DB_HOST.";dbname=".self::DB_NAME.";charset=".self::CHARSET;
                self::$connection = new PDO($data_source_name, self::DB_USER, self::DB_PASSWORD);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
                echo $e ->getMessage();
            }
         }
       }
       
       function getConnection(){ return self::$connection; }
       function getRowCount(){ return $this->stmt-> rowCount(); }
       
       function reset()
       {
           $sqlStatement="";
           $params=null;
           $stmt=null;
       }
        
       function statement($sqlStatement)
       {
           $this->reset();
           $this->sqlStatement=$sqlStatement;
           return $this;
       }
       
       function params($params)
       {
           $this->params=$params;
           return $this;
       }
       
       function execute($sqlStatement = "")
       {
        if(!empty($sqlStatement))   
            $this->statement($sqlStatement);
        if(is_array($this->params))
        {
             $this->stmt=self::$connection->prepare($this->sqlStatement);
             $this->stmt->execute($this->params);
        }
        else
            $this->stmt=self::$connection->query($this->sqlStatement);
        
        return $this;
       }
       
       function forEach(callable $callback, $userDefinedData=null)
       {
            $index = 0;
            while($row=$this->stmt-> fetch())
            {
                   $callback($index, $row, $userDefinedData);
                   $index++;
            }
       }
       
        function forOne(callable $callback, $userDefinedData=null)
       {
            if($row=$this->stmt-> fetch())
            {
               $callback($row, $userDefinedData);
            }
       }
    }
?>















