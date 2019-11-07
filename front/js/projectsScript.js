
var xmlhttp = new XMLHttpRequest();
const url = "http://localhost:8000/projects";

xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        const projects = JSON.parse(this.responseText);

        let projectList = document.getElementById("projects");

        for (let i = 0; i < projects.length; i++) {
            projectList.innerHTML += "<div class=\"col-sm-3\"></div>\n";
            //for (i; i < i + 3; i++){
                const project = projects[i];
                displayProject(project);
            //} 
            projectList.innerHTML += "<div class=\"col-sm-3\"></div>\n";
        }

        var add_el_btns = document.getElementsByClassName("add-el");
        var edit_el_btns = document.getElementsByClassName("edit-el");
        var delete_el_btns = document.getElementsByClassName("delete-el");

        for (let i = 0; i < add_el_btns.length; i++) {
            let add_btn = add_el_btns[i];
            add_btn.addEventListener("click", function () { emptyModal(add_btn.value); });
        }

        for (let i = 0; i < edit_el_btns.length; i++) {
            let edit_btn = edit_el_btns[i];
            edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); });
        }

        for (let i = 0; i < delete_el_btns.length; i++) {
            console.log("oki");
            let delete_btn = delete_el_btns[i];
            delete_btn.addEventListener("click", function () { deleteProject(delete_btn.value); });
        }

    }

   

};

xmlhttp.open("GET", url, true);
xmlhttp.setRequestHeader("Content-Type", "application/json");
xmlhttp.setRequestHeader('Access-Control-Allow-Origin', '*');
xmlhttp.send();



function displayProject(project) {
    let projectList = document.getElementById("projects");

    const name = project.name;
    const description = project.description;
    const date = project.created_at;

    projectList.innerHTML +=
    "<div id=\"project-block-" + project.id + "\">\n" +
    "<div class=\"col-sm-2\">\n" +
      "<div class=\"project\">\n" +
        "<span class=\"glyphicon glyphicon-leaf logo-small\"></span>\n" + 
            "<div id=\"project" + project.id + "-name\"><h4>" + name + "</h4></div>\n" +
            "<div id=\"project" + project.id + "-description\">" + description + "</div>\n" +
            "<div class=\"col-sm-2 project-block\"><button class=\"btn btn-warning btn-block edit-el\" value=\"project" + project.id + "\">" +
            "<span class=\"glyphicon glyphicon-pencil\"></span>\n" +
            "</button>\n" +
            "</div>\n" +
            "<div class=\"col-sm-2 project-block\"><button class=\"btn btn-danger btn-block delete-el\" value=\"project" + project.id + "\">" +
            "<span class=\"glyphicon glyphicon-trash\"></span></button>" +
            "</div>\n"+
    "</div>\n" +
    "</div>\n" +
    "</div>\n";

}

const modalConfirmBtn = document.getElementById("modal-mode");
modalConfirmBtn.addEventListener("click", function () {
    if (modalConfirmBtn.value === "create") createProject();
     else updateProject();
});

function createProject(){
    const nom = document.getElementById("name").value;
    const description = document.getElementById("description").value;

    let jsonData = {
        "name": nom,
        "description": description
    }

    const createUrl = "http://localhost:8000/project";

    let xmlhttp = new XMLHttpRequest();   // new HttpRequest instance 
    xmlhttp.open("POST", createUrl);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            $("#modal").modal("hide");
        }
    };
    xmlhttp.send(JSON.stringify(jsonData));
}       


function deleteProject(value){
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const id = value.substring(7);

        const deleteUrl = "http://localhost:8000/project/" + id;

        console.log(deleteUrl);

        let xmlhttp = new XMLHttpRequest();   // new HttpRequest instance 
        xmlhttp.open("DELETE", deleteUrl);
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    let deletedProjectBlock = document.getElementById("project-block-" + id);
                    deletedProjectBlock.parentNode.removeChild(deletedProjectBlock);
                }
            }
        };
        xmlhttp.send();
    }
}

function fillModal(value) {
    let id = value.substring(5);
    let name = document.getElementById(value + "-name").textContent;
    let description = document.getElementById(value + "-description").innerHTML;

    document.getElementById("id").value = id;
    document.getElementById("name").value = name;
    document.getElementById("description").value = description;
    document.getElementById("modal-mode").value = "update";

    $("#modal").modal("show");

}

function emptyModal(status) {
    document.getElementById("id").value = 'project';
    document.getElementById("name").value = '';
    document.getElementById("description").value = '';
    document.getElementById("modal-mode").value = "create";

    $("#modal").modal("show");
}

function updateProject(){
    const id = document.getElementById("id").value.substring(2);
    const nom = document.getElementById("name").value;
    const description = document.getElementById("description").value;

    let jsonData = {
        "name": nom,
        "description": description
    }

    const createUrl = "http://localhost:8000/project/" + id;

    let xmlhttp = new XMLHttpRequest();   // new HttpRequest instance 
    xmlhttp.open("PUT", createUrl);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            console.log("ici");
            console.log(this.responseText);
            $("#modal").modal("hide");
        }
    };
    xmlhttp.send(JSON.stringify(jsonData));
    console.log(jsonData);   
}