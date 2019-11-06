
var xmlhttp = new XMLHttpRequest();
const url = "http://localhost:8000/issues/1";

//Populates the lists with their corresponding issues
xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        const issues = JSON.parse(this.responseText);
        let todoListEl = document.getElementById("to-do-issues");
        let inProgressListEl = document.getElementById("in-progress-issues");
        let doneListEl = document.getElementById("done-issues");

        for (let i = 0; i < issues.length; i++) {
            const issue = issues[i];
            if (issue.status === 'todo')
                fillListWithIssue(todoListEl, issue);
            else if (issue.status === 'in progress')
                fillListWithIssue(inProgressListEl, issue);
            else
                fillListWithIssue(doneListEl, issue);
        }
        var edit_el_btns = document.getElementsByClassName("edit-el");
        var add_el_btns = document.getElementsByClassName("add-el");
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
            let delete_btn = delete_el_btns[i];
            delete_btn.addEventListener("click", function () { deleteIssue(delete_btn.value); });
        }
    }


};

xmlhttp.open("GET", url, true);
xmlhttp.setRequestHeader("Content-Type", "application/json");
xmlhttp.setRequestHeader('Access-Control-Allow-Origin', '*');
xmlhttp.send();


function fillListWithIssue(list, issue) {
    list.innerHTML +=
        "<div id=\"issue-block-" + issue.id + "\" class=\"row\">\n" +
        "<div class=\"col-sm-8 issue-block\">\n" +
        "<a href=\"#us" + issue.id + "\" class=\"btn btn-default btn-block\" data-toggle=\"collapse\"\>" +
        "<span class=\"badge\">" + issue.id + "</span >   " + issue.name + "</a > \n" +
        "</div>\n" +
        "<div class=\"col-sm-2 issue-block\"><button class=\"btn btn-warning btn-block edit-el\" value=\"us" + issue.id + "\">" +
        "<span class=\"glyphicon glyphicon-pencil\"></span>\n" +
        "</button>\n" +
        "</div>\n" +
        "<div class=\"col-sm-2 issue-block\"><button class=\"btn btn-danger btn-block delete-el\" value=\"us" + issue.id + "\">" +
        "<span class=\"glyphicon glyphicon-trash\"></span></button>" +
        "</div>\n" +
        "</div>\n" +
        "<div id=\"details-block-" + issue.id + "\" class=\"row\">" +
        "<div id=\"us" + issue.id + "\" class=\"collapse well text-justify\">\n" +
        "<div id=\"us" + issue.id + "-name\"><h4><strong>" + issue.name + "</strong></h4></div>\n" +
        "<div id=\"us" + issue.id + "-description\">" + issue.description + "</div>\n" +
        "<div id=\"us" + issue.id + "-priority\">\n" +
        "<button hidden id=\"us" + issue.id + "-priority-btn\" value=\"" + issue.priority + "\"></button>" +
        "<h6>Priorité :" +
        "<span class=\"label label-default\">" + issue.priority + " </span>" +
        "</h6>" +
        "</div >\n" +
        "<div id=\"us" + issue.id + "-difficulty\">" +
        "<button hidden id=\"us" + issue.id + "-difficulty-btn\" value=\"" + issue.difficulty + "\"></button>" +
        "<h6>Difficulté :" +
        "<span class=\"label label-default\">" + issue.difficulty + "</span>" +
        "</h6>" +
        "</div>\n" +
        "</div>";

}



function fillModal(value) {
    let name = document.getElementById(value + "-name").textContent;
    console.log(name);
    let description = document.getElementById(value + "-description").innerHTML;
    console.log(description);
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
const modalConfirmBtn = document.getElementById("modal-mode");
modalConfirmBtn.addEventListener("click", function () {
    if (modalConfirmBtn.value === "create") createIssue();
    else updateIssue();
});

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
        "project": 1
    }

    const createUrl = "http://localhost:8000/issue";

    let xmlhttp = new XMLHttpRequest();   // new HttpRequest instance 
    xmlhttp.open("POST", createUrl);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            console.log("ici");
            console.log(this.responseText);
            $("#modal").modal("hide");
           
        }
    };
    xmlhttp.send(JSON.stringify(jsonData));


}

function deleteIssue(us) {
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const usId = us.substring(2);

        const deleteUrl = "http://localhost:8000/issue/" + usId;

        let xmlhttp = new XMLHttpRequest();   // new HttpRequest instance 
        xmlhttp.open("DELETE", deleteUrl);
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    let deletedIssueBlock = document.getElementById("issue-block-" + usId);
                    deletedIssueBlock.parentNode.removeChild(deletedIssueBlock);
                    let deletedIssueDetails = document.getElementById("details-block-" + usId);
                    deletedIssueDetails.parentNode.removeChild(deletedIssueDetails);
                }
            }
        };
        xmlhttp.send();
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

    const updateUrl = "http://localhost:8000/issue/" + usId;

    let xmlhttp = new XMLHttpRequest();   // new HttpRequest instance 
    xmlhttp.open("PUT", updateUrl);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            console.log("ici");
            console.log(this.responseText);
            $("#modal").modal("hide");
            location.reload();
        }
    };
    xmlhttp.send(JSON.stringify(jsonData));



}