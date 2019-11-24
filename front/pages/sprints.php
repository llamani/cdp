<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sprints</h1>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <button type="button" id="add-btn" class="btn btn-primary" value= "create">
                        Ajouter un sprint
                    </button>
                </div>
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
                    <div id="sprints" class="container">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="add-sprint-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouveau sprint</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="form-add-sprint">
                    <input type="hidden" class="form-control" id="modal-id" value="">
                    <div class="form-group row">
                        <div class="input-group modal-sprint">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input class="form-control start_date" type="text" placeholder="Début du sprint" id="startdate_datepicker">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="input-group modal-sprint">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input class="form-control end_date" type="text" placeholder="Fin du sprint" id="enddate_datepicker">
                        </div>
                    </div>
                    <div class="form-group row modal-sprint">
                        <label for="modal-dependant-issues" class="col-sm-2">Issues:</label>
                        <div class="col-sm-10">
                            <select id="modal-dependant-issues" class="selectpicker" data-live-search="true" multiple>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" form="add-sprint" id="modal-mode" class="btn btn-primary" value="create">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#startdate_datepicker').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#enddate_datepicker').datepicker({
            format: 'dd-mm-yyyy'
        });
    });
</script>
<script defer src="js/sprintsScript.js"></script>
