<?php
  include("sql_queries.php");
  /**
   * This represents a product that will be inserted into the database
   * or updated in the database
   *
   *  Product operations can be chained together :
   *
   *  //Insert:
   *
      $p = new Product(); 
      $p->setVendorID('1')
              ->setSerialNum('223311')
              ->setCategory('Dogs')
              ->setName('Golden Dog')
              ->setDescription('A golden dog')
              ->setImages(20)
              ->setFeatures(1)
              ->setConstraints(5)
              ->setPrice(1000)
              ->insert("dbc");
   *
   *
   * //Update:
     $p = new Product(); 
     $p->setProductID(3)->setVendorID('1')
              ->setSerialNum('223311')
              ->setCategory('Dogs')
              ->setName('Golden RRR Dog')
              ->setDescription('A golden dog')
              ->setImages(20222)
              ->setFeatures(133)
              ->setConstraints(5)
              ->setPrice(1)
              ->update("dbc");
   */
  class Product {
    private $productID;
    private $vendorID;
    private $serialNum;
    private $category;
    private $name;
    private $description;
    private $images;
    private $features;
    private $constraints;
    private $price;
    
    public function Product() {
      $this->productID = NULL;
      $this->vendorID = NULL;
      $this->serialNum = NULL;
      $this->category = NULL;
      $this->name = NULL;
      $this->description = NULL;
      $this->images = NULL;
      $this->features = NULL;
      $this->constraints = NULL;
      $this->price = NULL;
    }
    
    /**
     *Set the product id for this product
     *returns this product for method chaining.
     */
    public function setProductID($id) {
      $this->productID = $id;
      return $this;
    }
    
    /**
     *Set the vendor id for this product
     *returns this product for method chaining.
     */
    public function setVendorID($id) {
      $this->vendorID = $id;
      return $this;
    }
    
    /**
     *Set the serial number for this product
     *returns this product for method chaining.
     */
    public function setSerialNum($serial) {
      $this->serialNum = $serial;
      return $this;
    }
    
    /**
     *Set the category for this product
     *returns this product for method chaining.
     */
    public function setCategory($category) {
      $this->category =$category;
      return $this;
    }
    
    /**
     *Set the name for this product
     *returns this product for method chaining.
     */
    public function setName($name) {
      $this->name = $name;
      return $this;
    }
    
    /**
     *Set the description for this product
     *returns this product for method chaining.
     */
    public function setDescription($description) {
      $this->description = $description;
      return $this;
    }
    
    /**
     *Set the images string for this product
     *returns this product for method chaining.
     */
    public function setImages($images) {
      $this->images = $images;
      return $this;
    }
    
    /**
     *Set the features for this product
     *returns this product for method chaining.
     */
    public function setFeatures($features) {
      $this->features = $features;
      return $this;
    }
    
    /**
     *Set the constraints for this product
     *returns this product for method chaining.
     */
    public function setConstraints($constraints) {
      $this->constraints = $constraints;
      return $this;
    }
    
    /**
     *Set the price for this product
     *returns this product for method chaining.
     */
    public function setPrice($price) {
      $this->price = $price;
      return $this;
    }
    
    /**
     * Insert this product into the product database.
     * returns true if this was successful false otherwise.
     */
    public function insert($dbc) {
      $q = 'INSERT INTO `'.PRODUCT_TABLE::$NAME.'`(`'
                          .PRODUCT_TABLE::$VEND_ID.'`, `'
                          .PRODUCT_TABLE::$SERIAL.'`, `'
                          .PRODUCT_TABLE::$CATEGORY.'`, `'
                          .PRODUCT_TABLE::$PROD_NAME.'`, `'
                          .PRODUCT_TABLE::$DESCRIPTION.'`, `'
                          .PRODUCT_TABLE::$IMAGES.'`, `'
                          .PRODUCT_TABLE::$FEATURES.'`, `'
                          .PRODUCT_TABLE::$CONSTRAINTS.'`, `'
                          .PRODUCT_TABLE::$PRICE.'`) VALUES (\''
                          .$this->vendorID.'\',\''
                          .$this->serialNum.'\',\''
                          .$this->category.'\',\''
                          .$this->name.'\',\''
                          .$this->description.'\',\''
                          .$this->images.'\',\''
                          .$this->features.'\',\''
                          .$this->constraints.'\',\''
                          .$this->price.'\')';
      $r = mysqli_query($dbc, $q);
      if($r) {
        return true;
      }
      return false;
    }
    
    /**
     * Updates all the database for this product with all the set fields.
     *
     * Note: this product's product ID must be set.
     */
    public function update($dbc) {
      $array = array();
      if($this->productID === NULL) {
        return false;
      }
      
      if($this->vendorID !== NULL) {
        $array[] = PRODUCT_TABLE::$VEND_ID . "='{$this->vendorID}'";
      }
      
      if($this->serialNum !== NULL) {
        $array[] = PRODUCT_TABLE::$SERIAL . "='{$this->serialNum}'";
      }
      
      if($this->category !== NULL) {
        $array[] = PRODUCT_TABLE::$CATEGORY . "='{$this->category}'";
      }
      
      if($this->category !== NULL) {
        $array[] = PRODUCT_TABLE::$CATEGORY . "='{$this->category}'";
      }
      
      if($this->name !== NULL) {
        $array[] = PRODUCT_TABLE::$PROD_NAME . "='{$this->name}'";
      }
      
      if($this->description !== NULL) {
        $array[] = PRODUCT_TABLE::$DESCRIPTION . "='{$this->description}'";
      }
      
      if($this->images !== NULL) {
        $array[] = PRODUCT_TABLE::$IMAGES . "='{$this->images}'";
      }
      
      if($this->features !== NULL) {
        $array[] = PRODUCT_TABLE::$FEATURES . "='{$this->features}'";
      }
      
      if($this->constraints !== NULL) {
        $array[] = PRODUCT_TABLE::$CONSTRAINTS . "='{$this->constraints}'";
      }
      
      if($this->price !== NULL) {
        $array[] = PRODUCT_TABLE::$PRICE . "='{$this->price}'";
      }
      
      if(empty($array)) {
        return false;
      }
      
      
      $q = "Update " . PRODUCT_TABLE::$NAME . " SET ";
      
      $first = true;
      foreach($array as $update) {
        if($first) {
          $first = false;
        } else {
          $q = $q . ",";
        }
        $q = $q . $update;
        
      }
      $q = $q . " WHERE " . PRODUCT_TABLE::$PROD_ID . " = '" . $this->productID . "'";
      $r = mysqli_query($dbc, $q);
      if($r) {
        return true;
      }
      return false;
    }
  }
?>