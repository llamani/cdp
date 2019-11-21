<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Releases</h1>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <button type="button" id="add-btn" class="btn btn-primary" data-toggle="modal" data-target="#modal-release">
                        Ajouter une release
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
                    <table id="releasesTable" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Sources</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modal-release" tabindex="-1" role="dialog" aria-labelledby="add-release-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle release</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id" value="">
                    </div>
                    <div class="form-group">
                        <label for="name">Titre:</label>
                        <input type="text" class="form-control" id="name" placeholder="Titre" required>
                    </div>
                    <div class="form-group">
                        <label for="version">Version:</label>
                        <input type="text" class="form-control" id="version" placeholder="1.0.0" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" rows="5" cols="60" id="description" placeholder="Description"></textarea><br>
                    </div>
                    <div class="form-group">
                        <label for="src_link">Sources:</label>
                        <input type="text" class="form-control" id="src_link" placeholder="Lien vers les sources" required>
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
<script src="js/releasesScript.js"></script>
<script>
    $(function () {
        $('#releasesTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
</script>
