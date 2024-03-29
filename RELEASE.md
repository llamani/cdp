# Releases

## Archive des releases

https://github.com/llamani/cdp/releases

## Release 3

Release 3 (sprint 3) : 10/12/2019 15:50
Identifiant du commit de la release : cde17d4e3b07c5791e1fa12b476b78dc4133e2ec

### Liste des issues réalisées

| ID | User Story | Priorité | Difficulté |
| -- | ---------- | -------- | ---------- |
| US14 | En tant qu'utilisateur, je souhaite être documenté sur le fonctionnement de l'application à l'aide d'une page "A propos". | 2 | 1 |
| US16 | En tant qu'utilisateur, je souhaite pouvoir ajouter/modifier/consulter/supprimer une release. J'ajoute/modifie une release via un formulaire (pré-rempli dans le cas de la modification) qui s'ouvre grâce à un bouton "Ajouter une release" présent en haut de la page affichant l'ensemble des releases du projet/ un bouton "Modifier" situé à côté de la release concernée. Il me faudra alors saisir dans le formulaire, un nom de release (maximum 50 caractères), un lien vers les sources (une URL) et aussi une manière facultative de documenter la release (par une zone de texte ou l'upload d'un fichier de documentation). La release devra être créee/modifiée au clic du bouton "Confirmer" en bas du formulaire. Au clic du bouton "Annuler", l'utilisateur devra être redirigé sur la page affichant l'ensemble des releases du projet. Je supprime à l'aide d'un bouton "Supprimer" situé à côté de la release concernée. | 2 | 3 |
| US19 | En tant qu'utilisateur, je souhaite voir la progression de chaque issue en fonction du statut des tâches liées à elle à l'aide d'une barre de progression et d'un pourcentage. | 2 | 3 |
| US20 | En tant qu'utilisateur, je souhaite pouvoir générer un burn-down chart à la fin des sprints d'un projet afin d'estimer la charge de travail possible de l'équipe. | 2 | 8 |

* Sources de la release : https://github.com/llamani/cdp/releases/tag/0.3.0  
* Manuel d'installation disponible dans [INSTALL.md](./INSTALL.md)
* Documentation disponible dans [DOCUMENTATION.md](./DOCUMENTATION.md)

### Retrospective

A la fin de ce sprint 3, nous estimons avoir atteint la majorité de nos objectifs. Le site contient le CRUD de tous les artefacts, ainsi que
des autres features améliorant l'expérience utilisateur (drag-and-drop, burndown chart, suivi des issues). 
Au cours de ce projet, nous avons rencontré les difficultés suivantes:
* Utilisation de Symfony : apprehension de l'architecture et commandes
* Mise en place de Travis : découverte de la technologie et configuration
* Tests Puppeteer : problèmes non-résolus concernant les requêtes asynchrones et l'authentification


## Release 2

Release 2 (sprint 2) : 22/11/2019 - 9:30  
Identifiant du commit de la release : 66b0f36694c3bcbeb1f923839bb2d3232890120d

### Liste des issues réalisées

| ID | User Story | Priorité | Difficulté |
| -- | ---------- | -------- | ---------- |
| US2 | En tant que visiteur, je souhaite pouvoir me connecter sur l'application afin d'accéder à mes projets en saisissant mon email et mon mot de passe. | 2 | 2 | 1 |
| US4 | En tant que propriétaire, je souhaite pouvoir ajouter/consulter/supprimer des membres (collaborateurs) d'un de mes projets. Je souhaite ajouter un membre grâce à un champ de recherche exploitant les utilisateurs enregistrés dans l'application ou en envoyant un mail d'invitation à une personne non inscrite. Je souhaite pouvoir consulter la liste des membres du projet en cliquant sur le bouton "Membres" situé à côté du projet concerné, sur l'écran où tous les projets sont affichés. Depuis cette page, je souhaite pouvoir supprimer un collaborateur du projet à l'aide d'un bouton "Supprimer". | 2 | 8 | 2 |
| US6|  En tant qu'utilisateur, je souhaite pouvoir glisser une US d'une liste à une autre afin de changer son statut | 2 | 5 | 1 |
| US10|  En tant qu'utilisateur, je souhaite pouvoir glisser une tâche d'une liste à une autre afin de changer son statut | 2 | 5 | 1 |
| US13 | En tant qu'utilisateur, je souhaite pouvoir définir/modifier/consulter/supprimer un sprint afin de planifier les issues à réaliser pour la prochaine release. J'ajoute/modifie en remplissant un formulaire (pré-rempli dans le cas de la modification) disponible au clic d'un bouton "Créer un sprint" en haut de l'écran listant les sprints du projet ou d'un bouton "Modifier" situé à côté du sprint concerné. Je devrais donc sélectionner l'ensemble des issues à rattacher à ce sprint grâce à un système de case à cocher de toutes les issues du projet. Il faudra ensuite renseigner la date de début de sprint et la date de fin, puis cliquer sur le bouton "Confirmer" pour ajouter ce nouveau sprint. Au clic du bouton "Annuler", la création/la modification devra être annulée et l'écran listant l'ensemble des sprints doit apparaître. Je supprime à l'aide d'un bouton "Supprimer" à côté du sprint concerné.| 2 | 3 | 2 |
| US15 | En tant qu'utilisateur je souhaite créer/modifier/consulter/supprimer un test. J'ajoute/modifie un test en saisissant les champs suivants dans un formulaire (pré-rempli dans le cas de la modification): le nom (maximum 50 caractères), une description (maximum 255 caractères), le type du test, le résultat attendu (maximum 255 caractères), le résultat obtenu (maximum 255 caractères), la date de réalisation, les membres d'équipe responsables, ainsi que le statut (PASS, FAIL, UNKNOWN). L'id du test est généré automatiquement. En bas du formulaire deux boutons "Confirmer" et "Annuler" doivent être présents. Dans le cas d'un clic sur le bouton "Annuler", l'utilisateur doit être redirigé vers la page listant l'ensemble des tests. Je supprime à l'aide d'un bouton "Supprimer" situé à côté du test concerné.| 2 | 3 | 2 |

* Sources de la release : https://github.com/llamani/cdp/releases/tag/0.2.0  
* Manuel d'installation disponible dans [INSTALL.md](./INSTALL.md)
* Documentation disponible dans [DOCUMENTATION.md](./DOCUMENTATION.md)

## Release 1 

Release 1 (sprint 1) : 08/11/2019 - 13:00  
Identifiant du commit de la release : 75e8200a3ff109cc7508817610a6a090bc879ff6

### Liste des issues réalisées

| ID | User Story | Priorité | Difficulté |
| -- | ---------- | -------- | ---------- |
| US1 | En tant que visiteur, je souhaite pouvoir m'inscrire sur l'application afin d'accéder aux fonctionnalités de celle-ci. Pour m'inscrire je dois saisir dans un formulaire mon adresse email, un mot de passe (entre 6 et 255 caractères) ainsi que mon nom et mon prénom (maximum 50 caractères) avant de valider mes saisies. | 2 | 3 |
| US3 | En tant que propriétaire, je souhaite pouvoir créer/modifier/supprimer/visualiser un projet. Je crée/modifie un projet à l'aide d'un bouton faisant apparaitre un formulaire (pré-rempli dans le cas de la modification). Je souhaite ensuite pouvoir saisir son nom (maximum 50 caractères), une description (maximum 255 caractères) ainsi qu'une date de début pour mon nouveau projet. En bas du formulaire deux boutons "Confirmer" et "Annuler" doivent être présents. Dans le cas d'un clic sur le bouton "Annuler", l'utilisateur doit être redirigé vers la page listant l'ensemble des projets auxquels j'appartiens. Je souhaite pouvoir supprimer un projet à l'aide d'un bouton "Supprimer".  | 2 | 3 |
| US5 | En tant qu'utilisateur, je souhaite pouvoir consulter l'ensemble du backlog et constater l'avancement du projet grâce à un écran contenant 3 listes : TODO/IN PROGRESS/DONE. | 1 | 2 |
| US7 | En tant qu'utilisateur, je souhaite pouvoir ajouter/modifier/supprimer une issue à mon backlog. J'ajoute/modifie en saisissant les champs suivants dans un formulaire (pré-rempli dans le cas de la modification) : Un nom (maximum 50 caractères), une description (maximum 255 caractères), une priorité (faible, moyenne ou élevée) ainsi qu'une difficulté (facile, intermédiaire ou difficile). Un identifiant unique sera généré automatiquement pour l'issue. Le statut "TODO" sera attribué par défaut. Je souhaite soumettre la création de l'issue au clic du bouton "Confirmer". Au clic du bouton  "Annuler", je souhaite revenir à l'écran ou sont affichées toutes les issues du projet. Je souhaite que cette action soit disponible grâce à un bouton "Ajouter une issue" situé en haut de l'écran affichant toutes les issues du projet/ "Modifier" situé à côté de l'issue concernée. je souhaite pouvoir supprimer une issue à l'aide d'un bouton "Supprimer".  | 1 | 3 |
| US9 | En tant qu'utilisateur, je souhaite pouvoir consulter l'ensemble des tâches du projet et constater leur avancement grâce à un écran contenant 3 listes : TODO/IN PROGRESS/DONE. | 1 | 2 |
| US11 | En tant qu'utilisateur, je souhaite pouvoir ajouter/modifier/consulter/supprimer une tâche à mon projet. J'ajoute/modifie en saisissant les champs suivants dans un formulaire (pré-rempli dans le cas de la modification) : Un nom (maximum 50 caractères), une description (maximum 255 caractères), une charge (un décimal correspondant au nombre de jour/homme), les issues associés à la tâche (via une liste déroulantes à choix multiples contenant l'ensemble des issues du projet), les membres affectés à cette tâche (aussi avec une liste déroulante à choix multiples facultatifs) et enfin les dépendances avec d'autres tâches (liste à choix multples facultatives contenant l'ensemble des tâches du projet). Un identifiant unique sera généré automatiquement pour cette nouvelle issue. Le statut "TODO" sera attribué par défaut. Je souhaite soumettre la création de la tâche au clic du bouton "Confirmer". Au clic du bouton  "Annuler", je souhaite revenir à l'écran ou sont affichées toutes les tâches du projet. Je souhaite que cette action soit disponible grâce à un bouton "Ajouter une tâche" situé en haut de l'écran affichant toutes les tâches du projet/ un bouton "Modifier" situé  à côté de la tâche concernée. Je supprime une tâche à l'aide d'un bouton "Supprimer" à côté de la tâche concernée.| 1 | 3 |

* Sources de la release : https://bfs.u-bordeaux.fr/telecharge.php?choix=files/a40c6f267d164e8669c45d0115c9e9a5/RELEASE1.tar.gz  
* Manuel d'installation disponible dans [INSTALL.md](./INSTALL.md)
* Documentation disponible dans [DOCUMENTATION.md](./DOCUMENTATION.md)