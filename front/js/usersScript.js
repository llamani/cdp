var xmlhttp = new XMLHttpRequest();

const confirmBtn = document.getElementById("signup");
confirmBtn.addEventListener("click", createUser);

function createUser(){
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password= document.getElementById("pwd").value;

    let jsonData = {
        "name": name,
        "email": email,
        "password" : password
    }

    const createUrl = "http://localhost:8000/user";

    let xmlhttp = new XMLHttpRequest();   // new HttpRequest instance 
    xmlhttp.open("POST", createUrl);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    xmlhttp.onreadystatechange = function () {
    };
    xmlhttp.send(JSON.stringify(jsonData));
}  