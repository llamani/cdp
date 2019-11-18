<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Releases</h1>
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
        /*sendAjax('/api/releases/' + localStorage.getItem('user_project_selected'))
            .then(res => {

            }).catch(err => {

        })*/
    });
</script>
