document.getElementById('async').addEventListener('submit' , postReq);

function postReq(e){
    e.preventDefault();
    var sugar1 = document.getElementById('').value;
    var params = "sugar=" + sugar1;
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , './php/cart.php' , true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');
    //xhr.onload()
    xhr.send(params);
}