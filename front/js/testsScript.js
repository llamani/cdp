const projectId = JSON.parse(localStorage.getItem("user_current_project")).id;

$(document).ready(function () {
        startUp();
        fillWithTests();
    });

function startUp()
{
    const add_el_btns = document.getElementsByClassName("btn btn-primary add");

    for (let i = 0; i < add_el_btns.length; i++) {
        let add_btn = add_el_btns[i];
        add_btn.addEventListener("click", function () {
                emptyModal(); });
    }

    const modalConfirmBtn = document.getElementById("modal-modal-mode");
    modalConfirmBtn.addEventListener("click", function () {
            if (modalConfirmBtn.value === "create") { createTest();
            } else { updateTest();
            }
        });

    fillModalWithManagerOptions();
}

function fillModalWithManagerOptions()
{
    let modalOptions = document.getElementById("modal-test-managers");
 
    sendAjax("/api/project/" + projectId).then(res => {
        let project = res;
            let users = project.userProjectRelations;
            for(let i = 0; i < users.length; i++){
                let user = users[i].user;
                let optionNode = document.createElement("option");
                optionNode.innerHTML = user.name;
                optionNode.value = user.id;
                modalOptions.appendChild(optionNode);
                $("#modal-test-managers").selectpicker("refresh");
            }
        })
    .catch(() => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}

function fillWithTests()
{
    sendAjax("/api/tests/" + projectId).then(res => {
            let tests = res;
            let testsTable = document.getElementById("tests");
            for (let i = 0; i < tests.length; i++) {
                let test = tests[i];
                displayTest(test, testsTable);
            }
            let edit_el_btns = document.getElementsByClassName("edit-el");
            let delete_el_btns = document.getElementsByClassName("delete-el");
            for (let i = 0; i < edit_el_btns.length; i++) {
                let edit_btn = edit_el_btns[i];
                edit_btn.addEventListener("click", function () {
                        fillModal(edit_btn.value); });
            }
            for (let i = 0; i < delete_el_btns.length; i++) {
                let delete_btn = delete_el_btns[i];
                delete_btn.addEventListener("click", function () {
                        deleteTest(delete_btn.value); });
            }

            let arrow_btns = document.getElementsByClassName("toggle-button");
            for (let i = 0; i < arrow_btns.length; i++) {
                let arrow_btn = arrow_btns[i];
                arrow_btn.addEventListener("click", function () {
                    if (arrow_btn.classList.contains("fa-angle-down")){
                        arrow_btn.classList.remove("fa-angle-down");
                        console.log("oki");
                        arrow_btn.classList.add('fa-angle-up');
                    }
                    else{
                        arrow_btn.classList.remove("fa-angle-up");
                        console.log("doki");
                        arrow_btn.classList.add('fa-angle-down');
                    }    
                });
            }
        })
    .catch(() => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}

function displayTest(test, node)
{
    const date = extractDate(test.testDate);
    let type_select = document.getElementById("modal-type");
    console.log(type_select.options);
    let type = type_select.options[type_select.selectedIndex].text;
    node.innerHTML +=
    "<tr id=\"test-block" + test.id + "\" colspan=\"8\" class=\"accordion-toggle "+ test.status +"\" >" +
    "<th scope=\"row\"><span data-toggle=\"collapse\" data-target=\"#test-data" + test.id + "\" class=\"fas fa-angle-down fa-lg toggle-button\" aria-expanded=\"true\" aria-controls=\"test-data\"></span></th>" +
    "<td id=\"test" + test.id + "-name\" >" + test.name + "</td>" +
    "<td id=\"test" + test.id + "-type\">" + type + "</td>" +
    "<td id=\"test" + test.id + "-date\">" + date + "</td>" +
    "<td id=\"test" + test.id + "-managers\"></td>" +
    "<td id=\"test" + test.id + "-status\">"+
     "<div class=\"btn-group btn-group-sm btn-group-toggle\" role=\"group\" data-toggle=\"buttons\">" +
     "<label id=\"test" + test.id + "-SUCCESS\" class=\"btn btn-secondary\">" +
    "<input class=\"change-status\" value=\"SUCCESS\" type=\"radio\" onchange=\"updateTestStatus(this.value," + test.id + ");\" autocomplete=\"off\"><span title=\"Succès\" class=\"fa fa-check\"></span></button>" +
     "</label>" +
     "<label  id=\"test" + test.id + "-UNKNOWN\" class=\"btn btn-secondary\">" +
    "<input class=\"change-status\" value=\"UNKNOWN\" type=\"radio\" onchange=\"updateTestStatus(this.value," + test.id + ");\" autocomplete=\"off\"><span title=\"Indéterminé\" class=\"fa fa-question-circle\"></span></button>" +
     "</label>" +
     "<label id=\"test" + test.id + "-FAIL\" class=\"btn btn-secondary\">" +
    "<input class=\"change-status\" value=\"FAIL\" type=\"radio\" onchange=\"updateTestStatus(this.value," + test.id + ");\" autocomplete=\"off\"><span title=\"Échec\" class=\"fa fa-exclamation-triangle\"></span></button>" +
     "</label>" +
    "</div>" +
    "</td>" +
    "<td>" +
    "<button id=\"edit-el-" + test.id + "\" class=\"btn btn-warning btn-block edit-el\" value=\"test" + test.id + "\">" +
    "<span class=\"fa fa-edit\"></span>\n" +
    "</td>" +
    "<td>" +
    "<button id=\"delete-el-" + test.id + "\" class=\"btn btn-danger btn-block delete-el\" value=\"test" + test.id + "\">" +
        "<span class=\"fa fa-trash\"></span></button>" +
    "</td>" +
    "</tr>" +
    "<tr id=\"test-hiddenblock" + test.id + "\">" +
    "<td  colspan=\"8\" class= \"hiddenRow\">" +
        "<div class=\"accordian-body collapse p-3\" id=\"test-data" + test.id + "\">" +
            "<p>Description :"+ "<span id=\"test" + test.id + "-description\">" + test.description + "</span></p>" +
            "<p>Résultat attendu :" + "<span id=\"test" + test.id + "-expectedResult\">" + test.expectedResult + "</span></p>" +
            "<p>Résultat obtenu :" + "<span id=\"test" + test.id + "-obtainedResult\">" + test.obtainedResult + "</span></p>" +
        "</div>" +
    "</td>" +
    "</tr>";

    let status_button = document.getElementById("test" + test.id + "-" + test.status);
    status_button.classList.add('active');

    let arrow_btns = document.getElementsByClassName("toggle-button");
    let arrow_btn = arrow_btns[arrow_btns.length - 1];
    arrow_btn.addEventListener("click", function () {
        if (arrow_btn.classList.contains("fa-angle-down")){
            arrow_btn.classList.remove("fa-angle-down");
            console.log("oki");
            arrow_btn.classList.add('fa-angle-up');
        }
        else{
            arrow_btn.classList.remove("fa-angle-up");
            console.log("doki");
            arrow_btn.classList.add('fa-angle-down');
        }    
    });


    let managersBlock = document.getElementById("test" + test.id + "-managers");
    for (let i = 0; i < test.testManagers.length; i++) {
        let manager = test.testManagers[i];
        let managerName = document.createElement("test");
        managerName.innerHTML += manager.name + "<br />";
        managersBlock.appendChild(managerName);
        let hiddenInput = document.createElement("button");
        hiddenInput.hidden = true;

        hiddenInput.classList.add("test" + test.id + "-hiddenIds");
        hiddenInput.id = test.id + "-" + i;
        hiddenInput.value = "user" + manager.id;
        managersBlock.appendChild(hiddenInput);
    }
}

//eslint-disable-next-line no-unused-vars
function updateTestStatus(newStatus, testId){
    let jsonData = {
        "status": newStatus,
    }
    sendAjax("/api/test/status/" + testId, 'PUT', JSON.stringify(jsonData)).then(res => {
        let test = res;
        let row = document.getElementById("test-block" + test.id);
        if(test.status == "SUCCESS") {
            row.style.backgroundColor = "#D3FECE";
        }
        else if(test.status == "FAIL") {
            row.style.backgroundColor = "#FEDADA";
        }
        else {
            row.style.backgroundColor = "#E1E1E1";
        }
        let status_button = document.getElementById("test" + test.id + "-" + test.status);
        status_button.classList.add('active');
    })
.catch(() => {
        $(".err-msg").fadeIn();
        $(".spinner-border").fadeOut();
    })
}


function fillModal(value)
{
    const testId = value.substring(4);
    let name = document.getElementById(value + "-name").textContent;
    let description = document.getElementById(value + "-description").innerHTML;
    let type = document.getElementById(value + "-type").textContent;
    let date = document.getElementById(value + "-date").textContent;
    let expectedResult = document.getElementById(value + "-expectedResult").innerHTML;
    let obtainedResult = document.getElementById(value + "-obtainedResult").innerHTML;

    document.getElementById("modal-id").value = value;
    document.getElementById("modal-name").value = name;
    document.getElementById("modal-description").value = description;
    document.getElementById("modal-type").value = type;
    document.getElementById("modal-expectedResult").value = expectedResult;
    document.getElementById("modal-obtainedResult").value = obtainedResult;
    $('#modal-testDate').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        }).datepicker("update", date);
    document.getElementById("modal-modal-mode").value = "update";

    let selectedValues = getTestManagersFromBlock(testId);

    let modalOptions = document.getElementById("modal-test-managers").options;

    for (let i = 0; i < modalOptions.length; i++) {
        let option = modalOptions[i];
        if (selectedValues.includes("user" + option.value)) {
            option.selected = true;
        } else {
            option.selected = false;
        }
    }
    $("#modal-test-managers").selectpicker("refresh");

    $("#modal").modal("show");
}

function getTestManagersFromBlock(testId)
{
    let classes = document.getElementsByClassName("test" + testId + "-hiddenIds");
    let managers = [];
    for (let i = 0; i < classes.length; i++) {
        managers.push(classes[i].value);
    }
    return managers;
}

function emptyModal()
{
    document.getElementById("modal-id").value = '';
    document.getElementById("modal-name").value = '';
    document.getElementById("modal-description").value = '';
    document.getElementById("modal-expectedResult").value = '';
    document.getElementById("modal-obtainedResult").value = '';
    document.getElementById("modal-modal-mode").value = "create";

    let modalOptions = document.getElementById("modal-test-managers").options;

    for (let i = 0; i < modalOptions.length; i++) {
        modalOptions[i].selected = false;
    }


    $("#modal").modal("show");
}

function createTest()
{
    let jsonData = getJsonDataFromModal();
    sendAjax("/api/test", 'POST', JSON.stringify(jsonData)).then(res => {
            let test = res;
            let testsTable = document.getElementById("tests");
            displayTest(test, testsTable);
            const edit_btn = document.getElementById("edit-el-" + test.id);
            edit_btn.addEventListener("click", function () {
                    fillModal(edit_btn.value); })
            const delete_btn = document.getElementById("delete-el-" + test.id);
        delete_btn.addEventListener("click", function () {
                deleteTest(delete_btn.value); })
            $("#modal").modal("hide");
        })
    .catch(() => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}


function getJsonDataFromModal()
{
    const name = document.getElementById("modal-name").value;
    const description = document.getElementById("modal-description").value;
    const type = document.getElementById("modal-type").value;
    const expectedResult = document.getElementById("modal-expectedResult").value;
    const obtainedResult = document.getElementById("modal-obtainedResult").value;
    const date = document.getElementById("modal-testDate").value;
    const testManagers = getTestManagersFromModal();

    let jsonData = {
        "name": name,
        "description": description,
        "type": type,
        "expectedResult": expectedResult, 
        "obtainedResult": obtainedResult,
        "testDate": date,
        "testManagers": testManagers,
        "project": projectId
    }
    return jsonData;
}

function extractDate(date)
{
    const formattedDate = date.substring(8, 10) + "-" + date.substring(5, 7) + "-" + date.substring(0, 4);
    return formattedDate;
}



function getTestManagersFromModal()
{
    let select = document.getElementById("modal-test-managers");
    let selectedValues = [];
    for (let i = 0; i < select.length; i++) {
        if (select.options[i].selected) {
            let value = select.options[i].value;
            selectedValues.push(value);
        }
    }
    return selectedValues;
}


function deleteTest(test)
{ 
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const tId = test.substring(4);
        sendAjax("/api/test/" + tId, 'DELETE').then(() => {
                let deletedBlock = document.getElementById("test-block" + tId);
                deletedBlock.parentNode.removeChild(deletedBlock);
                let deletedDetails = document.getElementById("test-hiddenblock" + tId);
                deletedDetails.parentNode.removeChild(deletedDetails);
            })
        .catch(() => {
                $(".err-msg").fadeIn();
                $(".spinner-border").fadeOut();
            })
    }
}

function updateTest()
{
    const tId = document.getElementById("modal-id").value.substring(4);
    let jsonData = getJsonDataFromModal();

    sendAjax("/api/test/" + tId, 'PUT', JSON.stringify(jsonData)).then(res => {
            let test = res;
            const date = extractDate(test.testDate);
            document.getElementById("test" + test.id + "-name").textContent = test.name;
            document.getElementById("test" + test.id + "-description").innerHTML = test.description;
            document.getElementById("test" + test.id + "-type").textContent = test.type;
            document.getElementById("test" + test.id + "-expectedResult").innerHTML = test.expectedResult;
            document.getElementById("test" + test.id + "-obtainedResult").innerHTML = test.obtainedResult;
            document.getElementById("test" + test.id + "-date").textContent = date;
            let status_button = document.getElementById("test" + test.id + "-" + test.status);
            status_button.classList.add('active');
            let managersBlock = document.getElementById("test" + test.id + "-managers");
            managersBlock.querySelectorAll('*').forEach(n => n.remove());
            let managers = Object.values(test.testManagers);       
            for (let i = 0; i < managers.length; i++) {
                let testManager = managers[i];
                let managerName = document.createElement("text");
                managerName.innerHTML += testManager.name + "</br>";
                managersBlock.appendChild(managerName);
                let hiddenInput = document.createElement("button");
                hiddenInput.hidden = true;
    
                hiddenInput.classList.add("test" + test.id + "-hiddenIds");
                hiddenInput.id = test.id + "-" + i;
                hiddenInput.value = "user" + testManager.id;
                managersBlock.appendChild(hiddenInput);
            }
        

            $("#modal").modal("hide");
        })
    .catch(() => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}

