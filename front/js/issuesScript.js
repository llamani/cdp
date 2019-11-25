const projectId = JSON.parse(localStorage.getItem("user_current_project")).id;

$(document).ready(function () {
    startUp();
    fillWithIssues();
    setDragAndDrop();
});

function startUp() {
    const add_el_btns = document.getElementsByClassName("add-el");

    for (let i = 0; i < add_el_btns.length; i++) {
        let add_btn = add_el_btns[i];
        add_btn.addEventListener("click", function () { emptyModal(add_btn.value); });
    }

    const modalConfirmBtn = document.getElementById("modal-mode");
    modalConfirmBtn.addEventListener("click", function () {
        if (modalConfirmBtn.value === "create") createIssue();
        else updateIssue();
    });
}


function fillWithIssues() {

    sendAjax("/api/issues/" + projectId).then(res => {
        let issues = res;
        for (let i = 0; i < issues.length; i++) {
            let issue = issues[i];
            fillListWithIssue(getListAccordingToStatus(issue.status), issue);
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
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })

}

function setDragAndDrop(){
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

function updateStatus(issue, new_status){
    let id = issue.substring(5);
    let status = new_status;
    if (new_status === "to-do"){
        status = "todo";
    }
    else if(new_status = "in-progress"){
        status = status.replace("-", " ");
    }
    let jsonData = {
        status : status
    }

    console.log("issue : " + issue);
    console.log("status : " + status);

    sendAjax("/api/slide-issue/" + id, 'PUT', JSON.stringify(jsonData))
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
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

function fillListWithIssue(list, issue) {
    list.innerHTML +=
        "<div class=\"draggableblock\" id=\"drag-" + issue.id + "\">" +
        "<div id=\"issue-block-" + issue.id + "\" class=\"row\">\n" +
        "<div id=\"element-block-title-" + issue.id + "\" class=\"col-sm-8 issue-block\">\n" +
        "<a href=\"#us" + issue.id + "\" class=\"btn btn-default btn-block\" data-toggle=\"collapse\"\>" +
        "<span class=\"badge\">" + issue.id + "</span >   " + issue.name + "</a > \n" +
        "</div>\n" +
        "<div class=\"col-sm-2 element-block\"><button id=\"edit-el-" + issue.id + "\" class=\"btn btn-warning btn-block edit-el\" value=\"us" + issue.id + "\">" +
        "<span class=\"fa fa-edit\"></span>\n" +
        "</button>\n" +
        "</div>\n" +
        "<div class=\"col-sm-2 element-block\"><button id=\"delete-el-" + issue.id + "\" class=\"btn btn-danger btn-block delete-el\" value=\"us" + issue.id + "\">" +
        "<span class=\"fa fa-trash\"></span></button>" +
        "</div>\n" +
        "</div>\n" +
        "<div id=\"details-block-" + issue.id + "\" class=\"row\">" +
        "<div id=\"us" + issue.id + "\" class=\"collapse well text-justify\">\n" +
        "<div id=\"us" + issue.id + "-name\"><h4><strong>" + issue.name + "</strong></h4></div>\n" +
        "<div id=\"us" + issue.id + "-description\">" + issue.description + "</div>\n" +
        "<button hidden id=\"us" + issue.id + "-priority-btn\" value=\"" + issue.priority + "\"></button>" +
        "<div id=\"us" + issue.id + "-priority\">\n" +
        "<h6>Priorité :" +
        "<span class=\"label label-default\">" + issue.priority + " </span>" +
        "</h6>" +
        "</div >\n" +
        "<button hidden id=\"us" + issue.id + "-difficulty-btn\" value=\"" + issue.difficulty + "\"></button>" +
        "<div id=\"us" + issue.id + "-difficulty\">" +
        "<h6>Difficulté :" +
        "<span class=\"label label-default\">" + issue.difficulty + "</span>" +
        "</h6>" +
        "</div>\n" +
        "</div>" +
        "</div>";

        setDragAndDrop();

}



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

function emptyModal(status) {
    document.getElementById("modal-id").value = 'us';
    document.getElementById("modal-nom").value = '';
    document.getElementById("modal-description").value = '';
    document.getElementById("modal-priority").value = 'low';
    document.getElementById("modal-difficulty").value = 'easy';
    document.getElementById("modal-status").value = status;
    document.getElementById("modal-mode").value = "create";

    $("#modal").modal("show");
}

function createIssue() {
    const nom = document.getElementById("modal-nom").value;
    const description = document.getElementById("modal-description").value;
    const priority = document.getElementById("modal-priority").value;
    const difficulty = document.getElementById("modal-difficulty").value;
    const status = document.getElementById("modal-status").value;

    let jsonData = {
        "name": nom,
        "description": description,
        "priority": priority,
        "difficulty": difficulty,
        "status": status,
        "project": projectId
    };

    sendAjax("/api/issue", 'POST', JSON.stringify(jsonData)).then(res => {
        let issue = res;
        const node = document.createElement("div");
        fillListWithIssue(node, issue);
        getListAccordingToStatus(issue.status).appendChild(node);

        const edit_btn = document.getElementById("edit-el-" + issue.id);
        edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); })
        const delete_btn = document.getElementById("delete-el-" + issue.id);
        delete_btn.addEventListener("click", function () { deleteIssue(delete_btn.value); })
        $("#modal").modal("hide");
    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}


function deleteIssue(us) {
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const usId = us.substring(2);
        sendAjax("/api/issue/" + usId, 'DELETE').then(res => {
            let deletedIssueBlock = document.getElementById("issue-block-" + usId);
            deletedIssueBlock.parentNode.removeChild(deletedIssueBlock);
            let deletedIssueDetails = document.getElementById("details-block-" + usId);
            deletedIssueDetails.parentNode.removeChild(deletedIssueDetails);
        })
            .catch(e => {
                $(".err-msg").fadeIn();
                $(".spinner-border").fadeOut();
            })
    }
}


function updateIssue() {
    const usId = document.getElementById("modal-id").value.substring(2);
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

    sendAjax("/api/issue/" + usId, 'PUT', JSON.stringify(jsonData)).then(res => {
        document.getElementById("element-block-title-" + usId).getElementsByTagName("a")[0].innerHTML = "<span class=\"badge\"> us" + usId + "</span >   " + nom;
        document.getElementById("us" + usId + "-name").innerHTML = "<h4><strong>" + nom + "</strong></h4>";
        document.getElementById("us" + usId + "-description").innerHTML = description;
        document.getElementById("us" + usId + "-priority-btn").value = priority;
        document.getElementById("us" + usId + "-priority").innerHTML = "<h6>Priorité :" +
            "<span class=\"label label-default\">" + priority + " </span>" +
            "</h6>";
        document.getElementById("us" + usId + "-difficulty-btn").value = difficulty;
        document.getElementById("us" + usId + "-difficulty").innerHTML = "<h6>Difficulté :" +
            "<span class=\"label label-default\">" + difficulty + " </span>" +
            "</h6>";
        $("#modal").modal("hide");
    })
        .catch(e => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}