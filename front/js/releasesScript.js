const projectId = JSON.parse(localStorage.getItem("user_current_project")).id;

$(document).ready(function () {
    startUp();
    fillWithReleases();
});

function startUp() {
    const add_el_btns = document.getElementById("add-btn-release");
    add_el_btns.addEventListener("click", function () { emptyModal(); });
    
    const modalConfirmBtn = document.getElementById("modal-mode");
    modalConfirmBtn.addEventListener("click", function () {
        if (modalConfirmBtn.value === "create") createRelease();
        else updateRelease();
    });
    loadSprintOptions();
}

function fillWithReleases() {
    sendAjax("/api/releases/" + projectId).then(res => {
        let releases = res;
        $("#release-table-body").empty();
        for (let i = 0; i < releases.length; i++) {
            fillTable(releases[i]);
        }
        
        let edit_el_btns = document.getElementsByClassName("edit-el");
        let delete_el_btns = document.getElementsByClassName("delete-el");
        
        for (let i = 0; i < edit_el_btns.length; i++) {
            let edit_btn = edit_el_btns[i];
            edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); });
        }
        for (let i = 0; i < delete_el_btns.length; i++) {
            let delete_btn = delete_el_btns[i];
            delete_btn.addEventListener("click", function () { deleteRelease(delete_btn.value); });
        }
    })
}

function loadSprintOptions() {
    sendAjax("/api/sprints/" + projectId).then(res => {
        if(res.length > 0) {
            $("#modal-sprint").empty().append("<option disabled selected>-- Choisir un sprint --</option>")
            for (let i = 0; i < res.length; i++) {
                const option = "<option value='"+ res[i].id + "'>" +
                    "Du " + formatDate(res[i].startDate) + " au " + formatDate(res[i].endDate) +
                    "</option>"
                $("#modal-sprint").append(option)
            }
        }
    })
}

function fillTable(release) {
    const tableRow =
        "<tr id='release-line-"+ release.id +"'>" +
        "<td id='rel" + release.id +"-name'>" + release.name + "</td>" +
        "<td id='rel" + release.id +"-releaseDate'>" + formatDate(release.releaseDate) + "</td>" +
        "<td id='rel" + release.id +"-sprint'><span id='sprint-id-rel" + release.id +"' class='hidden'>"+
        release.sprint.id +
        "</span>Du " + formatDate(release.sprint.startDate) + " au " + formatDate(release.sprint.endDate) + "</td>" +
        "<td id='rel" + release.id +"-description'>" + release.description + "</td>" +
        "<td id='rel" + release.id +"-src_link'>" + release.srcLink + "</td>" +
        "<td id='rel" + release.id +"'>" +
        "<button id=\"edit-el-" + release.id + "\" class=\"btn btn-warning btn-block edit-el\" value=\"rel" + release.id + "\"><span class=\"fa fa-edit\"></span></button>"+
        "<button id=\"delete-el-" + release.id + "\" class=\"btn btn-danger btn-block delete-el\" value=\"rel" + release.id + "\"><span class=\"fa fa-trash\"></span></button>"+
        "</td>" +
        "</tr>";
    $("#release-table-body").append(tableRow);
}

function fillModal(value) {
    let name = $("#" + value + "-name").html();
    let description = $("#" + value + "-description").html();
    let date = $("#" + value + "-releaseDate").html();
    let link = $("#" + value + "-src_link").html();
    let sprint = $("#sprint-id-" + value).html();
    $("#modal-date-group").fadeIn();
    
    date = date.split('/')[2] + '-' + date.split('/')[1] + '-' + date.split('/')[0];
    document.getElementById("modal-id").value = value;
    document.getElementById("modal-name").value = name;
    document.getElementById("modal-description").value = description;
    document.getElementById("modal-date").value = date;
    document.getElementById("modal-sprint").value = sprint;
    document.getElementById("modal-src_link").value = link;
    document.getElementById("modal-mode").value = "update";
    $("#modal-release").modal("show");
}

function emptyModal() {
    document.getElementById("modal-id").value = 'rel';
    document.getElementById("modal-name").value = '';
    document.getElementById("modal-description").value = '';
    document.getElementById("modal-date").value = '';
    $("#modal-date-group").fadeOut();
    document.getElementById("modal-sprint").value = '';
    document.getElementById("modal-src_link").value = '';
    document.getElementById("modal-mode").value = "create";
    
    $("#modal-release").modal("show");
}

function createRelease() {
    const nom = document.getElementById("modal-name").value;
    const description = document.getElementById("modal-description").value;
    const link = document.getElementById("modal-src_link").value;
    const sprint = document.getElementById("modal-sprint").value;
    
    let jsonData = {
        "name": nom,
        "description": description,
        "src_link": link,
        "sprint": sprint
    };
    
    sendAjax("/api/release", 'POST', JSON.stringify(jsonData)).then(res => {
        fillTable(res);
        const edit_btn = document.getElementById("edit-el-" + res.id);
        edit_btn.addEventListener("click", function () { fillModal(edit_btn.value); })
        const delete_btn = document.getElementById("delete-el-" + res.id);
        delete_btn.addEventListener("click", function () { deleteRelease(delete_btn.value); })
        $("#modal-release").modal("hide");
    })
}

function deleteRelease(rel) {
    const isConfirmed = confirm("Vous êtes sûr ?");
    if (isConfirmed) {
        const relId = rel.substring(3);
        sendAjax("/api/release/" + relId, 'DELETE').then(res => {
            $("#release-line-" + relId).empty();
        })
    }
}

function updateRelease() {
    const relId = document.getElementById("modal-id").value.substring(3);
    const nom = document.getElementById("modal-name").value;
    const date = document.getElementById("modal-date").value;
    const description = document.getElementById("modal-description").value;
    const link = document.getElementById("modal-src_link").value;
    const sprint = document.getElementById("modal-sprint").value;
    
    let jsonData = {
        "name": nom,
        "release_date": formatDate(date, false),
        "description": description,
        "src_link": link,
        "sprint": sprint
    };
    
    sendAjax("/api/release/" + relId, 'PUT', JSON.stringify(jsonData)).then(res => {
        $("#rel" + res.id + "-name").empty().append(res.name);
        $("#rel" + res.id + "-description").empty().append(res.description);
        $("#rel" + res.id + "-releaseDate").empty().append(formatDate(res.releaseDate));
        $("#rel" + res.id + "-src_link").empty().append(res.srcLink);
        $("#rel" + res.id + "-sprint").empty().append("<span id='sprint-id-rel-" + res.id +"' class='hidden'>"+ res.sprint.id +"</span>"
        + "Du " + formatDate(res.sprint.startDate) + " au " + formatDate(res.sprint.endDate));
        $("#modal-release").modal("hide");
    })
}

function formatDate(date, display = true) {
    let res = ""
    if(display) { //aaaa-mm-jj hh:mm:ss to jj/mm/aaaa
        const dateObj = new Date(date);
        const day = dateObj.getDate().toString()
        const formatedDay = (day.length === 1) ? ("0" + day) : day
        const month = (dateObj.getMonth() + 1).toString();
        const formatedMonth = (month.length === 1) ? ("0" + month) : month;
        res = formatedDay + '/' + formatedMonth + "/" + dateObj.getFullYear()
    } else { //aaaa-mm-jj to aaaa-mm-jj hh:mm:ss
        const dateObj = new Date(date.split("-")[0], date.split("-")[1], date.split("-")[2]);
        const day = dateObj.getDate().toString()
        const formatedDay = (day.length === 1) ? ("0" + day) : day
        const month = dateObj.getMonth().toString();
        const formatedMonth = (month.length === 1) ? ("0" + month) : month;
        res = dateObj.getFullYear() + '-' +
            formatedMonth + '-' +
            formatedDay + ' ' +
            '00:00:00'
    }
    return res
}
