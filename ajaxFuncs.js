function addToCart(prodID, dropDownID) {
    "use strict";
    var e = document.getElementById(dropDownID);
    var quantity = e.options[e.selectedIndex].value;
    var xhr;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Msxml2.XMLHTTP");
    } else {
        throw new Error("Ajax is not supported by this browser");
    }
    //what do I do when i get a response back
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200 && xhr.status < 300) {
                window.location.replace('shopping_cart.php', '_SELF');
            }
        }
    }
  	xhr.open('POST', 'add_2_cart.php');
  	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  	xhr.send("productid="+prodID
             +"&quantity="+quantity);
}

function removeItemFromCart(prodID) {
  "use strict";
  var r = confirm("Are you sure you want to removed the selected item from the cart?");
	if (r == true) {
    var xhr;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Msxml2.XMLHTTP");
    } else {
        throw new Error("Ajax is not supported by this browser");
    }
    //what do I do when i get a response back
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200 && xhr.status < 300) {
                window.location.replace('shopping_cart.php', '_SELF');
            }
        }
    }
    xhr.open('POST', 'remove_from_cart.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("productid="+prodID);
  }
}

function order(username) {
"use strict";
  var xhr;
  if (window.XMLHttpRequest) {
      xhr = new XMLHttpRequest();
  } else if (window.ActiveXObject) {
      xhr = new ActiveXObject("Msxml2.XMLHTTP");
  } else {
      throw new Error("Ajax is not supported by this browser");
  }
  //what do I do when i get a response back
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
          if (xhr.status === 200 && xhr.status < 300) {
              window.location.replace('recent_orders.php', '_SELF');
          }
      }
  }
  xhr.open('POST', 'order.php');
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("username="+username);
}

function updateOrderStatus(prodID, transID, username, newStatus, pageToReturnTo) {
"use strict";
  var status;
  if (newStatus == 'c') {
    status = 'canceled';
  } else if (new status == 'p') {
    status = 'pending';
  } else {
    status = 'shipped';
  }
  var r = confirm("The order status will be updates to '" + status + "', do you want to continue?");
  if (r) {
    var xhr;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Msxml2.XMLHTTP");
    } else {
        throw new Error("Ajax is not supported by this browser");
    }
    //what do I do when i get a response back
    xhr.onreadystatechange = function () {
        if (xhr.status == 404) {
          alert("Oh no, it does not exist!");
        }
        if (xhr.readyState === 4) {
            if (xhr.status === 200 && xhr.status < 300) {
              window.location.replace(pageToReturnTo, '_SELF');
            }
        }
    }
    xhr.open('POST', 'order_status_update.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("productid="+prodID
           +"&transactionid="+transID
           +"&username="+username
           +"&status="+newStatus);
  }
}