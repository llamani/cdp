var edit_el_btns = document.getElementsByClassName("edit-el");

for(let i=0; i<edit_el_btns.length; i++ ){
    let edit_btn = edit_el_btns[i];
    edit_btn.addEventListener("click", function(){ fillModal(edit_btn.value);});
}

function fillModal(value){
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

    $("#modal").modal("show");
    
}

function emptyModal(){
    document.getElementById("modal-id").value = 'us';
    document.getElementById("modal-nom").value = '';
    document.getElementById("modal-description").value = '';
    document.getElementById("modal-priority").value = 'faible';
    document.getElementById("modal-difficulty").value = 'facile';

    $("#modal").modal("show");
}