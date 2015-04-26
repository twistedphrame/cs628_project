<html>
  <head><link rel = "stylesheet" href = "includes/style.css" type = "text/css" media = "screen" /></head>
<body>
	<div id = "header"><h2>Online Shopping System</h2></div>
  <nav id="primary_nav_wrap">
    <ul>
<?php

  function makeNav($navArray) {
    for($i = 0; $i < sizeof($navArray); $i++ ) {
      echo '<li>';
      if(!is_array($navArray[$i])) {
        echo $navArray[$i];
      }
      if(($i+1) < sizeof($navArray) && is_array($navArray[$i+1])) {
        $i++;
        echo "<ul>";
        makeNav($navArray[$i]);
        echo "</ul>";
      }
      echo '</li>';
    }
  }

  
  
  $no_user = array();
  $no_user[] = '<a href="products.php">View Products</a>';
  $no_user[] = '<a href="signin.php">Sign In</a>';
  
  $customer = array();
  $customer[] = '<a href="products.php">View Products</a>';
  $customer[] = '<a href="shopping_cart.php">Shopping Cart</a>';
  $customer[] = '<a href="recent_orders.php">My Orders</a>';
  $customer[] = '<a href="edit_profile.php">Edit Profile</a>';
  $customer[] = '<a href="signout.php">Sign Out</a>';

  $vendorApproved = array();
  $vendorApproved[] = '<a href="products.php">View All Products</a>';
  $vendorApproved[] = '<a href="#">My Products</a>';
  $myProducts = array();
  $myProducts[] = '<a href="addproduct.php">Add Product</a>';
  $myProducts[] = '<a href="removeproduct.php">Remove Product</a>';
  $myProducts[] = '<a href="editproduct.php">Edit Product</a>';
  $vendorApproved[] = $myProducts;
  
  $vendorApproved[] = '<a href="#">Reports</a>';
  $saleReports = array();
  $saleReports[] = '<a href="vendor_sale_reports.php">Sale Reports</a>';
  $saleReports[] = '<a href="vendor_quantities.php">Remaining Stock</a>';
  $vendorApproved[] = $saleReports;
  
  $vendorApproved[] = '<a href="shopping_cart.php">Shopping Cart</a>';
  $vendorApproved[] = '<a href="recent_orders.php">My Orders</a>';
  $vendorApproved[] = '<a href="edit_profile.php">Edit Profile</a>';
  $vendorApproved[] = '<a href="signout.php">Sign Out</a>';

  
  $admin = array();
  $admin[] = '<a href="products.php">View Products</a>';
  
  $admin[] = '<a href="#">Categories</a>';
  $categories = array();
  $categories[] = '<a href="addcategory.php">Add Category</a>';
  $categories[] = '<a href="removecategory.php">Remove Category</a>';
  $admin[] = $categories;
  
  $admin[] = '<a href="#">Reports</a>';
  $reports = array();
  $reports[] = '<a href="customer_report.php">User Information</a>';
  $reports[] = '<a href="pending_product_report.php">Pending Products</a>';
  $reports[] = '<a href="pending_vendors.php">Pending Vendors</a>';
  $reports[] = '<a href="vendor_report.php">Vendors</a>';
  $reports[] = '<a href="sales_report.php">Sales</a>';
  $admin[] = $reports;
  
  $admin[] = '<a href="edit_profile.php">Edit Profile</a>';
  $admin[] = '<a href="signout.php">Sign Out</a>';
  
  $selected;
  require_once("sql_queries.php");
  if(isset($_COOKIE[USER_TABLE::$ROLE])) {
    $role = $_COOKIE[USER_TABLE::$ROLE];
    if($role == USER_TABLE::$ROLE_ADMIN) {
      $selected = $admin;
    }
    elseif ($role == USER_TABLE::$ROLE_VENDOR && $_COOKIE[USER_TABLE::$APPROVED]) {
      $selected = $vendorApproved;
    } else if($role == USER_TABLE::$ROLE_VENDOR && !$_COOKIE[USER_TABLE::$APPROVED]) {
      $selected = $customer;
    } elseif ($role == USER_TABLE::$ROLE_USER) {
      $selected = $customer;
    } else {
      $selected = $no_user;
    }
  } else {
    $selected = $no_user;
  }
  
  makeNav($selected);
?>
		</ul>
    </nav>
</body>
</html>