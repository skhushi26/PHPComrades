<?php
require_once "dbhelper.php";

class Product {
    protected $productId;
    protected $ProductName;
    protected $ProductImage;
    protected $ProductDescription;
    protected $QuantityAvailable;
    protected $Price;
    protected $BrandName;
    protected $CategoryName;


    function getProductId()
    {
      return $this->productId;
    }
    function setProductId($productId)
    {
      $this->productId = trim(htmlSpecialChars($productId));
      $this->productId = (int) $this->productId;
    }

    function getProductName()
    {
      return $this->ProductName;
    }
    function setProductName($ProductName)
    {
      $this->ProductName = trim(htmlSpecialChars($ProductName));
    }

    function getProductImage()
    {
      return $this->ProductImage;
    }
    function setProductImage($ProductImage)
    {
      $this->ProductImage = trim(htmlSpecialChars($ProductImage));
    }

    function getProductDescription()
    {
      return $this->ProductDescription;
    }
    function setProductDescription($ProductDescription)
    {
      $this->ProductDescription = trim(htmlSpecialChars($ProductDescription));
    }

    function getQuantityAvailable()
    {
      return $this->QuantityAvailable;
    }
    function setQuantityAvailable($QuantityAvailable)
    {
      $this->QuantityAvailable = trim(htmlSpecialChars($QuantityAvailable));
      $this->QuantityAvailable = (int) $this->QuantityAvailable;
    }

    function getPrice()
    {
      return $this->Price;
    }
    function setPrice($Price)
    {
      $this->Price = trim(htmlSpecialChars($Price));
      $this->Price = (double) $this->Price;
    }

    function getBrandName()
    {
      return $this->BrandName;
    }
    function setBrandName($BrandName)
    {
      $this->BrandName = trim(htmlSpecialChars($BrandName));
    }

    function getCategoryName()
    {
      return $this->CategoryName;
    }
    function setCategoryName($CategoryName)
    {
      $this->CategoryName = trim(htmlSpecialChars($CategoryName));
    }

    function fetchProducts()
    {
        $sql = new DBHelper();
        $sql
            ->statement("SELECT p.ProductName, p.ProductImage, p.ProductDescription, p.QuantityAvailable, p.Price,  c.CategoryName
                         FROM products p
                         JOIN category c ON p.FK_CategoryId = c.CategoryId")
            ->execute()
            ->forAll(function ($row, &$products) {
                $product = new Product();
                $product->setProductName($row["ProductName"]);
                $product->setProductImage($row["ProductImage"]);
                $product->setProductDescription($row["ProductDescription"]);
                $product->setQuantityAvailable($row["QuantityAvailable"]);
                $product->setPrice($row["Price"]);
                // $product->setBrandName($row["BrandName"]);
                $product->setCategoryName($row["CategoryName"]);
                $products[] = $product;
            }, $products);
    
        return $products; 
    }
    
    

}