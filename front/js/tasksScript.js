/*
const projectId = localStorage.getItem("project"); 
*/

$(document).ready(function () {
    startUp();
    fillWithTasks();
});


function startUp() {
    const add_el_btns = document.getElementsByClassName("add-el");

    for (let i = 0; i < add_el_btns.length; i++) {
        let add_btn = add_el_btns[i];
        add_btn.addEventListener("click", function () { emptyModal(add_btn.value); });
    }
}

function fillWithTasks() {
    $.ajax({
        url: "http://localhost:8000/api/tasks/1",
        method: "GET",
        dataType: 'json',
        crossDomain: true,
        success: function (tasks) {

            for (let i = 0; i < tasks.length; i++) {
                const task = tasks[i];
                fillListWithTask(getListAccordingToStatus(task.status), task);

            }
            let edit_el_btns = document.getElementsByClassName("edit-el");
            let delete_el_btns = document.getElementsByClassName("delete-el");

            for (let i = 0; i < edit_el_btns.length; i++) {
                let edit_btn = edit_el_btns[i];
                edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); });
            }

            for (let i = 0; i < delete_el_btns.length; i++) {
                let delete_btn = delete_el_btns[i];
                delete_btn.addEventListener("click", function () { deleteTask(delete_btn.value); });
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
    return false;
}

function fillListWithTask(list, task) {
    list.innerHTML +=
        "<div id=\"element-block-" + task.id + "\" class=\"row\">\n" +
        "<div id=\"element-block-title-" + task.id + "\" class=\"col-sm-8 element-block\">\n" +
        "<a href=\"#T" + task.id + "\" class=\"btn btn-default btn-block\" data-toggle=\"collapse\"\>" +
        "<span class=\"badge\"> T" + task.id + "</span >   " + task.name + "</a > \n" +
        "</div>\n" +
        "<div class=\"col-sm-2 element-block\"><button id=\"edit-el-" + task.id + "\" class=\"btn btn-warning btn-block edit-el\" value=\"T" + task.id + "\">" +
        "<span class=\"glyphicon glyphicon-pencil\"></span>\n" +
        "</button>\n" +
        "</div>\n" +
        "<div class=\"col-sm-2 element-block\"><button id=\"delete-el-" + task.id + "\" class=\"btn btn-danger btn-block delete-el\" value=\"T" + task.id + "\">" +
        "<span class=\"glyphicon glyphicon-trash\"></span></button>" +
        "</div>\n" +
        "</div>\n" +
        "<div id=\"details-block-" + task.id + "\" class=\"row\">" +
        "<div id=\"T" + task.id + "\" class=\"collapse well text-justify\">\n" +
        "<div id=\"T" + task.id + "-name\"><h4><strong>" + task.name + "</strong></h4></div>\n" +
        "<div id=\"T" + task.id + "-description\">" + task.description + "</div>\n" +
        "<button hidden id=\"T" + task.id + "-workload-btn\" value=\"" + task.workload + "\"></button>" +
        "<div id=\"T" + task.id + "-workload\">\n" +
        "<h6>Charge (en j/homme) :" +
        "<span class=\"label label-default\">" + task.workload + " </span>" +
        "</h6>" +
        "</div >\n" +
        "</div>";

}


function fillModal(value) {
    let name = document.getElementById(value + "-name").textContent;
    let description = document.getElementById(value + "-description").innerHTML;
    let workload = document.getElementById(value + "-workload-btn").value;

    document.getElementById("modal-id").value = value;
    document.getElementById("modal-nom").value = name;
    document.getElementById("modal-description").value = description;
    document.getElementById("modal-workload").value = workload;
    document.getElementById("modal-mode").value = "update";

    $("#modal").modal("show");

}

function emptyModal(status) {
    document.getElementById("modal-id").value = 't';
    document.getElementById("modal-nom").value = '';
    document.getElementById("modal-description").value = '';
    document.getElementById("modal-workload").value = '';
    document.getElementById("modal-status").value = status;
    document.getElementById("modal-mode").value = "create";

    $("#modal").modal("show");
}
const modalConfirmBtn = document.getElementById("modal-mode");
modalConfirmBtn.addEventListener("click", function () {
    if (modalConfirmBtn.value === "create") createTask();
    else updateTask();
});

function createTask() {
    const nom = document.getElementById("modal-nom").value;
    const description = document.getElementById("modal-description").value;
    const workload = document.getElementById("modal-workload").value;
    const status = document.getElementById("modal-status").value;

    let jsonData = {
        "name": nom,
        "description": description,
        "workload": workload,
        "status": status,
        "issue": 1
    }
    $.ajax({
        url: "http://localhost:8000/api/task",
        method: "POST",
        dataType: 'json',
        crossDomain: true,
        success: function (task) {
            const node = document.createElement("div");
            fillListWithTask(node, task);
            getListAccordingToStatus(task.status).appendChild(node);

            const edit_btn = document.getElementById("edit-el-" + task.id);
            edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); })
            const delete_btn = document.getElementById("delete-el-" + task.id);
            delete_btn.addEventListener("click", function () { deleteTask(delete_btn.value); })
            $("#modal").modal("hide");

        },
        error: function (error) {
            console.error(error);
        }
    });
    return false;
}

function getListAccordingToStatus(status) {
    const todoListEl = document.getElementById("to-do");
    const inProgressListEl = document.getElementById("in-progress");
    const doneListEl = document.getElementById("done");

    if (status === 'todo')
        return todoListEl;
    else if (status === 'in progress')
        return inProgressListEl;
    else return doneListEl;
}


function deleteTask(task) {
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const tId = task.substring(1);
        $.ajax({
            url: "http://localhost:8000/api/task/" + tId,
            method: "DELETE",
            crossDomain: true,
            success: function (issue) {
                let deletedBlock = document.getElementById("element-block-" + tId);
                deletedBlock.parentNode.removeChild(deletedBlock);
                let deletedDetails = document.getElementById("details-block-" + tId);
                deletedDetails.parentNode.removeChild(deletedDetails);
            },
            error: function (error) {
                console.error(error);
            }
        });

    }
}

function updateTask() {
    const tId = document.getElementById("modal-id").value.substring(1);
    const nom = document.getElementById("modal-nom").value;
    const description = document.getElementById("modal-description").value;
    const workload = document.getElementById("modal-workload").value;

    let jsonData = {
        "name": nom,
        "description": description,
        "workload": workload,
        "status": status,
        "issue": 1
    }

    $.ajax({
        url: "http://localhost:8000/api/task/" + tId,
        method: "PUT",
        dataType: 'json',
        data: JSON.stringify(jsonData),
        crossDomain: true,
        success: function (issue) {
            document.getElementById("element-block-title-" + tId).getElementsByTagName("a")[0].innerHTML = "<span class=\"badge\"> T" + tId + "</span >   " + nom;
            document.getElementById("T" + tId + "-name").innerHTML = "<h4><strong>" + nom + "</strong></h4>";
            document.getElementById("T" + tId + "-description").innerHTML = description;
            document.getElementById("T" + tId + "-workload-btn").value = workload;
            document.getElementById("T" + tId + "-workload").innerHTML = "<h6>Charge (en j/homme) :" +
                "<span class=\"label label-default\">" + workload + " </span>" +
                "</h6>";


            $("#modal").modal("hide");
        },
        error: function (error) {
            console.error(error);
        }
    });
}
