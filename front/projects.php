
      <div class="jumbotron text-center">
      <h1>Projets</h1>
    </div>
      <div class="container-fluid text-center">

  <div class="line">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Ajouter un projet
</button>
</div>
<br>
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-2">
      <div class="project">
      <span class="glyphicon glyphicon-leaf logo-small"></span>
      <h4>Projet</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
    </div>
    <div class="col-sm-2">
      <div class="project">
      <span class="glyphicon glyphicon-leaf logo-small"></span>
      <h4>Projet</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
    </div>
    <div class="col-sm-2">
      <div class="project">
      <span class="glyphicon glyphicon-leaf logo-small"></span>
      <h4>Projet</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
    </div>
    <div class="col-sm-3"></div>
  </div>

  <br><br>
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-2">
      <div class="project">
      <span class="glyphicon glyphicon-leaf logo-small"></span>
      <h4>Projet</h4>
      <p>Lorem ipsum dolor sit amet..</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="project">
      <span class="glyphicon glyphicon-leaf logo-small"></span>
      <h4>Projet</h4>
      <p>Lorem ipsum dolor sit amet..</p>
      </div>
    </div>
    <div class="col-sm-2">
      <div class="project">
      <span class="glyphicon glyphicon-leaf logo-small"></span>
      <h4 style="color:#303030;">Projet</h4>
      <p>Lorem ipsum dolor sit amet..</p>
      </div>
    </div>
    <div class="col-sm-3"></div>
  </div>
</div>

      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Nouveau projet</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    <form  class= "form-signin" action="/project" id="add-project" method="POST">
                        <div class="form-group">
                        <input type="text" class="form-control" name="name" id="_name" placeholder="Nom" required>
                        </div>
                        <div class="form-group">
                        <textarea class="form-control" rows = "5" cols = "60" name = "description" placeholder="Description" required></textarea><br>
                        </div>   
                    </form>  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
              <button type="submit" form="add-project" class="btn btn-primary">Enregistrer</button>
            </div>
          </div>
        </div>
      </div>
