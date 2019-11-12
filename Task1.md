# Tâches pour le Sprint 1

| ID | User Stories ID | Tâche | Charge (en jour/homme)| Responsable | Dépendances | Etat |
| -- | --------------- | ------| ------ | ----------- | ----------- |------- |
| T1 | US1 à US18 | Mise en place de l'architecture du projet. un dossier **api** contenant le projet en PHP avec Symfony 4.3. L'architecture du back-end est expliquée à la fin de ce document.| 0.5 | Guillaume | - | DONE |
| T2 | US1 à US18 | Mise en place de l'architecture de la base de données MySQL. Rédaction du schéma de la base de données (expliqué à la fin du document)<ul><li>Création des entities pour chaque table de la base de données avec Symfony.</li><li>Exécution des migrations Symfony</li></ul> <br />**DoD** : La base de données est conforme au schéma. | 1 | Guillaume | - | DONE |
| T3 | US1 | Page d'inscription<ul><li>Création de la page HTML "/signup" affichant un formulaire d'inscription (voir US1)</li></ul><br />**DoD** : Affichage de la page d'inscription où l'utilisateur peut remplir le formulaire.| 0.5 | Lucie | T1 | DONE |
| T4 | US2 | Page de connexion<ul><li>Création de la page HTML "/login" affichant un formulaire de connexion.</li></ul><br />**DoD** : Affichage de la page de connexion où l'utilisateur peut remplir le formulaire.  | 0.5 | Guillaume | T1, T23 | DONE |
| T5 | US3 | Page des projets <ul><li>Création de la page HTML "/projects" affichant une liste de l'ensemble des projets de l'utilisateur. La page doit contenir un bouton "Ajouter un projet", ainsi que des boutons "Modifier" et "Supprimer" à coté de chaque projet affiché sur la page.</li></ul><br />**DoD** : Affichage de la page des projets où l'utilisateur peut cliquer sur les boutons. | 0.5 | Lucie | T1, T13 | DONE |
| T6 | US3 | Modal d'ajout/modification de projet <ul><li>Création d'un modal accessible depuis la page "/projects" contenant un formulaire(voir US3)</li></ul><br />**DoD** : Affichage du modal au clic du bouton Ajouter/Modifier avec un formulaire que l'utilisateur peut remplir.   | 0.5 | Lucie | T1, T5 | DONE |
| T7 | US3, US7, US11 | Pop up de suppression.<br /><br />**DoD** : Affichage d'un pop-up (voir US3, 7 et 11) au clic du bouton Supprimer. | 0.5 | Laura | T1 | DONE |
| T8 | US5 | Page des issues <ul><li>Création de la page HTML "/issues" affichant une liste de l'ensemble des issues liées à un projet séparées par leur statut (TODO, IN PROGRESS, DONE). La page doit contenir un bouton "Ajouter une issue", ainsi que des boutons "Modifier" et "Supprimer" à coté de chaque issue affichée sur la page.</li></ul><br />**DoD** : Affichage de la page des issues où l'utilisateur peut cliquer sur les boutons.| 0.5 | Laura | T1, T14 | DONE |
| T9 | US7 | Modal d'ajout/modification d'une issue <ul><li>Création d'un modal accessible depuis la page "/issues" contenant un formulaire(voir US5)</li></ul><br />**DoD** : Affichage du modal au clic du bouton Ajouter/Modifier avec un formulaire que l'utilisateur peut remplir.   | 0.5 | Laura | T1, T8 | DONE |
| T10 | US9 | Page des tasks <ul><li>Création de la page HTML "/tasks" affichant une liste de l'ensemble des tâches liées à un projet séparées par leur statut (TODO, IN PROGRESS, DONE). La page doit contenir un bouton "Ajouter une tâche", ainsi que des boutons "Modifier" et "Supprimer" à coté de chaque tâche affichée sur la page.</li></ul><br />**DoD** : Affichage de la page des tâches où l'utilisateur peut cliquer sur les boutons. | 0.5 | Laura | T1, T15 | DONE |
| T11 | US11 | Modal d'ajout/modification de tâche <ul><li>Création d'un modal accessible depuis la page "/tasks" contenant un formulaire(voir US16)</li></ul><br />**DoD** : Affichage du modal au clic du bouton Ajouter/Modifier avec un formulaire que l'utilisateur peut remplir.   | 0.5 | Laura | T1 | DONE |
| T12 | US6, US10 | Glisser-Déposer des issues et tâches <ul><li>Implémentation d'une fonction permettant de déplacer un élément d'une liste sur la page HTML.</li></ul><br />**DoD** : L'utilisateur peut déplacer un élément d'une liste à une autre et celui-ci se positionne à l'endroit où il a été déposé (changement de liste)| 1 | Lucie | T1 | TO DO |
| T13 | US3 | Récupération des projets dans le backend <ul><li>Création d'un fichier ProjectsController.php</li><li>Définition dans ProjectController.php d'une route vers /projects</li><li>Implémentation de la fonction fetchAll($userId) qui renvoie tous les projets liés à un utilisateur au format JSON</li></ul><br />**DoD** : Affichage des projets présents dans la base de données en fonction d'un utilisateur passé en paramètre.| 1 | Guillaume | T1, T2 | DONE | 
| T14 | US5 | Récupération des issues dans le backend <ul><li>Création d'un fichier issuesController.php</li><li>Définition dans IssuesController.php d'une route vers /issues</li><li>Implémentation de la fonction fetchAll($projectId) qui renvoie 3 listes d'issues liées au projet, en fonction de leur statut au format JSON</li></ul><br />**DoD** : Affichage des issues présentes dans la base de données en fonction d'un projet passé en paramètre. | 1 | Laura | T1, T2 | DONE |
| T15 | US9 | Récupération des tâches dans le backend <ul><li>Création d'un fichier tasksController.php</li><li>Définition dans TasksController.php d'une route vers /tasks</li><li>Implémentation de la fonction fetchAll($projectId) qui renvoie 3 listes de tâches liées au projet, en fonction de leur statut au format JSON</li></ul><br />**DoD** : Affichage des tâches présentes dans la base de données en fonction d'un projet passé en paramètre. | 1 | Lucie | T1, T2 | DONE |
| T16 | US3 | Ajout/Modification d'un projet dans le backend <ul><li>Définition dans ProjectController.php de deux routes /add-project et /update-project</li><li>Implémentation des fonctions addProject(Request \$request) et update-project(Request \$request, $projectId)</li></ul><br />**DoD** : Ajout/mise à jour de la base de données après remplissage du formulaire dans /projects| 1 | Guillaume | T1, T2 | DONE |
| T17 | US7 | Ajout/Modification d'une issue dans le backend <ul><li>Définition dans IssuesController.php de deux routes /add-issue et /update-issue</li><li>Implémentation des fonctions addIssue(Request \$request) et update-issue(Request \$request, $issueId)</li></ul><br />**DoD** : Ajout/mise à jour de la base de données après remplissage du formulaire dans /issues| 1 | Laura | T1, T2 | DONE |
| T18 | US11 |Ajout/Modification d'une tâche dans le backend <ul><li>Définition dans TaskController.php de deux routes /add-task et /update-task</li><li>Implémentation des fonctions addTask(Request \$request) et update-task(Request \$request, $taskId)</li></ul><br />**DoD** : Ajout/mise à jour de la base de données après remplissage du formulaire dans /tasks| 1 | Lucie | T1, T2 | DONE |
| T19 | US3 | Suppression d'un projet dans le backend <ul><li>Définition dans ProjectController.php d'une route /delete-project</li><li>Implémentation de la fonction deleteProject($projectId)</li></ul><br />**DoD** : Suppression d'un projet de la base de données après clic sur bouton Supprimer dans /projects| 0.5 | Guillaume | T1, T2 | DONE | 
| T20 | US7 | Suppression d'une issue dans le backend <ul><li>Définition dans IssuesController.php d'une route /delete-issue</li><li>Implémentation de la fonction deleteIssue($issueId)</li></ul><br />**DoD** : Suppression d'une issue de la base de données après clic sur bouton Supprimer dans /issues | 0.5 | Laura | T1, T2 | DONE |
| T21 | US11 |Suppression d'une tâche dans le backend <ul><li>Définition dans TasksController.php d'une route /delete-task</li><li>Implémentation de la fonction deleteTask($taskId)</li></ul><br />**DoD** : Suppression d'une tâche de la base de données après clic sur bouton Supprimer dans /tasks| 0.5| Laura | T1, T2 | DONE |
| T22 | US1 | Ajout d'un utilisateur dans le backend <ul><li> Création d'un fichier UserController.php</li><li>Définition dans UserController.php d'une route /add-controller</li><li>Implémentation d'une fonction addUser(Request \$request)</li></ul><br />**DoD** : Ajout d'un utilisateur dans la base de données après remplissage du formulaire dans /signup| 1 | Lucie | T1, T2 | DONE |
| T23 | US2 | Connexion d'un utilisateur dans le backend <ul><li>Définition dans UserController.php d'une route /login</li><li>Implémentation d'une fonction loginUser(Request \$request)</li></ul><br />**DoD** : Un utilisateur enregistré dans la base de données peut se connecter à son compte en remplissant le formulaire dans /login.| 0.5 | Guillaume | T1, T2 | IN PROGRESS |
| T24 | US6, US10 | Glisser-Déposer des issues/tâches dans le backend <ul><li>Définition dans IssuesController.php d'une route /slide-issue et dans TasksController.php d'une route /slide-task</li><li>Implémentation d'une fonction updateStatus(\$issueId, \$new_status) dans IssuesController.php et d'une fonction updateStatus(\$taskId, \$new_status) dans TasksController.php</li></ul><br />**DoD** : La base de données est modifiée en conséquence après un glisser-déposer dans le front-end. | 0.5 | Laura | T1, T2 | TO DO |
| T25 | - | Mettre en place un environnement Docker de l'application. <br />**DoD** : La commande "docker-compose up" permet de déployer l'application correctement (back, front & base de donées sur déployés sur les ports rensignées dans le fichier `.env` à la racine du projet). | 1 | Guillaume | - | DONE |
## Schéma de la base de données

https://dbdiagram.io/d/5daf031202e6e93440f27fed


# Architecture projet Symfony 4.X

## Arborescence

Un projet symfony est composé de plusieurs dossiers :
- `bin/` : Dossier contenant des executables de dépendances de symfony
- `config/` : Dossier contenant les fichiers de configuration de notre projet
- `public/` : Dossier racine du serveur web. 
- `src/` : Contient le code du projet (Entités, Controleurs ect...)
- `templates/` : Dossier contenant les vues de l'application (Inutilisé dans notre projet.)
- `tests/` : Dossier contenant les tests unitaires de l'application.
- `var/` : Dossier contenant les fichiers de cache et de logs 
- `vendor/` : Le dossier où sont installées les dépendances référencées dans le fichier `composer.json` 
- `.env` : Fichier contenant la configuration de l'environnement d'exécution de notre code
- `composer.json` : Fichier listant les dépendances du projet ainsi que d'autres métadonnées

Toute notre implémentation est présente dans le dossier `src/`, le reste est généré par le framework.

Détails du dossiers `src` : 
- `Controller/` : Contient les controleurs de l'application. Un controleur contient les fonctions permettant le traitement des requêtes reçues.

- `Entity/` : Contient les classes utilisées par l'application. L'ORM doctrine permet de faire le lien avec les tables de la base de données afin de manipuler son contenu sous forme d'objet.

- `Repository/` : Pour chaque "Entity" déclarées, il est possible de déclarer un "Repository" qui contient des fonctions de requêtes personnalisées sur la base de données (écrites avec la syntaxe de l'ORM).

- `Migrations/` : Lors de changement des "Entities", qui doivent entrainer des changement dans la base de données, des migrations de la base de données sont générées dans ce dossier grâce à la ligne de commande : ```php bin/console make:migration```  
Pour exécuter les migrations il suffit d'executer : ```php bin/console doctrine:migrations:migrate```

## Installation

Le lancement de l'application nécessite l'installation des dépendances avec la commande :  

    $ php composer.phar install

Il faut ensuite executer les migrations avec la commande (Pensez à bien configurer la base de données (`DATABSE_URL`) dans le fichier `.env`):

    $ php bin/console doctrine:migrations:migrate


Il vous suffit ensuite de lancer le serveur avec la commande :
   
    $ php bin/console server:run   

Votre application est maintenant lancée sur : [http://localhost:8000](http://localhost:8000) !

## Création d'une route, d'un controleur

Les controleurs sont écrits de la façon suivante : 
```
class MyController
{
    /**
     * @Route("/myroute", , methods={"GET","DELETE"}, name="my_route_name")
     */
    public function getMyRoute()
    {
        return new Response(
            '<html><body>Bienvenue sur ma route</body></html>'
        );
    }
}
```

La fonction `getMyRoute()` renvoie une réponse HTML.
Cette fonction n'est appelé que par une requête GET ou DELETE vers `/myroute`.

Dans le cas de fonction où il faut récupérer des paramètres, la syntaxe est la suivante : 
```
class MyController
{
    /**
     * @Route("/params/age/{age}", , methods={"POST"}, name="params_route")
     */
    public function postParams(Request $request, $age)
    {
        $myParam = $request->request->get('myparam');

        return new Response(
            '<html><body>Bienvenue sur ma route</body></html>'
        );
    }
}
```

Les paramètres GET de la requête doivent être défini dans la requête entre accollades et doivent être passés comme paramètre de la fonction (avec le même nom que dans l'uri).

Les paramètres POST de la requête sont contenu dans l'objet `Request` passé en paramètre de la fonction en question.

## Fonctionnement de l'ORM

l'ORM doctrine permet de générer les entités de l'application et de créer le schéma de la base de données en fonction des entités générée.

Pour générer ou modifier une entités existante, il suffit d'éxecuter la commande suivante : 

    $ php bin/console make:entity

Il vous sera demander ensuite de donner le nom, les attributs et les relations de chaque entités.

Afin de générer le schéma de la base de données, il suffit de générer et exécuter les migrations avec les commandes suivantes : 

    $ php bin/console make:migration
    $ php bin/console doctrine:migrations:migrate

Toute la documentation sur Doctrine, et l'utlisation des classes "Entity" générées est disponible à l'adresse suivante : [https://symfony.com/doc/current/doctrine.html](https://symfony.com/doc/current/doctrine.html)


# Test unitaires

Les tests  unitaires ont été implémentés dans le dossier `tests/` de l'application grâce à PHPUnit. 
Vous pourrez exécuter les tests avec les commandes suivantes : 
```
    # lancer tous les tests de l'application
    $ php bin/phpunit

    # Lancer tous les tests du dossiers Utils/
    $ php bin/phpunit tests/Utils

    # lancer les tests de la classe MaClasse 
    $ php bin/phpunit tests/Util/MaClasseTest.php
```

Vous pouvez ajouter l'option `--testdox` à votre commande pour afficher le nom des tests effectués.

La configuration de PHPUnit, utilisé pour nos tests unitaires se trouve dans le fichier `phpunit.xml.dist`.

