<?php
    class PRODUCT_TABLE {
      public static $NAME = 'product';
      public static $PROD_ID = 'productid';
      public static $VEND_ID = 'vendorID';
      public static $SERIAL = 'serail_num';
      public static $CATEGORY = 'category';
      public static $PROD_NAME = 'name';
      public static $DESCRIPTION = 'desctription';
      public static $IMAGES = 'images';
      public static $FEATURES = 'features';
      public static $CONSTRAINTS = 'constraints';
      public static $PRICE = 'price';
    }
    
    
    class DISCOUNT_TABLE {
      public static $NAME = 'discounts';
      public static $PROD_ID = 'productid';
      public static $PERC_OFF = 'perc_off';
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
      $q = 'SELECT '.PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$PROD_ID.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$VEND_ID.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$SERIAL.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$CATEGORY.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$PROD_NAME.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$DESCRIPTION.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$IMAGES.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$FEATURES.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$CONSTRAINTS.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$PRICE.', '
                    .DISCOUNT_TABLE::$NAME.'.'.DISCOUNT_TABLE::$PERC_OFF
      .' FROM (SELECT '.PRODUCT_TABLE::$PROD_ID.' FROM '.PRODUCT_TABLE::$NAME.' WHERE '.PRODUCT_TABLE::$PROD_ID.' = \''.$productID.'\''
      .' UNION SELECT '.PRODUCT_TABLE::$PROD_ID.' FROM '.DISCOUNT_TABLE::$NAME.'  WHERE '.PRODUCT_TABLE::$PROD_ID.' = \''.$productID.'\') as tabkey'
      .' LEFT JOIN '.PRODUCT_TABLE::$NAME.' on tabkey.'.PRODUCT_TABLE::$PROD_ID.' = '.PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$PROD_ID
      .' LEFT JOIN '.DISCOUNT_TABLE::$NAME.' on tabkey.'.PRODUCT_TABLE::$PROD_ID.' = '.DISCOUNT_TABLE::$NAME.'.'.DISCOUNT_TABLE::$PROD_ID.';';
    
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
      $q = 'SELECT * FROM (SELECT '.PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$PROD_ID.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$VEND_ID.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$SERIAL.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$CATEGORY.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$PROD_NAME.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$DESCRIPTION.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$IMAGES.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$FEATURES.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$CONSTRAINTS.', '
                    .PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$PRICE.', '
                    .DISCOUNT_TABLE::$NAME.'.'.DISCOUNT_TABLE::$PERC_OFF
      .' FROM (SELECT '.PRODUCT_TABLE::$PROD_ID.' FROM '.PRODUCT_TABLE::$NAME
      .' UNION SELECT '.PRODUCT_TABLE::$PROD_ID.' FROM '.DISCOUNT_TABLE::$NAME.') as tabkey'
      .' LEFT JOIN '.PRODUCT_TABLE::$NAME.' on tabkey.'.PRODUCT_TABLE::$PROD_ID.' = '.PRODUCT_TABLE::$NAME.'.'.PRODUCT_TABLE::$PROD_ID
      .' LEFT JOIN '.DISCOUNT_TABLE::$NAME.' on tabkey.'.PRODUCT_TABLE::$PROD_ID.' = '.DISCOUNT_TABLE::$NAME.'.'.DISCOUNT_TABLE::$PROD_ID.')'
      .' as combined where '.PRODUCT_TABLE::$CATEGORY.'=\''.$category.'\';';
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