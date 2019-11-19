/*
const projectId = localStorage.getItem("project"); 
*/

const projectId = 1;

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
        let issues = JSON.parse(res);
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
        let issues = Object.values(sprint.issues);

        for (let i = 0; i < issues.length; i++) {
            let dependantIssue = issues[i];
            let issueName = document.createElement("code");
            issueName.innerHTML += dependantIssue.name;
            issuesBlock.appendChild(issueName);
            let hiddenInput = document.createElement("button");
            hiddenInput.hidden = true;

            hiddenInput.classList.add("S" + sprint.id + "-hiddenIds");
            hiddenInput.id = sprint.id + "-" + i;
            hiddenInput.value = "u" + dependantIssue.id;
            issuesBlock.appendChild(hiddenInput);
        }

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

    let sprintBlock = document.createElement("div");
    sprintBlock.id = "sprint-block-" + sprint.id;
    sprintBlock.classList.add("col-4");
    sprintsList.appendChild(sprintBlock);

    sprintBlock.innerHTML +=
        "<div class=\"sprint\">\n" +
        "<div><span class=\"fa fa-pushpin logo-small\"></span></div>\n" +
        "<div id=\"sprint" + sprint.id + "-dates\"><h4>" + startDate + " à " + endDate + "</h4></div>\n" +
        "<button hidden id=\"sprint" + sprint.id + "-start\" value=\"" + startDate + "\"></button>" +
        "<button hidden id=\"sprint" + sprint.id + "-end\" value=\"" + endDate + "\"></button>" +
        "<div class=\"sprint-issues\" id=\"S" + sprint.id + "-issues\">\n" +
        "</div>\n" +
        "<div class=\"sprint-block\"><button id=\"edit-el-" + sprint.id + "\" class=\"btn btn-warning btn-block edit-el\" value=\"sprint" + sprint.id + "\">" +
        "<span class=\"fa fa-edit\"></span>\n" +
        "</button>\n" +
        "</div>\n" +
        "<div class=\"sprint-block\"><button id=\"delete-el-" + sprint.id + "\" class=\"btn btn-danger btn-block delete-el\" value=\"sprint" + sprint.id + "\">" +
        "<span class=\"fa fa-trash\"></span></button>" +
        "</div>\n" +
        "</div>\n";

    let issuesBlock = document.getElementById("S" + sprint.id + "-issues");
    for (let i = 0; i < sprint.issues.length; i++) {
        let dependantIssue = sprint.issues[i];
        let issueName = document.createElement("code");
        issueName.innerHTML += dependantIssue.name;
        issuesBlock.appendChild(issueName);
        let hiddenInput = document.createElement("button");
        hiddenInput.hidden = true;

        hiddenInput.classList.add("S" + sprint.id + "-hiddenIds");
        hiddenInput.id = sprint.id + "-" + i;
        hiddenInput.value = "u" + dependantIssue.id;
        issuesBlock.appendChild(hiddenInput);
    }
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
