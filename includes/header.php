<?php
if(isset($_COOKIE[USER_TABLE::$ROLE])) {
  $role = $_COOKIE[USER_TABLE::$ROLE];
  if($role == USER_TABLE::$ROLE_ADMIN) {
    include("header_admin.html");
  }
  elseif ($role == USER_TABLE::$ROLE_VENDOR) {
    include("header_vendor.html");
  }
  elseif ($role == USER_TABLE::$ROLE_USER) {
    include("header_cust.html");
  } else {
    include("header.html");
  }
} else {
  include("header.html");
}
?>