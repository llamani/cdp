#[V1.0.0] Documentation du projet

##Manuel d'installation

Vous trouverez le manuel d'installation de l'application ainsi que la documentation pour les tests unitaires dans le fichier [INSTALL.md](./INSTALL.md)

**Une description Swagger de l'API est disponible avec le fichier [swagger.yml](./swagger.yml)**

##Architecture

###Backend

Le backend est un projet symfony composé des dossiers suivants:
- `bin/` : Dossier contenant des executables de symfony
- `config/` : Dossier contenant les fichiers de configuration de notre projet
- `public/` : Dossier racine du serveur web. 
- `src/` : Contient le code du projet (Entités, Controleurs ect...)
- `templates/` : Dossier contenant les vues de l'application (Inutilisé dans notre projet.)
- `tests/` : Dossier contenant les tests unitaires de l'application.
- `var/` : Dossier contenant les fichiers de cache et de logs 
- `vendor/` : Le dossier où sont installées les dépendances référencées dans le fichier `composer.json` 
- `.env` : Fichier contenant la configuration de l'environnement d'exécution de l'application
- `composer.json` : Fichier listant les dépendances du projet ainsi que d'autres métadonnées

Toute notre implémentation est présente dans le dossier `src/`, le reste est généré par le framework.

Détails du dossiers `src` : 
- `Controller/` : Contient les controleurs de l'application. Un controleur contient les fonctions permettant le traitement des requêtes reçues.

- `Entity/` : Contient les classes utilisées par l'application. L'ORM doctrine permet de faire le lien avec les tables de la base de données afin de manipuler son contenu sous forme d'objet.

- `Repository/` : Pour chaque "Entity" déclarées, il est possible de déclarer un "Repository" qui contient des fonctions de requêtes personnalisées sur la base de données (écrites avec la syntaxe de l'ORM).

- `Migrations/` : Lors de changement des "Entities", qui doivent entrainer des changement dans la base de données, des migrations de la base de données sont générées dans ce dossier grâce à la ligne de commande : ```php bin/console make:migration```  
Pour exécuter les migrations il suffit d'executer : ```php bin/console doctrine:migrations:migrate```

###Frontend
Le backend est une application HTML/CSS/Javascript composé des dossiers suivants:
- `css/` : Dossier contenant les feuilles de style de l'application
- `img/` : Dossier contenant les images de l'application
- `js/` : Dossier contenant les fichiers javascripts de l'application. 
- `pages/` : Contient les squelettes html des pages de l'application
- `plugins/` : Dossier contenant les plugins utilisé dans notre application (bootstrap, jquery ect...)
- `*.php` : Pages principales de l'application (layouts)


###Base de données
Le schema de la base de données est disponible à l'adresse suivante :  
[DEPRECATED] [https://dbdiagram.io/d/5daf031202e6e93440f27fed](https://dbdiagram.io/d/5daf031202e6e93440f27fed)

