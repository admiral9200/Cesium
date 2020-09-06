function minus(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET' , './php/cart.php?qty=minus' , true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');
    xhr.send();
    console.log("clicked");
}

function plus(){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', './php/cart.php?qty=plus', true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');
    xhr.send();
}