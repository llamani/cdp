<script defer src="js/issuesScript.js"></script>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Issues</h1>
            </div>
        </div>
    </div>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card text-center">
                                    <div class="card-header bg-danger">
                                        <h3>TO DO</h3>
                                    </div>
                                    <div id="to-do" class="card-body progress-list">
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-primary btn-block add-el" value="todo"><span class="fa fa-plus"></span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card text-center">
                                    <div class="card-header bg-warning">
                                        <h3>IN PROGRESS</h3>
                                    </div>
                                    <div id="in-progress" class="card-body progress-list">

                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-primary btn-block add-el" value="in progress"><span class="fa fa-plus"></span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card text-center">
                                    <div class="card-header bg-success">
                                        <h3>DONE</h3>
                                    </div>
                                    <div id="done" class="card-body progress-list">

                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-primary btn-block add-el" value="done"><span class="fa fa-plus"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div id="modal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header text-center">
                                        <h4 class="modal-title">Nouvelle issue</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="modal-id">ID:</label>
                                                <input type="text" class="form-control" id="modal-id" value="US1">
                                            </div>
                                            <div class="form-group">
                                                <label for="modal-nom">Nom:</label>
                                                <input type="text" class="form-control" id="modal-nom" placeholder="Maximum 50 caractères" maxlength="50">
                                            </div>
                                            <div class="form-group">
                                                <label for="modal-description">Description:</label>
                                                <textarea rows="5" class="form-control" id="modal-description" placeholder="Maximum 255 caractères" maxlength="255"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="modal-priority">Priorité:</label>
                                                <select class="form-control" id="modal-priority">
                                                    <option value="low">Faible</option>
                                                    <option value="medium">Moyenne</option>
                                                    <option value="high">Elevée</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="modal-difficulty">Difficulté:</label>
                                                <select class="form-control" id="modal-difficulty">
                                                    <option value="easy">Facile</option>
                                                    <option value="intermediate">Intermédiaire</option>
                                                    <option value="difficult">Difficile</option>
                                                </select>
                                            </div>
                                            <button hidden id="modal-status" value="todo"></button>
                                            <button type="button" id="modal-mode" class="btn btn-success" value="create">Confirmer</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
