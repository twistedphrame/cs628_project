<?php
    class PRODUCT_TABLE {
      public static $NAME = 'product';
      public static $PROD_ID = 'productid';
      public static $PROD_NAME = 'productname';
      public static $CATEGORY = 'category';
      public static $VEND_ID = 'vendorID';
      public static $DESCRIPTION = 'desctription';
      public static $PRICE = 'price';
      public static $PROD_NUMBER = 'productnumber';
      public static $FEATURES = 'features';
      public static $IMAGE = 'image';
      public static $CONSTRAINTS = 'constraints';
      public static $DISCOUNT = 'discount';
    }


    /**
     * Creates a drop down with the given $name
     * and selects the given $selected value.
     * The created drop down goes from 1 to 100.
     */
    function quantityDropDown($name, $selected) {
        echo "<select id=\"$name\" name=\"$name\" >";
        foreach (range(1, 100) as $number) {
            echo '<option value="'.$number.'"';
            if($number === $selected) {
                echo ' selected = "selected"';
            }
            echo '>'.$number.'</option>';
        }
        echo "</select>";
    }
    
    /**
     * Gets information about a the product with the given $productID
     * If it cannot be found an empty array is returned
     * This information includes:
     * The product ID           retrieved by $array[PRODUCT_TABLE::$PROD_ID]
     * The vendor ID            retrieved by $array[PRODUCT_TABLE::$VEND_ID]
     * The serial number        retrieved by $array[PRODUCT_TABLE::$SERIAL]
     * The category             retrieved by $array[PRODUCT_TABLE::$CATEGORY]
     * The product name         retrieved by $array[PRODUCT_TABLE::$PROD_NAME]
     * The description          retrieved by $array[PRODUCT_TABLE::$DESCRIPTION]
     * The images string        retrieved by $array[PRODUCT_TABLE::$IMAGES]
     * The features             retrieved by $array[PRODUCT_TABLE::$FEATURES]
     * The constraints          retrieved by $array[PRODUCT_TABLE::$CONSTRAINTS]
     * The prices               retrieved by $array[PRODUCT_TABLE::$PRICE]
     * The current discount     retrieved by $array[DISCOUNT_TABLE::$PERC_OFF]
     *
     *
     * param $dbc - The dbc connection
     * param $productID - The ID for the product
     */
    function selectSingleProduct($dbc, $productID) {
      $q = 'SELECT '.PRODUCT_TABLE::$PROD_ID.', '
                    .PRODUCT_TABLE::$VEND_ID.', '
                    .PRODUCT_TABLE::$PROD_NUMBER.', '
                    .PRODUCT_TABLE::$CATEGORY.', '
                    .PRODUCT_TABLE::$PROD_NAME.', '
                    .PRODUCT_TABLE::$DESCRIPTION.', '
                    .PRODUCT_TABLE::$IMAGE.', '
                    .PRODUCT_TABLE::$FEATURES.', '
                    .PRODUCT_TABLE::$CONSTRAINTS.', '
                    .PRODUCT_TABLE::$PRICE.', '
                    .PRODUCT_TABLE::$DISCOUNT
      .' FROM '.PRODUCT_TABLE::$NAME.' WHERE '.PRODUCT_TABLE::$PROD_ID.' = \''.$productID.'\';';
    
      $r = mysqli_query($dbc, $q);
      if($r) {
        return mysqli_fetch_assoc($r);
      }
      return array();
    }

    /**
     * Returns an array of arrays.
     * Each internal array represents a single product from the specified category.
     * The format of each of these arrays is the the same as the array returned from selectSingleProduct
     */
    function selectAllProductsByCategory($dbc, $category) {
              $q = 'SELECT '.PRODUCT_TABLE::$PROD_ID.', '
                    .PRODUCT_TABLE::$VEND_ID.', '
                    .PRODUCT_TABLE::$PROD_NUMBER.', '
                    .PRODUCT_TABLE::$CATEGORY.', '
                    .PRODUCT_TABLE::$PROD_NAME.', '
                    .PRODUCT_TABLE::$DESCRIPTION.', '
                    .PRODUCT_TABLE::$IMAGE.', '
                    .PRODUCT_TABLE::$FEATURES.', '
                    .PRODUCT_TABLE::$CONSTRAINTS.', '
                    .PRODUCT_TABLE::$PRICE.', '
                    .PRODUCT_TABLE::$DISCOUNT
      .' FROM '.PRODUCT_TABLE::$NAME.' WHERE '.PRODUCT_TABLE::$CATEGORY.'=\''.$category.'\';'

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
              $q = 'SELECT '.PRODUCT_TABLE::$PROD_ID.', '
                    .PRODUCT_TABLE::$VEND_ID.', '
                    .PRODUCT_TABLE::$PROD_NUMBER.', '
                    .PRODUCT_TABLE::$CATEGORY.', '
                    .PRODUCT_TABLE::$PROD_NAME.', '
                    .PRODUCT_TABLE::$DESCRIPTION.', '
                    .PRODUCT_TABLE::$IMAGE.', '
                    .PRODUCT_TABLE::$FEATURES.', '
                    .PRODUCT_TABLE::$CONSTRAINTS.', '
                    .PRODUCT_TABLE::$PRICE.', '
                    .PRODUCT_TABLE::$DISCOUNT
      .' FROM '.PRODUCT_TABLE::$NAME.' WHERE '.PRODUCT_TABLE::$VEND_ID.'=\''.$vendor.'\';'

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