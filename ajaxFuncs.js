function addToCart(prodID) {
    "use strict";
    var e = document.getElementById("quantity");
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