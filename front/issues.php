<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css\issuesStype.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script defer src="js\issuesScript.js"></script>
    <title>Issues</title>
</head>

<body>
    <div class="jumbotron text-center">
        <h1>Issues</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h3>TO DO</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8 issue-block">
                                <a href="#us1" class="btn btn-default btn-block" data-toggle="collapse">
                                    <span class="badge">US1</span> Lorem ipsum dolor ...</a>
                            </div>
                            <div class="col-sm-2 issue-block"><button class="btn btn-warning btn-block edit-el" value="us1">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </button>
                            </div>
                            <div class="col-sm-2 issue-block"><button class="btn btn-danger btn-block delete-el" value="us1">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </div>

                        </div>

                        <div class="row">
                            <div id="us1" class="collapse well text-justify">
                                <div id="us1-name"><h4><strong>Lorem ipsum dolor sit amet</strong></h4></div>
                                <div id="us1-description">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>
                                <div id="us1-priority">
                                    <button hidden id="us1-priority-btn" value="faible"></button>
                                    <h6>Priorité :
                                        <span class="label label-default">Faible</span>
                                    </h6>
                                </div>
                                <div id="us1-difficulty" value="facile">
                                    <button hidden id="us1-difficulty-btn" value="facile"></button>
                                    <h6>Difficulté :
                                        <span class="label label-default">Facile</span>
                                    </h6>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h3>IN PROGRESS</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8 issue-block">
                                <a href="#us2" class="btn btn-default btn-block" data-toggle="collapse">
                                    <span class="badge">US2</span> Lorem ipsum dolor ...</a>
                            </div>
                            <div class="col-sm-2 issue-block"><button class="btn btn-warning btn-block edit-el" value="us2"><span class="glyphicon glyphicon-pencil"></span></button></div>
                            <div class="col-sm-2 issue-block"><button class="btn btn-danger btn-block"><span class="glyphicon glyphicon-trash"></span></button></div>

                        </div>

                        <div class="row">
                            <div id="us2" class="collapse well text-justify">
                                <div id="us2-name"><h4><strong>Lorem ipsum dolor sit amet</strong></h4>
                                </div>
                                <div id="us2-description">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>
                                <div id="us2-priority">
                                    <button hidden id="us2-priority-btn" value="moyenne"></button>
                                    <h6>Priorité :
                                        <span class="label label-warning">Moyenne</span>
                                    </h6>
                                </div>
                                <div id="us2-difficulty" value="facile">
                                    <button hidden id="us2-difficulty-btn" value="intermédiaire"></button>
                                    <h6>Difficulté :
                                        <span class="label label-warning">Intermédiaire</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h3>DONE</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8 issue-block">
                                <a href="#us3" class="btn btn-default btn-block" data-toggle="collapse">
                                    <span class="badge">US3</span> Lorem ipsum dolor ...</a>
                            </div>
                            <div class="col-sm-2 issue-block"><button class="btn btn-warning btn-block edit-el"><span class="glyphicon glyphicon-pencil"></span></button></div>
                            <div class="col-sm-2 issue-block"><button class="btn btn-danger btn-block"><span class="glyphicon glyphicon-trash"></span></button></div>

                        </div>

                        <div class="row">
                            <div id="us3" class="collapse well text-justify">
                                <div id="us3-description">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </div>
                                <div id="us2-priority" value="elevée">
                                    <h6>Priorité :
                                        <span class="label label-danger">Elevée</span>
                                    </h6>
                                </div>
                                <div id="us2-difficulty" value="difficile">
                                    <h6>Difficulté :
                                        <span class="label label-danger">Difficile</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus"></span></button>
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
                        <h4 class="modal-title">Nouvelle issue</h4>
                    </div>
                    <div class="modal-body">
                        <form action="#">
                            <div class="form-group">
                                <label for="id">Id:</label>
                                <input type="text" class="form-control" id="modal-id" value="US1">
                            </div>
                            <div class="form-group">
                                <label for="nom">Nom:</label>
                                <input type="text" class="form-control" id="modal-nom" placeholder="Maximum 50 caractères" maxlength="50">
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea rows="5" class="form-control" id="modal-description" placeholder="Maximum 255 caractères" maxlength="255"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="priority">Priorité:</label>
                                <select class="form-control" id="modal-priority">
                                    <option value="faible">Faible</option>
                                    <option value="moyenne">Moyenne</option>
                                    <option value="elevée">Elevée</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="difficulty">Difficulté:</label>
                                <select class="form-control" id="modal-difficulty">
                                    <option value="facile">Facile</option>
                                    <option value="intermédiaire">Intermédiaire</option>
                                    <option value="difficile">Difficile</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Confirmer</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                    </div>
                </div>

            </div>
        </div>
</body>

</html>