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
    document.getElementById("chart-btn").addEventListener("click", function () { $("#chartModal").modal("show"); });
});

function fillModalWithIssueOptions() {
    let modalOptions = document.getElementById("modal-dependant-issues");
    sendAjax("/api/issues/" + projectId).then(res => {
        let issues = res;
        for (let i = 0; i < issues.length; i++) {
            let issue = issues[i];
            optionNode = document.createElement("option");
            optionNode.innerHTML = issue.name;
            optionNode.value = "u" + issue.id;
            modalOptions.appendChild(optionNode);
            $("#modal-dependant-issues").selectpicker("refresh");
        }
    })
        .catch(() => {
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
        createChartForm(sprints);

        const edit_el_btns = document.getElementsByClassName("edit-el");
        const delete_el_btns = document.getElementsByClassName("delete-el");
        const task_el_btns = document.getElementsByClassName("task-el");

        for (let i = 0; i < edit_el_btns.length; i++) {
            let edit_btn = edit_el_btns[i];
            edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); });
        }

        for (let i = 0; i < delete_el_btns.length; i++) {
            let delete_btn = delete_el_btns[i];
            delete_btn.addEventListener("click", function () { deleteSprint(delete_btn.value); });
        }

        for (let i = 0; i < task_el_btns.length; i++) {
            let task_btn = task_el_btns[i];
            task_btn.addEventListener("click", function () {
                const value = task_btn.value;
                localStorage.setItem("sprint", value.substring(6));
            });
        }
    })
        .catch(() => {
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
        .catch(() => {
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
        "<div class=\"col-1\">" +
        "<a href=\"app.php?page=tasks&sprint=" + sprintId + "\" target=\"_blank\" >" +
        "<button class=\"btn btn-default btn-block task-el\" value=\"sprint" + sprintId + "\" ><span class=\"fa fa-tasks\"></span></button>\n" +
        "</a>\n" +
        "</div>" +
        "<div class=\"col-1\">" +
        "<button id=\"edit-el-" + sprintId + "\" class=\"btn btn-warning btn-block edit-el\" value=\"sprint" + sprintId + "\">" +
        "<span class=\"fa fa-edit\"></span>\n" +
        "</button>\n" +
        "</div>" +
        "<div class=\"col-1\">" +
        "<button id=\"delete-el-" + sprintId + "\" class=\"btn btn-danger btn-block delete-el\" value=\"sprint" + sprintId + "\">" +
        "<span class=\"fa fa-trash\"></span></button>" +
        "</div>" +
        "<div id=\"collapse-" + sprintId + "\" class=\"collapse col-8\" aria-labelledby=\"sprint" + sprintId + "\" >" +
        "<div class=\"card card-body\">" +
        "<div class=\"sprint-issues\" id=\"S" + sprintId + "-issues\">\n" +
        "</div>" +
        "<div class=\"progress\" >" +
        "<div id=\"progress-done-" + sprintId + "\" class=\"progress-bar progress-bar-striped progress-bar-animated bg-success\"></div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>";
    fillWithSprintIssues(sprintId, sprint.issues);

    let pBDone = document.getElementById("progress-done-" + sprintId);
    const donePercentage = progressBarWidth(sprint);
    fillProgressBar(pBDone, donePercentage);
}

function fillProgressBar(progressBar, percentage) {
    progressBar.style = "width:" + percentage + "%";
    progressBar.innerHTML = percentage + "%";
}

function progressBarWidth(sprint) {
    const issues = sprint.issues;
    const nbOfIssues = issues.length;
    let nbOfDoneIssues = 0;
    for (let i = 0; i < nbOfIssues; i++) {
        const issue = issues[i];
        if (isDone(issue)) {
            nbOfDoneIssues += 1;
        }
    }
    if (nbOfDoneIssues > 0)
        return nbOfDoneIssues / nbOfIssues * 100;
    else {
        return 0;
    }
}

function isDone(issue) {
    const issueTasks = issue.tasks;
    let nbOfDoneTasks = 0;
    for (let j = 0; j < issueTasks.length; j++) {
        if (issueTasks[j].status === "done") {
            nbOfDoneTasks += 1;
        }
    }
    return nbOfDoneTasks === issueTasks.length;
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
    return date.substring(8, 10) + "-" + date.substring(5, 7) + "-" + date.substring(0, 4);
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
        .catch(() => {
            $(".err-msg").fadeIn();
            $(".spinner-border").fadeOut();
        })
}

function getJsonDataFromModal() {
    $("#modal-dependant-issues").selectpicker("refresh");
    const start = document.getElementById("startdate_datepicker").value;
    const end = document.getElementById("enddate_datepicker").value;
    const dependantIssues = getDependantIssuesFromModal();

    return {
        "startDate": start,
        "endDate": end,
        "issue": dependantIssues,
        "project": projectId
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

function deleteSprint(sprint) {
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const sprintId = sprint.substring(6);
        sendAjax("/api/sprint/" + sprintId, 'DELETE').then(() => {
            let deletedSprintBlock = document.getElementById("sprint-block-" + sprintId);
            deletedSprintBlock.parentNode.removeChild(deletedSprintBlock);
        })
            .catch(() => {
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

//################## BURN DOWN CHART #######################
function createChartForm(sprints) {
    const jsonData = generateChartDataFromSprints(sprints);
    generateChart(jsonData);
}

function generateChartDataFromSprints(sprints) {
    let realBurn = [];
    let idealBurn = [];
    let maxIdeal = 0;
    for (let i = 1; i <= sprints.length; i++) {
        let sprintIndex = i - 1;
        let sprintIssues = sprints[sprintIndex].issues;
        idealBurn[i] = getSprintIdealBurn(sprintIssues, sprints[sprintIndex].id);
        realBurn[i] = getSprintRealBurn(sprintIssues, sprints[sprintIndex].id);
        maxIdeal += idealBurn[i];
    }
    realBurn[0] = maxIdeal;
    idealBurn[0] = maxIdeal;

    for (let i = 1; i < realBurn.length; i++) {
        realBurn[i] = realBurn[i - 1] - realBurn[i];
        idealBurn[i] = idealBurn[i - 1] - idealBurn[i];
    }
    return generateChartJsonData(idealBurn, realBurn);
}

function getSprintIdealBurn(issues, sprintId) {
    let ideal = 0;
    for (let i = 0; i < issues.length; i++) {
        let issue = issues[i];
        if (issue.sprints[0] === sprintId) {
            ideal += mapBurn(issue.difficulty);
        }
    }
    return ideal;
}

function getSprintRealBurn(issues, sprintId) {
    let real = 0;
    for (let i = 0; i < issues.length; i++) {
        let issue = issues[i];
        let lastSprintIndex = issue.sprints.length - 1;
        if (issue.sprints[lastSprintIndex] === sprintId) {
            if (isIssueDone(issue)) {
                real += mapBurn(issue.difficulty);
            }
        }
    }
    return real;
}

function isIssueDone(issue) {
    const tasks = issue.tasks;
    const nbOfTasks = tasks.length;
    let nbOfDoneTasks = 0;
    for (let i = 0; i < nbOfTasks; i++) {
        if (tasks[i].status === 'done') {
            nbOfDoneTasks += 1;
        }
    }
    return nbOfDoneTasks === nbOfTasks;
}

function mapBurn(difficulty) {
    if (difficulty === 'easy')
        return 1;
    else if (difficulty === 'intermediate')
        return 3;
    else
        return 5;
}

function generateChartJsonData(idealBurn, realBurn) {
    let data = {};
    let points = [];
    data.points = points;
    for (let i = 0; i < idealBurn.length; i++) {
        let idealPoint = idealBurn[i];
        let realPoint = realBurn[i];
        let point = {
            "day": i,
            "real": realPoint,
            "ideal": idealPoint
        };
        data.points.push(point);
    }
    return data;
}

function generateChart(jsonData) {
    //set the dimensions and margins of the graph
    const margin = {top: 20, right: 20, bottom: 30, left: 50};
    const width = 400 - margin.left - margin.right;
    const height = 400 - margin.top - margin.bottom;

    //set the ranges
    let x = d3.scaleLinear().range([
        0,
        width
    ]);
    let y = d3.scaleLinear().range([
        height,
        0
    ]);

    //define the line
    const valueline = d3.line()
        .x(function (d) { return x(d.Day); })
        .y(function (d) { return y(d.Real); });
    //define the line
    const valueline2 = d3.line()
        .x(function (d) { return x(d.Day); })
        .y(function (d) { return y(d.Ideal); });

    /*append the svg object to the body of the page
      appends a 'group' element to 'svg'
      moves the 'group' element to the top left margin
    */
    let svg = d3.select("#chart").append("svg")
        .attr("width", width + 50 + margin.left + margin.right)
        .attr("height", height + 50 + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    const data = jsonData.points;
    //format the data
    data.forEach(function (d) {
        d.Day = d.day;
        d.Real = d.real;
        d.Ideal = d.ideal;
    });

    //Scale the range of the data
    x.domain(d3.extent(data, function (d) { return d.Day; }));
    y.domain([
        0,
        d3.max(data, function (d) {
            return Math.max(d.Real, d.Ideal);
        })
    ]);

    //Add the valueline path.
    svg.append("path")
        .data([data])
        .attr("class", "line-real")
        .attr("d", valueline);
    //Add the valueline path.
    svg.append("path")
        .data([data])
        .attr("class", "line-ideal")
        .attr("d", valueline2);

    svg.selectAll(".circle1")
        .data(data)
        .enter()
        .append("circle")
        .attr("class", "circle1")
        .attr("r", 2)
        .attr("cx", function (d) {
            return x(d.day)
        })
        .attr("cy", function (d) {
            return y(d.real)
        });

    svg.selectAll(".circle2")
        .data(data)
        .enter()
        .append("circle")
        .attr("class", "circle2")
        .attr("r", 2)
        .attr("cx", function (d) {
            return x(d.day)
        })
        .attr("cy", function (d) {
            return y(d.ideal)
        });

    //Add the X Axis
    svg.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x));

    //Add the Y Axis
    svg.append("g")
        .call(d3.axisLeft(y));

    //text label for the x axis
    svg.append("text")
        .attr("transform", "translate(" + (width / 2) + " ," + (height + margin.top + 20) + ")")
        .style("text-anchor", "middle")
        .text("Sprint");

    svg.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin.left)
        .attr("x", 0 - (height / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .text("Difficulté");
}
