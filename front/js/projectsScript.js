$(document).ready(function () {
    startUp();
    fillWithProjects();
});

/**
 * Attaches the event listener to the add buttons and the modal confirm button. */
function startUp() {
    document.getElementById("add-btn").addEventListener("click", function () { emptyModal(); });
    const modalConfirmBtn = document.getElementById("modal-mode");
    modalConfirmBtn.addEventListener("click", function () {
        if (modalConfirmBtn.value === "create") createProject();
        else updateProject();
    });
    //Adds all the website members to the "Members" section of the project modal
    //so the creator can add them to the project
    fillWithUserOptions();
}

/**
 * Adds projects to the page and attaches the event listeners to their
 * corresponding edit and delete buttons. */
function fillWithProjects() {
    let projects = JSON.parse(localStorage.getItem("user_all_projects"));
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
}

/** 
 * @param {*} node : the html node where the project should be inserted
 * @param {*} issue : the project which should be displayed */
function displayProject(node, project) {
    const name = project.name;
    const description = project.description;
    const projectId = project.id;
    let projectBlock = document.createElement("div");
    projectBlock.id = "project-block-" + project.id;
    projectBlock.classList.add("row");
    node.appendChild(projectBlock);

    projectBlock.innerHTML +=

        "<div class=\"col-8\" id=\"accordion-" + projectId + "\">" +
        "<a data-toggle=\"collapse\" data-target=\"#collapse-" + projectId + "\" role=\"button\" aria-expanded=\"false\" aria-controls=\"collapse-" + project.id + "\">" +
        "<div id=\"project" + projectId + "-name\" class=\"text-center\"><h4>" + name + "</h4></div>" +
        "</a>" +
        "</div>" +
        "<div class=\"col-2\">" +
        "<button id=\"edit-el-" + projectId + "\" class=\"btn btn-warning btn-block edit-el\" value=\"project" + projectId + "\">" +
        "<span class=\"fa fa-edit\"></span>\n" +
        "</button>\n" +
        "</div>" +
        "<div class=\"col-2\">" +
        "<button id=\"delete-el-" + projectId + "\" class=\"btn btn-danger btn-block delete-el\" value=\"project" + projectId + "\">" +
        "<span class=\"fa fa-trash\"></span></button>" +
        "</div>" +
        "<div id=\"collapse-" + projectId + "\" class=\"collapse col-8\" aria-labelledby=\"project" + projectId + "\" >" +
        "<div class=\"card card-body\">" +
        "<div id=\"project" + projectId + "-description\">" + description + "</div>" +
        "<hr>" +
        "<div id=\"project" + projectId + "-members\"></div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>";

    fillProjectWithMembers(projectId);
}

/**
 * Displays members of a project
 * @param {*} projectId */
function fillProjectWithMembers(projectId) {
    sendAjax("/api/members/" + projectId).then(res => {
        let members = res;
        fillProjectWithMembersHtml(members, projectId);
    });
}

/**
 * Creates the html of the members of a project
 * @param {*} members 
 * @param {*} projectId */
function fillProjectWithMembersHtml(members, projectId) {
    let membersBlock = document.getElementById("project" + projectId + "-members");
    let title = document.createElement("h5");
    title.innerHTML = "Membres du projet : ";
    membersBlock.appendChild(title);
    let ul = document.createElement("ul");
    for (let i = 0; i < members.length; i++) {
        let member = members[i];
        let memberName = document.createElement("li");
        memberName.innerHTML += member.user.name;
        ul.appendChild(memberName);
        let hiddenInput = document.createElement("button");
        hiddenInput.hidden = true;
        hiddenInput.classList.add("members" + projectId + "-hiddenIds");
        hiddenInput.id = projectId + "-" + i;
        hiddenInput.value = "m" + member.user.id;
        ul.appendChild(hiddenInput);
    }
    membersBlock.appendChild(ul);
}

/**
 * Selects the existing members of a project in the modal
 * when it's opened in the edit mode. */
function fillWithUserOptions() {
    let modalOptions = document.getElementById("modal-users");

    sendAjax("/users").then(res => {
        let users = res;
        for (let i = 0; i < users.length; i++) {
            let user = users[i];
            let optionNode = document.createElement("option");
            optionNode.innerHTML = user.name;
            optionNode.value = "m" + user.id;
            modalOptions.appendChild(optionNode);
            $("#modal-users").selectpicker("refresh");
        }
    })
}

/**
 * Creates a new project and displays it
 * on the page. */
function createProject() {
    let jsonData = getJsonDataFromModal();

    sendAjax("/api/project", 'POST', JSON.stringify(jsonData))
        .then(res => {
            let project = res;
            displayProject(document.getElementById("projects"), project);

            const edit_btn = document.getElementById("edit-el-" + project.id);
            edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); })
            const delete_btn = document.getElementById("delete-el-" + project.id);
            delete_btn.addEventListener("click", function () { deleteProject(delete_btn.value); })
            $("#modal").modal("hide");

            let all_projects = JSON.parse(localStorage.getItem('user_all_projects'));
            all_projects.push(project);
            localStorage.setItem('user_all_projects', JSON.stringify(all_projects));
            displaySidebarProjects()
        })
}

/**
 * Deletes a project and removes it from the page
 * @param {*} value : the project to be deleted */
function deleteProject(value) {
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const id = value.substring(7);
        sendAjax("/api/project/" + id, 'DELETE')
            .then(() => {
                let deletedProjectBlock = document.getElementById("project-block-" + id);
                deletedProjectBlock.parentNode.removeChild(deletedProjectBlock);

                let all_projects = JSON.parse(localStorage.getItem('user_all_projects'));
                const index = all_projects.findIndex(p => parseInt(p.id) === parseInt(id));
                if (index === -1) {
                    console.error("Impossible")
                }
                all_projects.splice(index, 1);
                localStorage.setItem('user_all_projects', JSON.stringify(all_projects));
                if (parseInt(JSON.parse(localStorage.getItem("user_current_project")).id) === parseInt(id)) {
                    if (all_projects.length > 0) {
                        localStorage.setItem('user_current_project', JSON.stringify(all_projects[0]));
                    } else {
                        localStorage.removeItem("user_all_projects");
                        logout();
                    }
                }
                displaySidebarProjects()
            })
    }
}

/**
 * Fills the modal fields with the existing details of the project
 * opened in edit mode
 * @param {*} value : project opened in edit mode */
function fillModal(value) {
    let id = value.substring(7);
    let name = document.getElementById(value + "-name").textContent;
    let description = document.getElementById(value + "-description").innerHTML;

    document.getElementById("id").value = id;
    document.getElementById("name").value = name;
    document.getElementById("description").value = description;
    document.getElementById("modal-mode").value = "update";

    let selectedValues = getUsersFromBlock(id);

    let modalOptions = document.getElementById("modal-users").options;
    for (let i = 0; i < modalOptions.length; i++) {
        let option = modalOptions[i];
        if (selectedValues.includes(option.value))
            option.selected = true;
        else
            option.selected = false;
    }
    $("#modal").modal("show");
}

/**
 * Extracts the members of a project from the html of 
 * its corresponding section in the page
 * @param {*} id : project id */
function getUsersFromBlock(id) {
    let classes = document.getElementsByClassName("members" + id + "-hiddenIds");
    let issues = [];
    for (let i = 0; i < classes.length; i++) {
        console.log("value : " + classes[i].value);
        issues.push(classes[i].value);
    }
    return issues;
}

/**
 * Empties the modal fields. */
function emptyModal() {
    document.getElementById("id").value = 'project';
    document.getElementById("name").value = '';
    document.getElementById("description").value = '';
    document.getElementById("modal-mode").value = "create";

    let modalOptions = document.getElementById("modal-users").options;

    for (let i = 0; i < modalOptions.length; i++) {
        modalOptions[i].selected = false;
    }
    $("#modal").modal("show");
}

/**
 * Updates a project with the information in the modal
 * and refreshes the details already displayed in the page. */
function updateProject() {
    const id = document.getElementById("id").value;
    let jsonData = getJsonDataFromModal();
    sendAjax("/api/project/" + id, 'PUT', JSON.stringify(jsonData))
        .then(res => {
            let project = res;
            document.getElementById("project" + id + "-name").innerHTML = "<h4>" + project.name + "</h4>";
            document.getElementById("project" + id + "-description").innerHTML = project.description;
            $("#modal").modal("hide");

            let all_projects = JSON.parse(localStorage.getItem('user_all_projects'));
            let current_project = JSON.parse(localStorage.getItem('user_current_project'));

            if (parseInt(id) === parseInt(current_project.id)) {
                localStorage.setItem('user_current_project', JSON.stringify(project));
            }
            const index = all_projects.findIndex(p => parseInt(p.id) === parseInt(id));
            if (index === -1) {
                console.error("Impossible");
            }
            all_projects[index] = project;
            localStorage.setItem('user_all_projects', JSON.stringify(all_projects));
            displaySidebarProjects()

            let membersBlock = document.getElementById("project" + id + "-members");
            membersBlock.querySelectorAll('*').forEach(n => n.remove());
            fillProjectWithMembers(id);
        })
}

/**
 * Returns the users selected in the modal. */
function getUsersFromModal() {
    let select = document.getElementById("modal-users");
    let selectedValues = [];
    for (let i = 0; i < select.length; i++) {
        if (select.options[i].selected) {
            let value = select.options[i].value;
            selectedValues.push(value.substring(1));
        }
    }
    return selectedValues;
}

/**
 * Returns the information of the modal fields
 * in json format. */
function getJsonDataFromModal() {
    const nom = document.getElementById("name").value;
    const description = document.getElementById("description").value;
    const users = getUsersFromModal();
    return {
        "name": nom,
        "description": description,
        "users": users
    }
}
