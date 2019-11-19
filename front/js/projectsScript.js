
$(document).ready(function () {
    startUp();
    fillWithProjects();
});

function startUp() {
    document.getElementById("add-btn").addEventListener("click", function () { emptyModal(); });
    const modalConfirmBtn = document.getElementById("modal-mode");
    modalConfirmBtn.addEventListener("click", function () {
        if (modalConfirmBtn.value === "create") createProject();
        else updateProject();
    });
    fillWithUserOptions();
}

function fillWithProjects() {
    sendAjax("/api/projects").then(res => {
        let projects = res;
        let projectList = document.getElementById("projects");

        for (let i = 0; i < projects.length; i++) {
            displayProject(projectList, projects[i]);
        }

        const edit_el_btns = document.getElementsByClassName("edit-el");
        const delete_el_btns = document.getElementsByClassName("delete-el");

        for (let i = 0; i < edit_el_btns.length; i++) {
            let edit_btn = edit_el_btns[i];
            edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); });
        }

        for (let i = 0; i < delete_el_btns.length; i++) {
            let delete_btn = delete_el_btns[i];
            delete_btn.addEventListener("click", function () { deleteProject(delete_btn.value); });
        }
    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
    return false;
}

function displayProject(node, project) {
    const name = project.name;
    const description = project.description;

    let projectBlock = document.createElement("div");
    projectBlock.id = "project-block-" + project.id;
    projectBlock.classList.add("col-4");
    node.appendChild(projectBlock);

    projectBlock.innerHTML +=
        "<div class=\"project\">\n" +
        "<div><span class=\"fa fa-leaf logo-small\"></span></div>\n" +
        "<div id=\"project" + project.id + "-name\"><h4>" + name + "</h4></div>\n" +
        "<div id=\"project" + project.id + "-description\">" + description + "</div>\n" +
        "<div class=\"project-block\"><button id=\"edit-el-" + project.id + "\" class=\"btn btn-warning btn-block edit-el\" value=\"project" + project.id + "\">" +
        "<span class=\"fa fa-edit\"></span>\n" +
        "</button>\n" +
        "</div>\n" +
        "<div class=\"project-block\"><button id=\"delete-el-" + project.id + "\" class=\"btn btn-danger btn-block delete-el\" value=\"project" + project.id + "\">" +
        "<span class=\"fa fa-trash\"></span></button>" +
        "</div>\n" +
        "</div>\n" ;
}

function fillWithUserOptions() {
    let modalOptions = document.getElementById("modal-users");

    sendAjax("/users").then(res => {
        let users = JSON.parse(JSON.stringify(res));
        //let users = res;
        console.log("users : " + users);
        console.log("users length : " + users.length);
        for (let i = 0; i < users.length; i++) {
            let user = users[i];
            console.log("user : " + user);
            let optionNode = document.createElement("option");
            optionNode.innerHTML = user.name;
            optionNode.value = "u" + user.id;
            modalOptions.appendChild(optionNode);
            $("#modal-users").selectpicker("refresh");
        }

    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}


function createProject() {
    const nom = document.getElementById("name").value;
    const description = document.getElementById("description").value;

    let jsonData = {
        "name": nom,
        "description": description
    }
    sendAjax("/api/project", 'POST', JSON.stringify(jsonData)).then(res => {
        let project = res;
        displayProject(document.getElementById("projects"), project);

        const edit_btn = document.getElementById("edit-el-" + project.id);
        edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); })
        const delete_btn = document.getElementById("delete-el-" + project.id);
        delete_btn.addEventListener("click", function () { deleteProject(delete_btn.value); })
        $("#modal").modal("hide");
    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}


function deleteProject(value) {
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const id = value.substring(7);
        sendAjax("/api/project/" + id, 'DELETE').then(res => {
            let deletedProjectBlock = document.getElementById("project-block-" + id);
            deletedProjectBlock.parentNode.removeChild(deletedProjectBlock);
        })
            .catch(e => {
                $(".err-msg").fadeIn();
                $(".spinner-border").fadeOut();
            })
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

function emptyModal() {
    document.getElementById("id").value = 'project';
    document.getElementById("name").value = '';
    document.getElementById("description").value = '';
    document.getElementById("modal-mode").value = "create";

    $("#modal").modal("show");
}

function updateProject() {
    const id = document.getElementById("id").value.substring(2);
    const nom = document.getElementById("name").value;
    const description = document.getElementById("description").value;
    let jsonData = {
        "name": nom,
        "description": description
    }

    sendAjax("/api/project/" + id, 'PUT', JSON.stringify(jsonData)).then(res => {
        let project = res;
        document.getElementById("project" + id + "-name").innerHTML = "<h4>" + project.name + "</h4>";
        document.getElementById("project" + id + "-description").innerHTML = project.description;

        $("#modal").modal("hide");
    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}
