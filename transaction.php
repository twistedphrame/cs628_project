<?php
  require_once("includes/sql_queries.php");
  
  /**
   *This represents a Transaction that will be inserted or updated
   *in the data base
   */
  class Transaction {
    private $transactionID;
    private $username;
    private $vendorid;
    private $productid;
    private $quantity;
    private $pricePerUnit;
    private $status;
    private $firstName;
    private $lastName;
    private $address;
    private $city;
    private $state;
    private $zipCode;
  
    public function Transaction() {
      $this->transactionID = NULL;
      $this->username = NULL;
      $this->vendorid = NULL;
      $this->productid = NULL;
      $this->quantity = NULL;
      $this->pricePerUnit = NULL;
      $this->status = NULL;
      $this->firstName = NULL;
      $this->lastName = NULL;
      $this->address = NULL;
      $this->city = NULL;
      $this->state = NULL;
      $this->zipCode = NULL;
    }
  
    /**
     * Set the transaction id for this Transaction
     * returns this Transaction for method chaining
     */
    public function setTransactionID($id) {
      $this->transactionID = $id;
      return $this;
    }
    
    /**
     * Set the user name for this Transaction
     * returns this Transaction for method chaining
     */
    public function setUserName($userName) {
      $this->username = $userName;
      return $this;
    }

    /**
     * Set the vendor id for this Transaction
     * returns this Transaction for method chaining
     */
    public function setVendorID($vendorid) {
      $this->vendorid = $vendorid;
      return $this;
    }

    /**
     * Set the product id for this Transaction
     * returns this Transaction for method chaining
     */
    public function setProductID($productid) {
      $this->productid = $productid;
      return $this;
    }

    /**
     * Set the quantity for this Transaction
     * returns this Transaction for method chaining
     */
    public function setQuantity($quantity) {
      $this->quantity = $quantity;
      return $this;
    }

    /**
     * Set the price per unit for this Transaction
     * returns this Transaction for method chaining
     */
    public function setPricePerUnit($pricePerUnit) {
      $this->pricePerUnit = $pricePerUnit;
      return $this;
    }

    /**
     * Set the status to pending for this Transaction
     * returns this Transaction for method chaining
     */
    public function pending() {
      $this->status = TRANSACTION_TABLE::$ORDER_PENDING;
      return $this;
    }

    /**
     * Set the status to shipped for this Transaction
     * returns this Transaction for method chaining
     */
    public function shipped() {
      $this->status = TRANSACTION_TABLE::$ORDER_SHIPPED;
      return $this;
    }

    /**
     * Set the status to cancelled for this Transaction
     * returns this Transaction for method chaining
     */
    public function cancelled() {
      $this->status = TRANSACTION_TABLE::$ORDER_CANCELLED;
      return $this;
    }

    /**
     * Set the First Name for this Transaction
     * returns this Transaction for method chaining
     */
    public function setFirstName($fname) {
      $this->firstName = $fname;
      return $this;
    }

    /**
     * Set the LastName for this Transaction
     * returns this Transaction for method chaining
     */
    public function setLastName($lname) {
      $this->lastName = $lname;
      return $this;
    }

    /**
     * Set the Address for this Transaction
     * returns this Transaction for method chaining
     */
    public function setAddress($address) {
      $this->address = $address;
      return $this;
    }

    /**
     * Set the City for this Transaction
     * returns this Transaction for method chaining
     */
    public function setCity($city) {
      $this->city = $city;
      return $this;
    }

    /**
     * Set the State for this Transaction
     * returns this Transaction for method chaining
     */
    public function setState($state) {
      $this->state = $state;
      return $this;
    }

    /**
     * Set the zipcode for this Transaction
     * returns this Transaction for method chaining
     */
    public function setZipCode($zipCode) {
      $this->zipCode = $zipCode;
      return $this;
    } 
  
  
      /**
     * Insert this tranaction into the tranasction database.
     * returns true if this was successful false otherwise.
     */
    public function insert($dbc) {
      $q = 'INSERT INTO `'.TRANSACTION_TABLE::$NAME.'`(`'
                          .TRANSACTION_TABLE::$TRANS_ID.'`, `'
                          .TRANSACTION_TABLE::$USER_NAME.'`, `'
                          .TRANSACTION_TABLE::$VENDOR_ID.'`, `'
                          .TRANSACTION_TABLE::$PROD_ID.'`, `'
                          .TRANSACTION_TABLE::$QUANTITY.'`, `'
                          .TRANSACTION_TABLE::$PRICE.'`, `'
                          .TRANSACTION_TABLE::$STATUS.'`, `'
                          .TRANSACTION_TABLE::$FIRST_NAME.'`, `'
                          .TRANSACTION_TABLE::$LAST_NAME.'`, `'
                          .TRANSACTION_TABLE::$ADDRESS.'`, `'
                          .TRANSACTION_TABLE::$CITY.'`, `'
                          .TRANSACTION_TABLE::$STATE.'`, `'
                          .TRANSACTION_TABLE::$ZIP_CODE.'`) VALUES (\''
                          .$this->transactionID.'\',\''
                          .$this->username.'\',\''
                          .$this->vendorid.'\',\''
                          .$this->productid.'\',\''
                          .$this->quantity.'\',\''
                          .$this->pricePerUnit.'\',\''
                          .$this->status.'\',\''
                          .$this->firstName.'\',\''
                          .$this->lastName.'\',\''
                          .$this->address.'\',\''
                          .$this->city.'\',\''
                          .$this->state.'\',\''
                          .$this->zipCode.'\')';
      $r = mysqli_query($dbc, $q);
      if($r) {
        return true;
      }
      return false;
    }
  
      /**
     * Updates the status of the product
     *
     * Note: the transaction ID, product ID, username, and status must be set 
     */
    public function updateStatus($dbc) {
      $array = array();
      if($this->transactionID === NULL) {
        return false;
      }
      if($this->username === NULL) {
        return false;
      }
      if($this->productid === NULL) {
        return false;
      }
      if($this->status === NULL) {
        return false;
      }
      
      $q = 'UPDATE ' . TRANSACTION_TABLE::$NAME . ' SET '
          . TRANSACTION_TABLE::$STATUS . '=\''.$this->status.'\''
          . ' WHERE ' . TRANSACTION_TABLE::$TRANS_ID . ' = \'' . $this->transactionID . '\''
          . ' AND ' . TRANSACTION_TABLE::$USER_NAME . ' = \'' . $this->username . '\''
          . ' AND ' . TRANSACTION_TABLE::$PROD_ID . ' = \'' . $this->productid . '\'';
      echo $q;
      $r = mysqli_query($dbc, $q);
      if($r) {
        echo "<BR>OK";
        return true;
      }
      echo "<BR>no";
      return false;
    }    
  }
  
?>