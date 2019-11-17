<script defer src="js/projectsScript.js"></script>
<div class="jumbotron text-center">
    <h1>Projets</h1>
</div>
<div class="container-fluid text-center">

        <button type="button" id="add-btn" class="btn btn-primary" value= "create">
            Ajouter un projet
        </button>
    <hr/>
    <div id="projects" class="container"></div>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="add-project-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Nouveau projet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  class= "form-signin">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="id" value="">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" placeholder="Nom" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows = "5" cols = "60" id="description" placeholder="Description" required></textarea><br>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" form="add-project" id="modal-mode" class="btn btn-primary" value="create">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</div>
