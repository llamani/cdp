# [V1.0.0] [Last modified : 10/12/2019] Manuel d'installation

L'application propose un environnement Docker. Il est nécessaire de partager le disque où se trouve l'application pour que cela fonctionne.

Pour installer et lancer l'application il vous suffit de completer le fichier `.env` avec les paramètres de votre choix (ou garder les paramètres par défaut).  
**NE PAS MODIFIER LA VARIABLE `DATABASE_URL`.**  
**SI VOUS CHANGEZ LE PORT NGINX (NGINX_PORT=8000), PENSEZ A AUSSI LE MODIFIER DANS LA PREMIERE LIGNE DU FICHIER `front/js/utils.js`.**  

Ensuite il suffit d'executer le script `setup.sh`(linux) ou `setup.bat` (windows) de la façon suivante : 

    # Lancement classique
    $ ./setup.sh 
    $ setup.bat
    
Votre application est maintenant disponible à [http://127.0.0.1:8001]('http://127.0.0.1:8001') (ou http://127.0.0.1:{FRONT_PORT} si vous avez
changé le port)


Si vous ne pouvez pas executer le script, voici les commandes à executer : 

    # Copie les variables d'environnement pour le bon fonctionnement de Symfony
    $ cp ./.env api/
    
    # Construit et lance les containers docker. 
    $ docker-compose up -d 
    
    # Execute les migrations sur la base de données pour la mettre à jour
    $ docker-compose exec api php bin/console doctrine:migrations:migrate -n
    
# Problèmes possibles

Il est possible que les dépendances s'installent mal au déploiement du service docker "api" :
```$xslt
Warning: require(/usr/src/app/vendor/autoload.php): failed to open stream: No such file or directory in /usr/src/app/bin/console on line 15

Fatal error: require(): Failed opening required '/usr/src/app/vendor/autoload.php' (include_path='.:/usr/local/lib/php') in /usr/src/app/bin/console on line 15
```
Dans ce cas executez les commandes suivantes : 

    # Réinstallation des dépendances
    $ docker-compose exec api composer install
    
    # Copie les variables d'environnement pour symfony
    $ cp .env api/ 
    
    # Execute les migrations sur la base de données pour la mettre à jour
    $ docker-compose exec api php bin/console doctrine:migrations:migrate -n
    
# Charger des données par défaut

Utiliser la commande suivante pour charger des données dans la base de données

    $ docker-compose exec api php bin/console doctrine:fictures:load -n
      
En chargeant les fixtures, vous pourrez vous connecter sur l'application avec les informations suivantes : 
* email : laura@example.com / lucie@example.com / guillaume@example.com
* password : test
      
      
# Tests unitaires

Pour lancer manuellement les tests unitaires executez les commandes suivantes :  
LES TESTS NECESSITENT LE CHARGEMENT DES DONNEES FACTICES VU AU POINT PRECEDENT !

    # Tests backend
    $ docker-compose exec api php bin/phpunit 
  
    # Tests frontend
    $ docker-compose run testing


Vous pouvez ajouter l'option `--testdox` à votre commande `phpunit` pour afficher le nom des tests effectués.
