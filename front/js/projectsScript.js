
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
}

function fillWithProjects() {
    $.ajax({
        url: "http://localhost:8000/api/projects",
        method: "GET",
        dataType: 'json',
        crossDomain: true,
        success: function (projects) {
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
        },
        error: function (error) {
            console.error(error);
        }
    });
    return false;

}

function displayProject(node, project) {
    const name = project.name;
    const description = project.description;

    node.innerHTML +=
        "<div id=\"project-block-" + project.id + "\">\n" +
        "<div class=\"col-sm-4  \">\n" +
        "<div class=\"project\">\n" +
        "<div><span class=\"glyphicon glyphicon-leaf logo-small\"></span></div>\n" +
        "<div id=\"project" + project.id + "-name\"><h4>" + name + "</h4></div>\n" +
        "<div id=\"project" + project.id + "-description\">" + description + "</div>\n" +
        "<div class=\"project-block\"><button id=\"edit-el-" + project.id + "\" class=\"btn btn-warning btn-block edit-el\" value=\"project" + project.id + "\">" +
        "<span class=\"glyphicon glyphicon-pencil\"></span>\n" +
        "</button>\n" +
        "</div>\n" +
        "<div class=\"project-block\"><button id=\"delete-el-" + project.id + "\" class=\"btn btn-danger btn-block delete-el\" value=\"project" + project.id + "\">" +
        "<span class=\"glyphicon glyphicon-trash\"></span></button>" +
        "</div>\n" +
        "</div>\n" +
        "</div>\n" +
        "</div>\n";

}



function createProject() {
    const nom = document.getElementById("name").value;
    const description = document.getElementById("description").value;

    let jsonData = {
        "name": nom,
        "description": description
    }

    $.ajax({
        url: "http://localhost:8000/api/project",
        method: "POST",
        dataType: 'json',
        data: JSON.stringify(jsonData),
        crossDomain: true,
        success: function (project) {
            const node = document.createElement("div");
            displayProject(node, project);
            document.getElementById("projects").appendChild(node);

            const edit_btn = document.getElementById("edit-el-" + project.id);
            edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); })
            const delete_btn = document.getElementById("delete-el-" + project.id);
            delete_btn.addEventListener("click", function () { deleteIssue(delete_btn.value); })
            $("#modal").modal("hide");
        },
        error: function (error) {
            console.error(error);
        }
    });
}


function deleteProject(value) {
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const id = value.substring(7);

        $.ajax({
            url: "http://localhost:8000/api/project/" + id,
            method: "DELETE",
            crossDomain: true,
            success: function (project) {
                let deletedProjectBlock = document.getElementById("project-block-" + id);
                deletedProjectBlock.parentNode.removeChild(deletedProjectBlock);
            },
            error: function (error) {
                console.error(error);
            }
        });
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

    $.ajax({
        url: "http://localhost:8000/api/project/" + id,
        method: "PUT",
        dataType: 'json',
        data: JSON.stringify(jsonData),
        crossDomain: true,
        success: function (project) {
            document.getElementById("project" + id + "-name").innerHTML = "<h4>" + nom + "</h4>";
            document.getElementById("project" + id + "-description").innerHTML = description;

            $("#modal").modal("hide");
        },
        error: function (error) {
            console.error(error);
        }
    });
}