const projectId = JSON.parse(localStorage.getItem("user_current_project")).id;

$(document).ready(function () {
    startUp();
    fillWithIssues();
});

/**
 * Attaches the event listener to the add buttons
 * and the modal confirm button. */
function startUp() {
    const add_el_btns = document.getElementsByClassName("add-el");

    for (let i = 0; i < add_el_btns.length; i++) {
        let add_btn = add_el_btns[i];
        add_btn.addEventListener("click", function () { emptyModal(); });
    }
    const modalConfirmBtn = document.getElementById("modal-mode");
    modalConfirmBtn.addEventListener("click", function () {
        if (modalConfirmBtn.value === "create") createIssue();
        else updateIssue();
    });
}

/**
 * Adds issues to the page and attaches the event listeners to their
 * corresponding edit and delete buttons. */
function fillWithIssues() {
    sendAjax("/api/issues/" + projectId).then(res => {
        let issues = res;
        let issuesList = document.getElementById("issues");
        for (let i = 0; i < issues.length; i++) {
            let issue = issues[i];
            displayIssue(issuesList, issue);
        }

        let edit_el_btns = document.getElementsByClassName("edit-el");
        let delete_el_btns = document.getElementsByClassName("delete-el");

        for (let i = 0; i < edit_el_btns.length; i++) {
            let edit_btn = edit_el_btns[i];
            edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); });
        }
        for (let i = 0; i < delete_el_btns.length; i++) {
            let delete_btn = delete_el_btns[i];
            delete_btn.addEventListener("click", function () { deleteIssue(delete_btn.value); });
        }
    })
        .catch(() => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}

/**
 * @param {*} node : the html node where the issue should be inserted
 * @param {*} issue : the issue which should be displayed */
function displayIssue(node, issue) {
    const name = issue.name;
    const description = issue.description;
    const issueId = issue.id;
    let issueBlock = document.createElement("div");
    issueBlock.id = "issue-block-" + issueId;
    issueBlock.classList.add("row");
    node.appendChild(issueBlock);
    issueBlock.innerHTML +=
        "<div class=\"col-8\" id=\"accordion-" + issueId + "\">" +
        "<a data-toggle=\"collapse\" data-target=\"#collapse-" + issueId + "\" role=\"button\" aria-expanded=\"false\" aria-controls=\"collapse-" + issueId + "\">" +
        "<div id=\"issue" + issueId + "-name\" class=\"text-center\"><h4>" + name + "</h4></div>" +
        "</a>" +
        "</div>" +
        "<div class=\"col-2\">" +
        "<button id=\"edit-el-" + issueId + "\" class=\"btn btn-warning btn-block edit-el\" value=\"issue" + issueId + "\">" +
        "<span class=\"fa fa-edit\"></span>\n" +
        "</button>\n" +
        "</div>" +
        "<div class=\"col-2\">" +
        "<button id=\"delete-el-" + issueId + "\" class=\"btn btn-danger btn-block delete-el\" value=\"issue" + issueId + "\">" +
        "<span class=\"fa fa-trash\"></span></button>" +
        "</div>" +
        "<div id=\"collapse-" + issueId + "\" class=\"collapse col-8\" aria-labelledby=\"issue" + issueId + "\" >" +
        "<div class=\"card card-body\">" +
        "<div id=\"issue" + issueId + "-description\">" + description + "</div>" +
        "<button hidden id=\"issue" + issueId + "-priority-btn\" value=\"" + issue.priority + "\"></button>" +
        "<div id=\"issue" + issueId + "-priority\">\n" +
        "<h6>Priorité :" +
        "<span class=\"label label-default\">" + issue.priority + " </span>" +
        "</h6>" +
        "</div >\n" +
        "<button hidden id=\"issue" + issue.id + "-difficulty-btn\" value=\"" + issue.difficulty + "\"></button>" +
        "<div id=\"issue" + issue.id + "-difficulty\">" +
        "<h6>Difficulté :" +
        "<span class=\"label label-default\"> " + issue.difficulty + "</span>" +
        "</h6>" +
        "</div>" +
        "<div class=\"progress\" >" +
        "<div id=\"progress-done-" + issueId + "\" class=\"progress-bar progress-bar-striped progress-bar-animated bg-success\"></div>" +
        "<div id=\"progress-ip-" + issueId + "\" class=\"progress-bar progress-bar-striped progress-bar-animated bg-warning\"></div>" +
        "<div id=\"progress-todo-" + issueId + "\" class=\"progress-bar progress-bar-striped progress-bar-animated bg-danger\"></div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>";

    let pBDone = document.getElementById("progress-done-" + issueId);
    let pBIP = document.getElementById("progress-ip-" + issueId);
    let pBToDo = document.getElementById("progress-todo-" + issueId);

    const donePercentage = progressBarWidth(issue, "done");
    const inProgressPercentage = progressBarWidth(issue, "in progress");
    const todoPercentage = progressBarWidth(issue, "todo");

    fillProgressBar(pBDone, donePercentage);
    fillProgressBar(pBIP, inProgressPercentage);
    fillProgressBar(pBToDo, todoPercentage);
}

/**
 * @param {*} progressBar : the progressbar which should be animated
 * @param {*} percentage : its corresponding percentage */
function fillProgressBar(progressBar, percentage) {
    progressBar.style = "width:" + percentage + "%";
    progressBar.innerHTML = percentage + "%";
}

function progressBarWidth(issue, status) {
    const tasks = issue.tasks;
    const nbOfTasks = tasks.length;
    let nbOfDoneTasks = 0;
    for (let i = 0; i < nbOfTasks; i++) {
        if (tasks[i].status === status) {
            nbOfDoneTasks += 1;
        }
    }
    if (nbOfTasks > 0)
        return nbOfDoneTasks / nbOfTasks * 100;
    else {
        return 0;
    }
}

/**
 * This functions fills the modal with an issue's details when its edit mode
 * is opened
 * @param {*} value : The id of the issue which should be displayed in the modal */
function fillModal(value) {
    let name = document.getElementById(value + "-name").textContent;
    let description = document.getElementById(value + "-description").innerHTML;
    let priority = document.getElementById(value + "-priority-btn").value;
    let difficulty = document.getElementById(value + "-difficulty-btn").value;

    document.getElementById("modal-id").value = value;
    document.getElementById("modal-nom").value = name;
    document.getElementById("modal-description").value = description;
    document.getElementById("modal-priority").value = priority;
    document.getElementById("modal-difficulty").value = difficulty;
    document.getElementById("modal-mode").value = "update";

    $("#modal").modal("show");
}

/**
 * Empties the modal fields. */
function emptyModal() {
    document.getElementById("modal-id").value = 'issue';
    document.getElementById("modal-nom").value = '';
    document.getElementById("modal-description").value = '';
    document.getElementById("modal-priority").value = 'low';
    document.getElementById("modal-difficulty").value = 'easy';
    document.getElementById("modal-mode").value = "create";

    $("#modal").modal("show");
}

/**
 * Creates an issue and adds it to the page. */
function createIssue() {
    const nom = document.getElementById("modal-nom").value;
    const description = document.getElementById("modal-description").value;
    const priority = document.getElementById("modal-priority").value;
    const difficulty = document.getElementById("modal-difficulty").value;

    let jsonData = {
        "name": nom,
        "description": description,
        "priority": priority,
        "difficulty": difficulty,
        "status": "done",
        "project": projectId
    };

    sendAjax("/api/issue", 'POST', JSON.stringify(jsonData)).then(res => {
        let issue = res;
        let issuesList = document.getElementById("issues");
        displayIssue(issuesList, issue);

        const edit_btn = document.getElementById("edit-el-" + issue.id);
        edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); })
        const delete_btn = document.getElementById("delete-el-" + issue.id);
        delete_btn.addEventListener("click", function () { deleteIssue(delete_btn.value); })
        $("#modal").modal("hide");
    })
        .catch(() => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}

/**
 * This function deletes an issue and removes it from the page
 * @param {*} us : the issue which must be deleted */
function deleteIssue(us) {
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const usId = us.substring(5);
        sendAjax("/api/issue/" + usId, 'DELETE').then(() => {
            let deletedProjectBlock = document.getElementById("issue-block-" + usId);
            deletedProjectBlock.parentNode.removeChild(deletedProjectBlock);
        })
            .catch(() => {
                $(".err-msg").fadeIn();
                $(".spinner-border").fadeOut();
            })
    }
}

/**
 * This function updates an issue with the information in the modal
 * and refreshes the details already displayed in the page. */
function updateIssue() {
    const usId = document.getElementById("modal-id").value.substring(5);
    const nom = document.getElementById("modal-nom").value;
    const description = document.getElementById("modal-description").value;
    const priority = document.getElementById("modal-priority").value;
    const difficulty = document.getElementById("modal-difficulty").value;

    let jsonData = {
        "name": nom,
        "description": description,
        "priority": priority,
        "difficulty": difficulty
    }

    sendAjax("/api/issue/" + usId, 'PUT', JSON.stringify(jsonData)).then(() => {
        document.getElementById("issue" + usId + "-name").innerHTML = "<h4><strong>" + nom + "</strong></h4>";
        document.getElementById("issue" + usId + "-description").innerHTML = description;
        document.getElementById("issue" + usId + "-priority-btn").value = priority;
        document.getElementById("issue" + usId + "-priority").innerHTML = "<h6>Priorité :" +
            "<span class=\"label label-default\">" + priority + " </span>" +
            "</h6>";
        document.getElementById("issue" + usId + "-difficulty-btn").value = difficulty;
        document.getElementById("issue" + usId + "-difficulty").innerHTML = "<h6>Difficulté :" +
            "<span class=\"label label-default\">" + difficulty + " </span>" +
            "</h6>";
        $("#modal").modal("hide");
    })
        .catch(() => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}