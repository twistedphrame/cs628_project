<?php
    class PRODUCT_TABLE {
      public static $NAME = 'product';
      public static $PROD_ID = 'productid';
      public static $PROD_NAME = 'productname';
      public static $CATEGORY = 'category';
      public static $VEND_ID = 'vendorid';
      public static $DESCRIPTION = 'description';
      public static $PRICE = 'price';
      public static $PROD_NUMBER = 'productnumber';
      public static $FEATURES = 'features';
      public static $IMAGE = 'image';
      public static $CONSTRAINTS = 'constraints';
      public static $DISCOUNT = 'discount';
      public static $QUANTITY = 'quantity';
      public static $APPROVED = 'approved';
    }
    
    class USER_TABLE {
      public static $NAME = 'users';
      public static $ROLE = 'role';
      public static $APPROVED = 'approved';
      public static $USER_NAME = 'username';
      public static $PASS_WORD = 'psword';
      public static $PASS_WORD2 = 'psword2';
      public static $FIRST_NAME = 'fname';
      public static $LAST_NAME = 'lname';
      public static $ADDRESS = 'address';
      public static $CITY = 'city';
      public static $STATE = 'state';
      public static $ZIP_CODE = 'zipcode';
      public static $EMAIL = 'email';
      public static $PHONE = 'phone';
      
      public static $ROLE_ADMIN = 'admin';
      public static $ROLE_VENDOR = 'vendor';
      public static $ROLE_USER = 'customer';
    }

    class CATEGORY_TABLE {
      public static $NAME = 'categories';
      public static $CAT_ID = 'categoryid';
      public static $CAT_NAME = 'catname';
    }
    
    class TRANSACTION_TABLE {
      public static $NAME = 'transaction';
      public static $TRANS_ID = 'transactionid';
      public static $USER_NAME = 'username';
      public static $VENDOR_ID = 'vendorid';
      public static $PROD_ID = 'productid';
      public static $QUANTITY = 'productamount';
      public static $PRICE = 'price';
      public static $STATUS = 'status';
      public static $FIRST_NAME = 'fname';
      public static $LAST_NAME = 'lname';
      public static $ADDRESS = 'address';
      public static $CITY = 'city';
      public static $STATE = 'state';
      public static $ZIP_CODE = 'zipcode';
      
      
      public static $ORDER_PENDING = 'p';
      public static $ORDER_SHIPPED = 's';
      public static $ORDER_CANCELLED = 'c';
    }
    
    
    /**
     * Given the product's status string it returns a more meaningful
     * human readable status
     */
    function statusString($order) {
      if($order[TRANSACTION_TABLE::$STATUS] == TRANSACTION_TABLE::$ORDER_CANCELLED) {
        return 'Cancelled';
      } elseif ($order[TRANSACTION_TABLE::$STATUS] == TRANSACTION_TABLE::$ORDER_PENDING) {
        return "Pending";
      } else {
        return "Shipped";
      }
    }
    
    
    
      /**
   * Creates a drop down with name $name, containing
   * the items in the array $items.  And sets the
   * item matching $selected as the selected item.
   */
  function createDropDown($name, $items, $selected) {
    echo "<select id=\"$name\" name=\"$name\" >";
    foreach ($items as $item) {
      echo '<option value="'.$item.'"';
      if($item == $selected) {
        echo ' selected = "selected"';
      }
      echo '>'.$item.'</option>';
    }
    echo "</select>";
  }
    
    /**
     * If the given product array has a discount then the discounted price
     * is returned otherwise the standard price is returned.
     */
    function actualCost($product) {
      $percOff = $product[PRODUCT_TABLE::$DISCOUNT];
			if($percOff != NULL && $percOff > 0) {
        return $product[PRODUCT_TABLE::$PRICE] * (1 - $percOff/100.0);
      }
      return $product[PRODUCT_TABLE::$PRICE];
    }


    /**
     * Creates a drop down with the given $name
     * and selects the given $selected value.
     * The created drop down goes from 1 to 100.
     */
    function quantityDropDown($name, $selected, $quantity) {
       createDropDown($name, range(1, $quantity), $selected);
    }  
    
    /**
     * Gets all the orders, newest first for this user
     */
    function selectTransactionsForUserDescTime($dbc, $user) {
      $q = 'SELECT * FROM '.TRANSACTION_TABLE::$NAME
             .' WHERE '.TRANSACTION_TABLE::$USER_NAME.' = \''.$user.'\''
             .' ORDER BY '.TRANSACTION_TABLE::$TRANS_ID.' DESC;';
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
      return array();
    }
    
    
    /**
     * Gets all orders in descending time
     */
    function allTransactionsDescendingTime($dbc) {
      $q = 'SELECT * FROM '.TRANSACTION_TABLE::$NAME
             .' ORDER BY '.TRANSACTION_TABLE::$TRANS_ID.' DESC;';
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
      return array();
    }
    
    /**
     * Returns an array of arrays, each internal array is a
     * category
     */
    function categories($dbc) {
      $q = 'SELECT * FROM '.CATEGORY_TABLE::$NAME
            .' ORDER BY '.CATEGORY_TABLE::$CAT_NAME.' ASC;';
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
      return array();
    }
    
    /**
     * Creates a drop down based on the current categories
     */
    function categoryDropDown($dbc, $name, $selected) {
      $cats = array();
      foreach(categories($dbc) as $cat) {
        $cats[] = $cat[CATEGORY_TABLE::$CAT_NAME];
      }
      createDropDown($name, $cats, $selected);
    }
    
    
    
    /**
     * Gets all the sales, newest first for this vendor of the given type.
     */
    function selectTransactionsForVendorDescTime($dbc, $vendor, $type) {
      $q = 'SELECT * FROM '.TRANSACTION_TABLE::$NAME
             .' WHERE '.TRANSACTION_TABLE::$VENDOR_ID.' = \''.$vendor.'\''
             .' AND '.TRANSACTION_TABLE::$STATUS.' =\''.$type.'\''
             .' ORDER BY '.TRANSACTION_TABLE::$TRANS_ID.' DESC;';
             
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
      return array();
    }
    
    function selectSingleCustomer($dbc, $userName) {
      $q = 'SELECT * FROM '.USER_TABLE::$NAME.' WHERE '.USER_TABLE::$USER_NAME.' = \''.$userName.'\'';
      $r = mysqli_query($dbc, $q);
      if($r) {
        return mysqli_fetch_assoc($r);
      }
      return array();
    }
    
        
    function selectSingleVendor($dbc, $userName) {
      $q = 'SELECT * FROM '.USER_TABLE::$NAME
                           .' WHERE '.USER_TABLE::$USER_NAME.' = \''.$userName.'\''
                           .' AND '.USER_TABLE::$ROLE.' = \''.USER_TABLE::$ROLE_VENDOR.'\'';
      $r = mysqli_query($dbc, $q);
      if($r) {
        return mysqli_fetch_assoc($r);
      }
      return array();
    }


    
    function selectAllProductsQuery() {
      return 'SELECT * FROM '.PRODUCT_TABLE::$NAME;
    }
    
    
    /**
     * Gets information about a the product with the given $productID
     * If it cannot be found an empty array is returned
     * This information includes:
     * The product ID           retrieved by $array[PRODUCT_TABLE::$PROD_ID]
     * The vendor ID            retrieved by $array[PRODUCT_TABLE::$VEND_ID]
     * The serial number        retrieved by $array[PRODUCT_TABLE::$PROD_NUMBER]
     * The category             retrieved by $array[PRODUCT_TABLE::$CATEGORY]
     * The product name         retrieved by $array[PRODUCT_TABLE::$PROD_NAME]
     * The description          retrieved by $array[PRODUCT_TABLE::$DESCRIPTION]
     * The images string        retrieved by $array[PRODUCT_TABLE::$IMAGES]
     * The features             retrieved by $array[PRODUCT_TABLE::$FEATURES]
     * The constraints          retrieved by $array[PRODUCT_TABLE::$CONSTRAINTS]
     * The prices               retrieved by $array[PRODUCT_TABLE::$PRICE]
     * The current discount     retrieved by $array[PRODUCT_TABLE::$DISCOUNT]
     * The approval             retrieved by $array[PRODUCT_TABLE::$APPROVED]
     * The available quantity   retrieved by $array[PRODUCT_TABLE::$QUANTITY]
     *
     * param $dbc - The dbc connection
     * param $productID - The ID for the product
     */
    function selectSingleProduct($dbc, $productID) {
      $q = selectAllProductsQuery().' WHERE '.PRODUCT_TABLE::$PROD_ID.' = \''.$productID.'\';';    
      $r = mysqli_query($dbc, $q);
      if($r) {
        return mysqli_fetch_assoc($r);
      }
      return array();
    }
    
    function selectSingleApprovedProduct($dbc, $productID) {
      $q = selectAllProductsQuery().' WHERE '.PRODUCT_TABLE::$PROD_ID.' = \''.$productID.'\' '
                                   .' AND '.PRODUCT_TABLE::$APPROVED.' = \'a\';';    
      $r = mysqli_query($dbc, $q);
      if($r) {
        return mysqli_fetch_assoc($r);
      }
      return array();
    }

        /**
     * Returns an array of arrays.
     * Each internal array represents a single product from the specified category that has been approved.
     * The format of each of these arrays is the the same as the array returned from selectSingleProduct
     */
    function selectApprovedProductsByCategory($dbc, $category) {
      $q = selectAllProductsQuery().' WHERE '.PRODUCT_TABLE::$CATEGORY.'=\''.$category.'\''
                                             .' AND '.PRODUCT_TABLE::$APPROVED.'=\'a\';';
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
      return array();
    }
    
        /**
     * Returns an array of arrays.
     * Each internal array represents a single product from the specified vendor.
     * The format of each of these arrays is the the same as the array returned from selectSingleProduct
     */
    function selectAllProductsByVendor($dbc, $vendor) {
      $q = selectAllProductsQuery().' WHERE '.PRODUCT_TABLE::$VEND_ID.'=\''.$vendor.'\';';
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
      return array();
    }
    
            /**
     * Returns an array of arrays.
     * Each internal array represents a single product from the specified vendor.
     * The format of each of these arrays is the the same as the array returned from selectSingleProduct
     */
    function selectAllProductsByVendorSortedByApproval($dbc, $vendor) {
      $q = selectAllProductsQuery().' WHERE '.PRODUCT_TABLE::$VEND_ID.'=\''.$vendor.'\''
                                  .' ORDER BY '.PRODUCT_TABLE::$APPROVED.' ASC;';
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
      return array();
    }
    
    
    /**
     * Returns an array of arrays.
     * Each internal array represents a single product from the specified vendor of the given category
     * The format of each of these arrays is the same as the array returned from selectSingleProduct
     */
    function selectAllProductsByVendorInCategory($dbc, $vendor, $category) {
      $q = selectAllProductsQuery().' WHERE '.PRODUCT_TABLE::$VEND_ID.'=\''.$vendor.'\''
                                   .' AND '.PRODUCT_TABLE::$CATEGORY.'=\''.$category.'\''
                                   .' ORDER BY '.PRODUCT_TABLE::$APPROVED.' ASC;';
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
      return array();
    }
    
    
    /**
     * Returns an array of arrays.
     * Each internal array represents a single pending product
     * The format of each of these arrays is the same as the array returned from selectSingleProduct
     */
    function selectPendingProducts($dbc) {
      $q = selectAllProductsQuery().' WHERE '.PRODUCT_TABLE::$APPROVED.'=\'p\''
                                   .' ORDER BY '.PRODUCT_TABLE::$PROD_NAME.' DESC;';
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
      return array();
    }
    
    
      /**
     * Returns an array of arrays.
     * Each internal array represents a single pending vendor
     */
    function selectPendingVendors($dbc) {
      $q = 'SELECT * FROM '.USER_TABLE::$NAME.' WHERE '.USER_TABLE::$APPROVED.'=\'0\''
                                   .' AND '.USER_TABLE::$ROLE.'=\''.USER_TABLE::$ROLE_VENDOR.'\''
                                   .' ORDER BY '.USER_TABLE::$USER_NAME.' DESC;';
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
      return array();
    }
    
    /**
     * Goes through the user's cookies and returns an array of product arrays
     * for those products that have been added to the user's cookie
     * The selected amount can be accessed with 'selected_quantity'
     */
    function productsInCart($dbc) {
      $array = array();
      foreach($_COOKIE as $cookie_name => $cookie_value) {
        if(substr($cookie_name, 0, strlen('prob_')) === 'prod_') {
          $product = selectSingleApprovedProduct($dbc, substr($cookie_name, strlen('prob_'), strlen($cookie_name)));
          if(empty($product)) {
            die("Can't find product for: " + $cookie_name);
          } else {
            $product['selected_quantity'] = $cookie_value;
            $array[] = $product;
          }
        }
      }
      return $array;
    }
    
    /**
     *Standard row output for an approved row in the reports
     */
    function approvedProductRow($product, $includeVendorID) {
      echo '<tr>';
      productRow($product, $includeVendorID);
      echo '</tr>';
    }
    
    
    /**
     *Standard row output for an approved row in the reports
     *
     *$includeTRs = true or false, depending on if the opening and closing <tr>
     *elements should be echo'd by this method
     */
    function productRow($product, $includeVendorID) {
      echo '<td>'.$product[PRODUCT_TABLE::$PROD_NAME].'-'.$product[PRODUCT_TABLE::$PROD_NUMBER].'</td>';
      if($includeVendorID) {
        echo '<td>'.$product[PRODUCT_TABLE::$VEND_ID].'</td>';
      }
      echo '<td>'.$product[PRODUCT_TABLE::$CATEGORY].'</td>';
      echo '<td><img src="images/'.$product[PRODUCT_TABLE::$IMAGE].'" height="66" width="100" /></td>';
      echo '<td>'.$product[PRODUCT_TABLE::$DESCRIPTION].'</td>';
      echo '<td>'.$product[PRODUCT_TABLE::$FEATURES].'</td>';
      echo '<td>'.$product[PRODUCT_TABLE::$CONSTRAINTS].'</td>';
      echo '<td>$'.number_format($product[PRODUCT_TABLE::$PRICE],2).'</td>';
      echo '<td>'.$product[PRODUCT_TABLE::$DISCOUNT].'%</td>';
      echo '<td>'.$product[PRODUCT_TABLE::$QUANTITY].'</td>';
    }
    
    
    /**
     * Makes a row representing a pending product with an option
     * to approve the product.
     * MAKE SURE ajaxFuncs is included!
     */
    function pendingProductRow($product, $includeVendorID, $returnPage) {
      echo '<tr>';
      productRow($product, $includeVendorID);
      echo '<td><input type="button" value="APPROVE" onclick="approveProduct(\''
                            .$product[PRODUCT_TABLE::$PROD_ID].'\',\''.$returnPage.'\')" /></td>';
      echo '</tr>';
    }
    
        /**
     * Makes a row representing a pending product with an option
     * to approve the product.
     * MAKE SURE ajaxFuncs is included!
     */
    function removedProductRow($product, $includeVendorID, $returnPage) {
      echo '<tr>';
      productRow($product, $includeVendorID);
      echo '</tr>';
    }
    
    
    
	  function selectApprovedProductsByCategoryAndPriceASC($dbc, $category) {
      $q = selectAllProductsQuery().' WHERE '.PRODUCT_TABLE::$CATEGORY.'=\''.$category.'\''
                                     .' AND '.PRODUCT_TABLE::$APPROVED.'=\'a\''
                                     .' ORDER BY '.PRODUCT_TABLE::$PRICE.' ASC'; 
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
      return array();
    }
	
	
	 function selectApprovedProductsByCategoryAndPriceDESC($dbc, $category) {
      $q = selectAllProductsQuery().' WHERE '.PRODUCT_TABLE::$CATEGORY.'=\''.$category.'\''
                                             .' AND '.PRODUCT_TABLE::$APPROVED.'=\'a\''
                                             .' ORDER BY '.PRODUCT_TABLE::$PRICE.' DESC'; 
      $r = mysqli_query($dbc, $q);
      if($r) {
        $array = array();
        while ($row = mysqli_fetch_assoc($r)) {
            $array[] = $row;
        }
        return $array;
      }
     return array();
  }
?>