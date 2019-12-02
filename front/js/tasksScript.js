const projectId = JSON.parse(localStorage.getItem("user_current_project")).id;
const sprintId = document.getElementById("sprintId").value;

$(document).ready(function () {
    startUp();
    fillWithTasks();
    setDragAndDrop();
});

function startUp() {
    const add_el_btns = document.getElementsByClassName("add-el");

    for (let i = 0; i < add_el_btns.length; i++) {
        let add_btn = add_el_btns[i];
        add_btn.addEventListener("click", function () { emptyModal(add_btn.value); });
    }

    fillModalWithIssueOptions();
}

function fillModalWithIssueOptions() {
    let modalOptions = document.getElementById("modal-dependant-issues");

    sendAjax("/api/issues/" + projectId).then(res => {
        let issues = res;
        for (let i = 0; i < issues.length; i++) {
            let issue = issues[i];
            let optionNode = document.createElement("option");
            optionNode.innerHTML = issue.name;
            optionNode.value = "u" + issue.id;
            modalOptions.appendChild(optionNode);
            $("#modal-dependant-issues").selectpicker("refresh");
        }
    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}

function isIssueInSprint(issue, sprintId) {
    const issueSprints = issue.sprints;
    for (let i = 0; i < issueSprints.length; i++) {
        if (issueSprints[i].id.toString() === sprintId) {
            return true;
        }
    }
    return false;
}

function isTaskInSprint(taskIssues, sprintId) {
    for (let i = 0; i < taskIssues.length; i++) {
        const issue = taskIssues[i];
        if (isIssueInSprint(issue, sprintId))
            return true;
    }
    return false;
}

function fillWithTasks() {
    sendAjax("/api/tasks/" + projectId).then(res => {
        let tasks = res;
        for (let i = 0; i < tasks.length; i++) {
            let task = tasks[i];
            if (isTaskInSprint(task.issues, sprintId)) {
                fillListWithTask(getListAccordingToStatus(task.status), task);
            }
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
    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}

function fillListWithTask(list, task) {
    list.innerHTML +=
        "<div class=\"draggableblock\" id=\"drag-" + task.id + "\">" +
        "<div id=\"element-block-" + task.id + "\" class=\"row\">\n" +
        "<div id=\"element-block-title-" + task.id + "\" class=\"col-sm-8 element-block\">\n" +
        "<a data-target=\"#T" + task.id + "\" class=\"btn btn-default btn-block\" data-toggle=\"collapse\"\>" +
        "<span class=\"badge\"> T" + task.id + "</span >   " + task.name + "</a > \n" +
        "</div>\n" +
        "<div class=\"col-sm-2 element-block\"><button id=\"edit-el-" + task.id + "\" class=\"btn btn-warning btn-block edit-el\" value=\"T" + task.id + "\">" +
        "<span class=\"fa fa-edit\"></span>\n" +
        "</button>\n" +
        "</div>\n" +
        "<div class=\"col-sm-2 element-block\"><button id=\"delete-el-" + task.id + "\" class=\"btn btn-danger btn-block delete-el\" value=\"T" + task.id + "\">" +
        "<span class=\"fa fa-trash\"></span></button>" +
        "</div>\n" +
        "</div>\n" +
        "<div id=\"details-block-" + task.id + "\" class=\"row\">" +
        "<div id=\"T" + task.id + "\" class=\"collapse card card-body text-justify\">\n" +
        "<div id=\"T" + task.id + "-name\" class=\"text-center\"><h4><strong>" + task.name + "</strong></h4></div>\n" +
        "<div id=\"T" + task.id + "-description\">" + task.description + "</div>\n" +
        "<hr>" +
        "<button hidden id=\"T" + task.id + "-workload-btn\" value=\"" + task.workload + "\"></button>" +
        "<div id=\"T" + task.id + "-workload\">\n" +
        "<h6>Charge (en j/homme) :" +
        "<span class=\"label label-default\">" + task.workload + " </span>" +
        "</h6>" +
        "</div >\n" +
        "<hr>" +
        "<div id=\"T" + task.id + "-issues\">\n" +
        "</div>\n" +
        "</div>" +
        "</div>";

    listTaskIssues(task.id, task.issues);
    setDragAndDrop();
}

function listTaskIssues(taskId, issues) {
    let issuesBlock = document.getElementById("T" + taskId + "-issues");
    let title = document.createElement("h5");
    title.innerHTML = "Issues : ";
    issuesBlock.appendChild(title);
    let ul = document.createElement("ul");

    for (let i = 0; i < issues.length; i++) {
        let dependantIssue = issues[i];
        let issueName = document.createElement("li");
        issueName.innerHTML += dependantIssue.name;
        ul.appendChild(issueName);
        let hiddenInput = document.createElement("button");
        hiddenInput.hidden = true;

        hiddenInput.classList.add("T" + taskId + "-hiddenIds");
        hiddenInput.id = taskId + "-" + i;
        hiddenInput.value = "u" + dependantIssue.id;
        ul.appendChild(hiddenInput);
    }
    issuesBlock.appendChild(ul);
}

function setDragAndDrop() {
    let todo = document.getElementById('to-do');
    let inprogress = document.getElementById('in-progress');
    let done = document.getElementById('done');

    Sortable.create(todo, {
        group: 'list-1',
        handle: '.draggableblock',
        sort: false,
        onEnd: function (/**Event*/evt) {
            updateStatus(evt.item.id, evt.to.id);
        }
    });

    Sortable.create(inprogress, {
        group: 'list-1',
        sort: false,
        handle: '.draggableblock',
        onEnd: function (/**Event*/evt) {
            updateStatus(evt.item.id, evt.to.id);
        }
    });

    Sortable.create(done, {
        group: 'list-1',
        sort: false,
        handle: '.draggableblock',
        onEnd: function (/**Event*/evt) {
            updateStatus(evt.item.id, evt.to.id);
        }
    });
}

function updateStatus(task, new_status) {
    let id = task.substring(5);
    let status = new_status;
    if (new_status === "to-do") {
        status = "todo";
    }
    else if (new_status === "in-progress") {
        status = status.replace("-", " ");
    }
    let jsonData = {
        status: status
    }

    sendAjax("/api/slide-task/" + id, 'PUT', JSON.stringify(jsonData))
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}

function fillModal(value) {
    const tId = value.substring(1);
    let name = document.getElementById(value + "-name").textContent;
    let description = document.getElementById(value + "-description").innerHTML;
    let workload = document.getElementById(value + "-workload-btn").value;

    document.getElementById("modal-id").value = value;
    document.getElementById("modal-nom").value = name;
    document.getElementById("modal-description").value = description;
    document.getElementById("modal-workload").value = workload;
    document.getElementById("modal-mode").value = "update";

    let selectedValues = getDependantIssuesFromBlock(tId);

    let modalOptions = document.getElementById("modal-dependant-issues").options;
    for (let i = 0; i < modalOptions.length; i++) {
        let option = modalOptions[i];
        if (selectedValues.includes(option.value))
            option.selected = true;
        else
            option.selected = false;
    }
    $("#modal-dependant-issues").selectpicker("refresh");
    $("#modal").modal("show");
}

function getDependantIssuesFromBlock(taskId) {
    let classes = document.getElementsByClassName("T" + taskId + "-hiddenIds");
    let issues = [];
    for (let i = 0; i < classes.length; i++) {
        issues.push(classes[i].value);
    }
    return issues;
}

function emptyModal(status) {
    document.getElementById("modal-id").value = 't';
    document.getElementById("modal-nom").value = '';
    document.getElementById("modal-description").value = '';
    document.getElementById("modal-workload").value = '';
    document.getElementById("modal-status").value = status;
    document.getElementById("modal-mode").value = "create";

    let modalOptions = document.getElementById("modal-dependant-issues").options;

    for (let i = 0; i < modalOptions.length; i++) {
        modalOptions[i].selected = false;
    }
    $("#modal").modal("show");
}
const modalConfirmBtn = document.getElementById("modal-mode");
modalConfirmBtn.addEventListener("click", function () {
    if (modalConfirmBtn.value === "create") createTask();
    else updateTask();
});

function createTask() {
    let jsonData = getJsonDataFromModal();

    sendAjax("/api/task", 'POST', JSON.stringify(jsonData)).then(res => {
        let task = res;
        if (isTaskInSprint(task.issues, sprintId)) {
            const node = document.createElement("div");
            getListAccordingToStatus(task.status).appendChild(node);
            fillListWithTask(node, task);

            const edit_btn = document.getElementById("edit-el-" + task.id);
            edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); })
            const delete_btn = document.getElementById("delete-el-" + task.id);
            delete_btn.addEventListener("click", function () { deleteTask(delete_btn.value); })
        }
        $("#modal").modal("hide");
    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}


function getJsonDataFromModal() {
    $("#modal-dependant-issues").selectpicker("refresh");
    const nom = document.getElementById("modal-nom").value;
    const description = document.getElementById("modal-description").value;
    const workload = document.getElementById("modal-workload").value;
    const status = document.getElementById("modal-status").value;
    const dependantIssues = getDependantIssuesFromModal();

    return {
        "name": nom,
        "description": description,
        "workload": workload,
        "status": status,
        "issue": dependantIssues
    };
}



function getDependantIssuesFromModal() {
    let select = document.getElementById("modal-dependant-issues");
    let selectedValues = [];
    for (let i = 0; i < select.length; i++) {
        if (select.options[i].selected) {
            let value = select.options[i].value;
            selectedValues.push(value.substring(1));
        }
    }
    return selectedValues;
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
        sendAjax("/api/task/" + tId, 'DELETE').then(res => {
            deleteTaskHtml(tId);
        })
            .catch(e => {
                $(".err-msg").fadeIn();
                $(".spinner-border").fadeOut();
            })
    }
}

function deleteTaskHtml(tId) {
    let deletedBlock = document.getElementById("element-block-" + tId);
    deletedBlock.parentNode.removeChild(deletedBlock);
    let deletedDetails = document.getElementById("details-block-" + tId);
    deletedDetails.parentNode.removeChild(deletedDetails);
}

function updateTask() {
    const tId = document.getElementById("modal-id").value.substring(1);
    let jsonData = getJsonDataFromModal();

    sendAjax("/api/task/" + tId, 'PUT', JSON.stringify(jsonData)).then(res => {
        let task = res;
        let issues = Object.values(task.issues);
        if (isTaskInSprint(issues, sprintId)) {
            document.getElementById("element-block-title-" + tId).getElementsByTagName("a")[0].innerHTML = "<span class=\"badge\"> T" + tId + "</span >   " + task.name;
            document.getElementById("T" + tId + "-name").innerHTML = "<h4><strong>" + task.name + "</strong></h4>";
            document.getElementById("T" + tId + "-description").innerHTML = task.description;
            document.getElementById("T" + tId + "-workload-btn").value = task.workload;
            document.getElementById("T" + tId + "-workload").innerHTML = "<h6>Charge (en j/homme) :" +
                "<span class=\"label label-default\">" + task.workload + " </span>" +
                "</h6>";

            let issuesBlock = document.getElementById("T" + task.id + "-issues");
            issuesBlock.querySelectorAll('*').forEach(n => n.remove());

            listTaskIssues(task.id, issues);
        }
        else {
            deleteTaskHtml(task.id);
        }
        $("#modal").modal("hide");
    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}


