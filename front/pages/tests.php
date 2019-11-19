<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tests</h1>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <button type="button" id="add-btn" class="btn btn-primary add" value="create">
                        Ajouter un test
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
                <div class="container">
        <table class="table table-hover" >
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Test</th>
                <th scope="col">Type</th>
                <th scope="col">Date de réalisation</th>
                <th scope="col">Responsable</th>
                <th scope="col">Statut</th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="tests">
            </tbody>
        </table>
    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="add-test-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" >Nouveau test</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="modal-id" value="">
                        </div>
                        <div class="form-group">
                            <label for="modal-name" >Nom:</label>
                            <input type="text" class="form-control" id="modal-name" placeholder="Maximum 50 caractères" required>
                        </div>
                        <div class="form-group">
                            <label for="modal-description">Description:</label>
                            <textarea class="form-control" rows = "3" cols = "60" id="modal-description" placeholder="Maximum 255 caractères" maxlength="50"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="modal-type">Type:</label>
                            <select class="form-control" id="modal-type">
                                <option value="unit">Unitaire</option>
                                <option value="fonctional">Fonctionnel</option>
                                <option value="integration">Intégration</option>
                                <option value="ui">UI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="modal-expectedResult">Résultat attendu:</label>
                            <textarea class="form-control" rows = "3" cols = "60" id="modal-expectedResult" placeholder="Maximum 255 caractères" maxlength="255"></textarea>
                        </div>
                        <div class="form-group">
                        <label for="modal-obtainedResult">Résultat obtenu:</label>
                            <textarea class="form-control" rows = "3" cols = "60" id="modal-obtainedResult" placeholder="Maximum 255 caractères" maxlength="255"></textarea>
                        </div>
                        <br />
                        <div class="form-group row">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><label for="modal-testDate">Date de réalisation:</label>
                            <input class="form-control test_date" type="text" placeholder="jj-mm-aaaa" id="modal-testDate">
                        </div>
                        <br />
                        <div class="form-group">
                            <label for="modal-test-managers" class="col-sm-4">Responsable(s):</label>
                            <div class="col-sm-8">
                                <select id="modal-test-managers" class="selectpicker" data-live-search="true" multiple>
                                   
                                </select>
                            </div>
                        </div>
                        <br />
                        <div class="form-group">
                            <label for="modal-status">Statut:</label>
                            <select class="form-control" id="modal-status">
                                <option value="SUCCESS">SUCCESS</option>
                                <option value="FAIL">FAIL</option>
                                <option value="UNKNOWN">UNKNOWN</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" id="modal-modal-mode" class="btn btn-primary" value="create">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#modal-testDate').datepicker({
            format: 'dd-mm-yyyy'
        });
    });
</script>
<script defer src="js/testsScript.js"></script>
