# Manuel d'installation

L'application propose un environnement Docker.

Pour installer et lancer l'application il vous suffit de completer le fichier `.env` avec les paramètres de votre choix.
**NE PAS MODIFIER LA VARIABLE `DATABASE_URL`.**

Ensuite il suffit d'executer le script `setup.sh` de la façon suivante : 

    # Lancement classique
    $ ./setup.sh 
    
    # Lancement en forçant la reconstruction des containers dockers à partir de leur dockerfile
    $ ./setup.sh --build
    
Votre application est maintenant disponible à http://127.0.0.1:{FRONT_PORT}.

Si vous ne pouvez pas executer le script, voici les commandes à executer : 

    # Copie les variables d'environnement pour le bon fonctionnement de Symfony
    $ cp ./.env api/
    
    # Construit et lance les containers docker. Optionnel : le flag (--build) permet de reconstruire les containers à partir des Dockerfile
    $ docker-compose up -d (--build)
    
    # Execute les migrations sur la base de données pour la mettre à jour
    $ docker-compose exec api php bin/console doctrine:migrations:migrate -n
      
 