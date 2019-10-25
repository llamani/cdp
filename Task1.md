# Tâches pour le Sprint 1

| ID | User Stories ID | Tâche | Charge | Responsable | Dépendances |
| -- | --------------- | ------| ------ | ----------- | ----------- |
| T1 | - | Mise en place de l'architecture du projet. un dossier **app** contenant le projet en PHP avec Symfony 4.3. L'architecture du back-end est expliquée à la fin de ce document.| | | |
| T2 | - | Mise en place de l'architecture de la base de données MySQL. Rédaction du schéma de la base de données (expliqué à la fin du document). | | | |
| T3 | US1 | Création de la page HTML "/signup" affichant un formulaire d'inscription. | | | 
| T4 | US2 | Création de la page HTML "/login" affichant un formulaire de connexion.  | | | 
| T5 | US3 | Création de la page HTML "/projects" affichant une liste de l'ensemble des projets de l'utilisateur. La page doit contenir un bouton "Ajouter un projet", ainsi que des boutons "Modifier" et "Supprimer" à coté de chaque projet affiché sur la page. | | | 
| T6 | US3 | Création d'un modal d'ajout/modification de projet accessible depuis la page "/projects".   | | | 
| T7 | US3, US7, US11 | Création du pop up de suppression. | | | 
| T8 | US5 | Création de la page HTML "/issues" affichant l'ensemble des issues du backlog du projet, séparées par leur statut (TODO / IN PROGRESS / DONE). La page doit contenir un bouton "Ajouter une issue", ainsi que des boutons "Modifier" et "Supprimer" à coté de chaque issue affichée sur la page. | | | |
| T9 | US5 | Création d'un modal d'ajout/modification d'une issue accessible par le bouton "Ajouter une issue"/"Modifier" sur la page "/issues". | | | |
| T7 | US14 | Création de la page HTML "/tasks" affichant l'ensemble des tâches du projet, séparées par leur statut (TODO / IN PROGRESS / DONE). La page doit contenir un bouton "Ajouter une tâche", ainsi que des boutons "Modifier" et "Supprimer" à coté de chaque tâche affichée sur la page. | | | |
| T8 | US16 | Création d'un modal d'ajout/modification d'une tâche, accessible par le bouton "Ajouter une tâche"/"Modifier" sur la page "/tasks". | | | |
| T11 | US9 | Récupérer l'ensemble des issues de la base de données dans le backend et les renvoyer au format JSON au front-end. (Définir une route dans le backend et un traitement spécifique dans un controleur) | | | |
| T12 | US11 | Récupérer les données du formulaire d'ajout dans le backend, les traiter pour ensuite sauvegarder une nouvelle issue dans la base de données. | | | |
| T13 | US12 | Récupérer les données du formulaire de modification dans le backend, les traiter pour ensuite modifier l'issue concernée dans la base de données. | | | |
| T14 | US12 | Récupérer l'identifiant de l'issue à supprimer dans le backend, pour ensuite supprimer l'issue concernée dans la base de données. | | | |
| T15 | US14 | Récupérer l'ensemble des tâches de la base de données dans le backend et les renvoyer au format JSON au front-end. (Définir une route dans le backend et un traitement spécifique dans un controleur) | | | |
| T16 | US16 | Récupérer les données du formulaire d'ajout dans le backend, les traiter pour ensuite sauvegarder une nouvelle tâche dans la base de données. | | | |
| T17 | US16 | Récupérer les données du formulaire de modification dans le backend, les traiter pour ensuite modifier la tâche concernée dans la base de données. | | | |
| T18 | US17 | Récupérer l'identifiant de la tâche à supprimer dans le backend, pour ensuite supprimer l'issue concernée dans la base de données. | | | |

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

