<div class="jumbotron text-center">
    <h1>Tâches</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default text-center">
                <div class="panel-heading">
                    <h3>TO DO</h3>
                </div>
                <div id="to-do" class="panel-body">
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-primary btn-block add-el" value="todo"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default text-center">
                <div class="panel-heading">
                    <h3>IN PROGRESS</h3>
                </div>
                <div id="in-progress" class="panel-body">

                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary btn-block add-el" value="in progress"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default text-center">
                <div class="panel-heading">
                    <h3>DONE</h3>
                </div>
                <div id="done" class="panel-body">

                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary btn-block add-el" value="done"><span class="glyphicon glyphicon-plus"></span></button>
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
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Nouvelle tâche</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="modal-id">Id:</label>
                            <input type="text" class="form-control" id="modal-id" value="T1">
                        </div>
                        <div class="form-group">
                            <label for="modal-nom">Nom:</label>
                            <input type="text" class="form-control" id="modal-nom" placeholder="Maximum 50 caractères" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="modal-description">Description:</label>
                            <textarea rows="5" class="form-control" id="modal-description" placeholder="Maximum 255 caractères" maxlength="255"></textarea>
                        </div>
                        <div class="form-group row">
                            <label for="modal-workload" class="col-sm-4">Charge (en j/hommes):</label>
                            <div class="col-sm-4">
                                <input type="number" data-decimals="2" min="0" step="0.1" class="form-control" id="modal-workload">
                            </div>
                            <div class="col-sm-4"></div>
                        </div>
                        <div class="form-group row">
                            <label for="modal-dependant-issues" class="col-sm-4">Issues correspondantes:</label>
                            <div class="col-sm-8">
                                <select id="modal-dependant-issues" class="selectpicker" data-live-search="true" multiple>
                                   
                                </select>
                            </div>
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
<script defer src="js/tasksScript.js"></script>