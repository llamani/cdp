const projectId = JSON.parse(localStorage.getItem("user_current_project")).id;

$(document).ready(function () {
    fillModalWithIssueOptions();
    document.getElementById("add-btn").addEventListener("click", function () { emptyModal(); });
    fillWithSprints();
    const modalConfirmBtn = document.getElementById("modal-mode");
    modalConfirmBtn.addEventListener("click", function () {
        if (modalConfirmBtn.value === "create") createSprint();
        else updateSprint();
    });
});


function fillModalWithIssueOptions() {
    let modalOptions = document.getElementById("modal-dependant-issues");

    sendAjax("/api/issues/" + projectId).then(res => {
        let issues = res;
        for (let i = 0; i < issues.length; i++) {

            issue = issues[i];
            optionNode = document.createElement("option");
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
    return false;
}

function emptyModal() {
    let modalOptions = document.getElementById("modal-dependant-issues").options;

    for (let i = 0; i < modalOptions.length; i++) {
        modalOptions[i].selected = false;
    }
    document.getElementById("modal-mode").value = "create";
    $("#modal").modal("show");
}

function fillWithSprints() {
    sendAjax("/api/sprints/" + projectId).then(res => {
        let sprints = res;

        let sprintsList = document.getElementById("sprints");

        for (let i = 0; i < sprints.length; i++) {
            displaySprint(sprintsList, sprints[i]);
        }

        const edit_el_btns = document.getElementsByClassName("edit-el");
        const delete_el_btns = document.getElementsByClassName("delete-el");

        for (let i = 0; i < edit_el_btns.length; i++) {
            let edit_btn = edit_el_btns[i];
            edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); });
        }

        for (let i = 0; i < delete_el_btns.length; i++) {

            let delete_btn = delete_el_btns[i];
            delete_btn.addEventListener("click", function () { deleteSprint(delete_btn.value); });
        }
    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })

}

function fillModal(value) {
    const id = value.substring(6);
    document.getElementById("modal-id").value = "S" + id;
    let startDate = document.getElementById("sprint" + id + "-start").value;
    let endDate = document.getElementById("sprint" + id + "-end").value;

    $('#startdate_datepicker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    }).datepicker("update", startDate);

    $('#enddate_datepicker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    }).datepicker("update", endDate);

    let selectedValues = getDependantIssuesFromBlock(id);

    let modalOptions = document.getElementById("modal-dependant-issues").options;
    for (let i = 0; i < modalOptions.length; i++) {
        let option = modalOptions[i];
        if (selectedValues.includes(option.value))
            option.selected = true;
        else
            option.selected = false;
    }
    $("#modal-dependant-issues").selectpicker("refresh");
    document.getElementById("modal-mode").value = "update";

    $("#modal").modal("show");
}

function updateSprint() {
    let id = document.getElementById("modal-id").value.substring(1);
    let jsonData = getJsonDataFromModal();

    sendAjax("/api/sprint/" + id, 'PUT', JSON.stringify(jsonData)).then(res => {
        let sprint = res;
        const startDate = extractDate(sprint.startDate);
        const endDate = extractDate(sprint.endDate);

        document.getElementById("sprint" + sprint.id + "-dates").innerHTML = "<h4>" + startDate + " à " + endDate + "</h4>";
        document.getElementById("sprint" + sprint.id + "-start").value = startDate;
        document.getElementById("sprint" + sprint.id + "-end").value = endDate;

        let issuesBlock = document.getElementById("S" + sprint.id + "-issues");
        issuesBlock.querySelectorAll('*').forEach(n => n.remove());
        fillWithSprintIssues(sprint.id, Object.values(sprint.issues));

        $("#modal").modal("hide");

    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })

}


function displaySprint(sprintsList, sprint) {
    const startDate = extractDate(sprint.startDate);
    const endDate = extractDate(sprint.endDate);
    const sprintId = sprint.id;

    let sprintBlock = document.createElement("div");
    sprintBlock.id = "sprint-block-" + sprint.id;
    sprintBlock.classList.add("row");
    sprintsList.appendChild(sprintBlock);

    sprintBlock.innerHTML +=
        "<div class=\"col-8\" id=\"accordion-" + sprintId + "\">" +
        "<a data-toggle=\"collapse\" data-target=\"#collapse-" + sprintId + "\" role=\"button\" aria-expanded=\"false\" aria-controls=\"collapse-" + sprintId + "\">" +
        "<div id=\"sprint" + sprintId + "-dates\"><h4>" + startDate + " à " + endDate + "</h4></div>\n" +
        "<button hidden id=\"sprint" + sprintId + "-start\" value=\"" + startDate + "\"></button>" +
        "<button hidden id=\"sprint" + sprintId + "-end\" value=\"" + endDate + "\"></button>" +
        "</a>" +
        "</div>" +
        "<div class=\"col-2\">" +
        "<button id=\"edit-el-" + sprintId + "\" class=\"btn btn-warning btn-block edit-el\" value=\"sprint" + sprintId + "\">" +
        "<span class=\"fa fa-edit\"></span>\n" +
        "</button>\n" +
        "</div>" +
        "<div class=\"col-2\">" +
        "<button id=\"delete-el-" + sprintId + "\" class=\"btn btn-danger btn-block delete-el\" value=\"sprint" + sprintId + "\">" +
        "<span class=\"fa fa-trash\"></span></button>" +
        "</div>" +
        "<div id=\"collapse-" + sprintId + "\" class=\"collapse col-8\" aria-labelledby=\"sprint" + sprintId + "\" >" +
        "<div class=\"card card-body\">" +
        "<div class=\"sprint-issues\" id=\"S" + sprintId + "-issues\">\n" +
        "</div>" +
        "<div class=\"progress\" >" +
        "<div id=\"progress-done-" + sprintId + "\" class=\"progress-bar progress-bar-striped progress-bar-animated bg-success\"></div>" +
        "<div id=\"progress-ip-" + sprintId + "\" class=\"progress-bar progress-bar-striped progress-bar-animated bg-warning\"></div>" +
        "<div id=\"progress-todo-" + sprintId + "\" class=\"progress-bar progress-bar-striped progress-bar-animated bg-danger\"></div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>";
    fillWithSprintIssues(sprintId, sprint.issues);

    let pBDone = document.getElementById("progress-done-" + sprintId);
    const donePercentage = progressBarWidth(sprint, "done");
    fillProgressBar(pBDone, donePercentage);


}
function fillProgressBar(progressBar, percentage) {
    progressBar.style = "width:" + percentage + "%";
    progressBar.innerHTML = percentage + "%";
}

function progressBarWidth(sprint, status) {
    const issues = sprint.issues;
    const nbOfIssues = issues.length;
    let nbOfDoneIssues = 0;
    for (let i = 0; i < nbOfIssues; i++) {
        const issue = issues[i];
        const issueTasks = issue.tasks;
        let nbOfDoneTasks = 0;
        for (let j = 0; j < issueTasks.length; j++) {
            if (issueTasks[j].status === status) {
                nbOfDoneTasks++;
            }
        }
        if (nbOfDoneTasks == issueTasks.length) {
            nbOfDoneIssues++;
        }
    }
    if (nbOfDoneIssues > 0)
        return nbOfDoneIssues / nbOfIssues * 100;
    else {
        return 0;
    }
}

function fillWithSprintIssues(sprintId, issuesList) {
    let issuesBlock = document.getElementById("S" + sprintId + "-issues");
    let title = document.createElement("h5");
    title.innerHTML = "Issues du sprint : ";
    issuesBlock.appendChild(title);
    let ul = document.createElement("ul");
    for (let i = 0; i < issuesList.length; i++) {
        let dependantIssue = issuesList[i];
        let issueName = document.createElement("li");
        issueName.innerHTML += dependantIssue.name;
        ul.appendChild(issueName);
        let hiddenInput = document.createElement("button");
        hiddenInput.hidden = true;
        hiddenInput.classList.add("S" + sprintId + "-hiddenIds");
        hiddenInput.id = sprintId + "-" + i;
        hiddenInput.value = "u" + dependantIssue.id;
        ul.appendChild(hiddenInput);
    }
    issuesBlock.appendChild(ul);
}
function extractDate(date) {
    const formattedDate = date.substring(8, 10) + "-" + date.substring(5, 7) + "-" + date.substring(0, 4);
    return formattedDate;
}


function createSprint() {
    let jsonData = getJsonDataFromModal();

    sendAjax("/api/sprint", 'POST', JSON.stringify(jsonData)).then(res => {
        let sprint = res;
        displaySprint(document.getElementById("sprints"), sprint);

        const edit_btn = document.getElementById("edit-el-" + sprint.id);
        edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); })
        const delete_btn = document.getElementById("delete-el-" + sprint.id);
        delete_btn.addEventListener("click", function () { deleteSprint(delete_btn.value); })
        $("#modal").modal("hide");
    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })

}

function getJsonDataFromModal() {
    $("#modal-dependant-issues").selectpicker("refresh");
    const start = document.getElementById("startdate_datepicker").value;
    const end = document.getElementById("enddate_datepicker").value;
    const dependantIssues = getDependantIssuesFromModal();

    let jsonData = {
        "startDate": start,
        "endDate": end,
        "issue": dependantIssues,
        "project": projectId

    }

    return jsonData;
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

function deleteSprint(sprint) {
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const sprintId = sprint.substring(6);
        sendAjax("/api/sprint/" + sprintId, 'DELETE').then(res => {
            let deletedSprintBlock = document.getElementById("sprint-block-" + sprintId);
            deletedSprintBlock.parentNode.removeChild(deletedSprintBlock);
        })
            .catch(e => {
                $(".err-msg").fadeIn();
                $(".spinner-border").fadeOut();
            })
    }
}

function getDependantIssuesFromBlock(id) {
    let classes = document.getElementsByClassName("S" + id + "-hiddenIds");
    let issues = [];
    for (let i = 0; i < classes.length; i++) {
        issues.push(classes[i].value);
    }
    return issues;
}
