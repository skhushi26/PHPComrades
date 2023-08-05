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
                                  `password` varchar(255) NOT NULL,
                                  `name` varchar(100) NOT NULL,
                                  `phone` varchar(20) NOT NULL,
                                  `province` varchar(2) NOT NULL,
                                  PRIMARY KEY (`user_id`)
                                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;");

                // $pdo-> query("CREATE TABLE brand (
                //     BrandId MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                //     BrandName VARCHAR(255) NOT NULL,
                //     PRIMARY KEY(BrandId)
                // ) Engine=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4"
                // );

                $pdo-> query("CREATE TABLE category (
                    CategoryId MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                    CategoryName VARCHAR(255) NOT NULL,
                    PRIMARY KEY(CategoryId)
                ) Engine=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4"
                );

                $pdo-> query("CREATE TABLE products (
                    ProductId MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                    ProductName VARCHAR(255) NOT NULL,
                    ProductImage VARCHAR(255) NOT NULL,
                    ProductDescription LONGTEXT NOT NULL,
                    QuantityAvailable MEDIUMINT(8) UNSIGNED NOT NULL,
                    Price DECIMAL(18,2) NOT NULL,
                    PRIMARY KEY(ProductId),
                    -- FK_BrandId MEDIUMINT(8) UNSIGNED NOT NULL,
                    -- FOREIGN KEY(FK_BrandId) REFERENCES brand(BrandId) ON UPDATE CASCADE ON DELETE RESTRICT,
                    FK_CategoryId MEDIUMINT(8) UNSIGNED NOT NULL,
                    FOREIGN KEY(FK_CategoryId) REFERENCES category(CategoryId) ON UPDATE CASCADE ON DELETE RESTRICT

                ) Engine=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4"
            );

            # Default value for brand
        //     $queryBrand = "INSERT INTO brand(BrandName)
        //                     VALUES('Uppland'),
        //                           ('Songesand');
        //  ";
        //  $resultBrand = $pdo-> query($queryBrand);

        //  if ($resultBrand === false) {
        //      die("Error inserting brand data: " . $pdo -> error);
        //  }

        # Default value for category
                         $queryCategory = "INSERT INTO category(CategoryName)
                         VALUES('Accessory'),
                               ('Decoration'),
                               ('Furniture');
      ";
      $resultCategory = $pdo-> query($queryCategory);

      $queryProduct = "INSERT INTO products (ProductName, ProductImage, ProductDescription, QuantityAvailable, Price,  FK_CategoryId)
      VALUES ('Art Deco Home', './images/product-2.jpg', 'An art deco home is a captivating architectural style from the early 20th century, known for its sleek and glamorous design elements. Characterized by bold geometric shapes, clean lines, and ornate details, art deco homes exude elegance and luxury. ', 7, 30,  1),
             ('Wood Eggs', './images/product-17.jpg','Handcrafted wood eggs, a rustic and charming decoration for any home.', 12, 19,  2),
             ('Helen Chair', './images/product-6.jpg','The Helen chair: a stylish blend of modern design and unparalleled comfort.', 5, 69.50,3),
             ('Art Deco Home', './images/product-2.jpg', 'An art deco home is a captivating architectural style from the early 20th century, known for its sleek and glamorous design elements. Characterized by bold geometric shapes, clean lines, and ornate details, art deco homes exude elegance and luxury. ', 7, 30,  1),
             ('Wood Eggs', './images/product-17.jpg','Handcrafted wood eggs, a rustic and charming decoration for any home.', 12, 19,  2),
             ('Helen Chair', './images/product-6.jpg','The Helen chair: a stylish blend of modern design and unparalleled comfort.', 5, 69.50,3)";

   $resultProduct = $pdo-> query($queryProduct);

   if ($resultCategory === false) {
       die("Error inserting category data: " . $pdo -> error);
   }
                
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
           if (!empty($sqlStatement)) {
               $this->statement($sqlStatement);
           }
           if (is_array($this->params)) {
               $this->stmt = self::$connection->prepare($this->sqlStatement);
               $this->stmt->execute($this->params);
           } else {
               $this->stmt = self::$connection->query($this->sqlStatement);
           }
       
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

       function forAll(callable $callback, &$userDefinedData = null)
       {
           $index = 0;
           while ($row = $this->stmt->fetch()) {
               $callback($row, $userDefinedData);
               $index++;
           }
       }
       
       

       function getResult() {
        // Retrieve and return the query result
        return $this->stmt->fetchAll();
      }
    }
?>















