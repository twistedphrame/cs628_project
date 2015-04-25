<html>
  <head><link rel = "stylesheet" href = "includes/style.css" type = "text/css" media = "screen" /></head>
<body>
	<div id = "header">
		<h2>Online Shopping System</h2>
	</div>
	<div id = "navigation">
    <ul>
<?php
  $no_user = array();
  $no_user[] = '<a href="products.php">View Products</a>';
  $no_user[] = '<a href="signin.php">Sign In</a>';
  
  $customer = array();
  $customer[] = '<a href="products.php">View Products</a>';
  $customer[] = '<a href="shopping_cart.php">Shopping Cart</a>';
  $customer[] = '<a href="recent_orders.php">My Orders</a>';
  $customer[] = '<a href="edit_profile.php">Edit Profile</a>';
  $customer[] = '<a href="signout.php">Sign Out</a>';

  $vendor = array();
  $vendor[] = '<a href="products.php">View Products</a>';
  $vendor[] = '<a href="addproduct.php">Add Product</a>';
  $vendor[] = '<a href="removeproduct.php">Remove Product</a';
  $vendor[] = '<a href="editproduct.php">Edit Product</a>';
  $vendor[] = '<a href="shopping_cart.php">Shopping Cart</a>';
  $vendor[] = '<a href="recent_orders.php">My Orders</a>';
  $vendor[] = '<a href="edit_profile.php">Edit Profile</a>';
  $vendor[] = '<a href="signout.php">Sign Out</a>';

  $admin = array();
  $admin[] = '<a href="products.php">View Products</a>';
  $admin[] = '<a href="addcategory.php">Add Category</a>';
  $admin[] = '<a href="removecategory.php">Remove Category</a>';
  $admin[] = '<a href="vendormanage.php">Vendor Management</a>';
  $admin[] = '<a href="edit_profile.php">Edit Profile</a>';
  $admin[] = '<a href="signout.php">Sign Out</a>';
  
  $selected;
  require_once("sql_queries.php");
  if(isset($_COOKIE[USER_TABLE::$ROLE])) {
    $role = $_COOKIE[USER_TABLE::$ROLE];
    if($role == USER_TABLE::$ROLE_ADMIN) {
      $selected = $admin;
    }
    elseif ($role == USER_TABLE::$ROLE_VENDOR) {
      $selected = $vendor;
    }
    elseif ($role == USER_TABLE::$ROLE_USER) {
      $selected = $customer;
    } else {
      $selected = $no_user;
    }
  } else {
    $selected = $no_user;
  }
  
  foreach ($selected as $menu) {
    echo '<li>'.$menu.'</li>';
  }
?>
		</ul>
	</div>
</body>
</html>