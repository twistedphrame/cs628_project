<?php
if(isset($_COOKIE['role'])) {
  $role = $_COOKIE['role'];
  if($role == USER_TABLE::$ROLE_ADMIN)
    include("header_admin.html");
  elseif ($role == USER_TABLE::$ROLE_VENDOR)
    include("header_vendor.html");
  else
    include("header_cust.html");
} else {
  include("header.html");
}
?>