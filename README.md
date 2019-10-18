# Conduite de projet 2019

## Objectif
L'objectif de ce projet est de développer une application permettant la gestion de projet.

## Technologies

## L'équipe 

* Lucie ALMANSA
* Laura LAMANI
* Guillaume NEDELEC
  
## Backlog

| ID | User Story | Priorité | Difficulté |
| -- | ---------- | -------- | ---------- |
| 1 | En tant qu'utilisateur, je souhaite pouvoir m'inscrire sur l'application afin d'accéder aux fonctionnalités de celle-ci. Pour m'inscrire je dois saisir dans un formulaire mon adresse email, un mot de passe (entre 6 et 255 caractères) ainsi que mon nom et mon prénom (maximum 50 carctères) avant de valider mes saisies. | 1 | 1 |
| 2 | En tant qu'utilisateur, je souhaite pouvoir me connecter sur l'application afin d'accéder à mes projets en saisissant mon email et mon mot de passe. | 1 | 1 |
| 3 | En tant qu'utilisateur, je souhaite pouvoir créer un nouveau projet à l'aide d'un bouton faisant apparaitre un formulaire. Je souhaite ensuite pouvoir saisir son nom (maximum 50 caractères), une description (maximum 255 caractères) ainsi qu'une date de début pour mon nouveau projet. | 1 | 1 |
| 4 | En tant qu'utilisateur, je souhaite pouvoir ajouter des membres (collaborateurs) à un de mes projet afin qu'il puisse travailler dessus. Je souhaite les ajouter grâce à un champ de recherche exploitant les utilisateurs enregistés dans l'application ou en envoyant un mail d'invitation à une personne non inscrite. | 1 | 1 |
| 5 | En tant qu'utilisateur, je souhaite pouvoir consulter l'ensemble du backlog et constater l'avancement du projet grâce à un écran contenant 3 listes : TODO/IN PROGRESS/DONE. | 1 | 1 |
| 6 | En tant qu'utilisateur, je souhaite pouvoir ajouter une nouvelle issue à mon backlog en saisissant les champs suivants dans un formulaire : Un nom (maximum 50 caractères), une description (maximum 255 caractères), une priorité (faible, moyenne ou élevée) ainsi qu'une difficulté (facile, intermédiaire ou difficile). Un identifiant unique sera généré automatiquement pour cette nouvelle issue. Le statut "TODO" sera attribué par défaut. Je souhaite soumettre la création de l'issue au clic du bouton "Confirmer". Au clic du bouton  "Annuler", je souhaite revenir à l'écran ou sont affichées toutes les issues du projet. Je souhaite que cette action soit disponible grâce à un bouton "Ajouter une issue" situé en haut de l'écran affichant toutes les issues du projet. | 1 | 1 |
| 7 | En tant qu'utilisateur, je souhaite pouvoir modifier une issue à l'aide du même formulaire que l'ajout, pré-rempli avec les informations de l'issue. Cela doit être possible grâce à un bouton "Modifier" situé à coté de l'issue concernée sur l'écran affichant toutes les issues du projet. | 1 | 1 |
| 8 | En tant qu'utilisateur, je souhaite pouvoir supprimer une issue à l'aide d'un bouton me demandant la confirmation de la suppression. Un bouton de validation entrainera la suppression et un bouton "Annuler" permettra d'annuler la suppression. Je souhaite que cette action soit disponible grâce à un bouton "Supprimer" situé à coté de l'issue concernée sur l'écran affichant toutes les issues du projet. | 1 | 1 |
| 9 | En tant qu'utilisateur, je souhaite pouvoir exporter mon backlog au format pdf grâce à un bouton "Exporter en pdf" situé sur l'écran affichant toutes les issues du projet. | 1 | 1 |
| 10 | En tant qu'utilisateur, je souhaite pouvoir consulter l'ensemble des tâches du projet et constater leur avancement grâce à un écran contenant 3 listes : TODO/IN PROGRESS/DONE. Je souhaite aussi pouvoir filtrer les tâches affichées en fonction des issues. | 1 | 1 |
| 11 | En tant qu'utilisateur, je souhaite pouvoir ajouter une nouvelle tâche à mon projet en saisissant les champs suivants dans un formulaire : Un nom (maximum 50 caractères), une description (maximum 255 caractères), une charge (un décimal correspondant au nombre de jour/homme), les issues associés à la tâches (via une liste déroulantes à choix multiples contenant l'ensemble des issues du projet), les membres affectés à cette tâches (aussi avec une liste déroulante à choix multiples facultatives) et enfin les dépendances avec d'autres tâches (liste à choix multples facultatives contenant l'ensemble des tâches du projet). Un identifiant unique sera généré automatiquement pour cette nouvelle issue. Le statut "TODO" sera attribué par défaut. Je souhaite soumettre la création de la tâche au clic du bouton "Confirmer". Au clic du bouton  "Annuler", je souhaite revenir à l'écran ou sont affichées toutes les tâches du projet. Je souhaite que cette action soit disponible grâce à un bouton "Ajouter une tâche" situé en haut de l'écran affichant toutes les tâches du projet. | 1 | 1 |
| 12 | En tant qu'utilisateur, je souhaite pouvoir modifier une tâche à l'aide du même formulaire que l'ajout, pré-rempli avec les informations de la tâche.  Cela doit être possible grâce à un bouton "Modifier" situé à coté de la tâche concernée sur l'écran affichant toutes les tâches du projet. | 1 | 1 |
| 13 | En tant qu'utilisateur, je souhaite pouvoir supprimer une tâche à l'aide d'un bouton me demandant la confirmation de la suppression. Un bouton de validation entrainera la suppression et un bouton "Annuler" permettra d'annuler la suppression. Je souhaite que cette action soit disponible grâce à un bouton "Supprimer" situé à coté de la tâche concernée sur l'écran affichant toutes les tâches du projet. | 1 | 1 |
| 14 | En tant qu'utilisateur, je souhaite pouvoir exporter l'ensemble des tâches au format pdf grâce à un bouton "Exporter en pdf" situé sur l'écran affichant toutes les tâches du projet. | 1 | 1 |
| 15 | En tant qu'utilisateur, je souhaite pouvoir accéder à l'ensemble des sprints du projet grâce à une page spécifique. | 1 | 1 |
| 16 | En tant qu'utilisateur, je souhaite pouvoir définir un nouveau sprint afin de planifier les issues à réaliser pour la prochaine release. Je souhaite donc remplir un formalaire disponible au clic d'un bouton "Créer un sprint" en haut de l'écran listant les sprints du projet. Je devrais donc sélectionner l'ensemble des issues à rattacher à ce sprint grâce à un système de case à cocher de toutes les issues du projet. Il faudra ensuite renseigner la date de début de sprint et la date de fin, puis cliquer sur le bouton "Confirmer" pour ajouter ce nouveau sprint. Au clic du bouton "Annuler", la création devra être annuler et l'écran listant l'ensemble des sprints doit apparaître. | 1 | 1 |
| 17 | En tant qu'utilisateur, je souhaite pouvoir modifier un sprint existant à l'aide du même formulaire que la création, pré-rempli avec les informations de du sprint ciblé. Cela doit être possible grâce à un bouton "Modifier" situé à coté du sprint concerné, sur l'écran affichant tous les sprints du projet. | 1 | 1 |
| 18 | En tant qu'utilisateur, je souhaite pouvoir supprimer un sprint à l'aide d'un bouton me demandant la confirmation de la suppression. Un bouton de validation entrainera la suppression et un bouton "Annuler" permettra d'annuler la suppression. Je souhaite que cette action soit disponible grâce à un bouton "Supprimer" situé à coté du sprint concerné, sur l'écran affichant tous les sprints du projet.| 1 | 1 |
| 19 | En tant qu'utilisateur, je souhaite pouvoir accéder à l'ensemble des releases du projet grâce à une page spécifique. | 1 | 1 |
| 20 | En tant qu'utilisateur, je souhaite pouvoir ajouter une nouvelle release via un formualire qui s'ouvre grâce à un bouton "Ajouter une release" présent en haut de la page affichant lensemble des releases du projet. Il me faudra alors saisir dans le formulaire, un nom de release (maximum 50 caractères), un lien vers les sources (une URL) et aussi une manière facultatives de dcoumenter la release (par une zone de texte ou l'upload d'un fichier de documentation). La release devra être créer au clic du bouton "Confirmer" en bas du formulaire. Au clic du bouton "Annuler", l'utilisateur devra être redirigé sur la page affichant l'ensemble des releases du projet. | 1 | 1 |

# on fait ou pas ?
* consulter modifier supprimer un projet
* consulter / enlever membre d'un projet 
* role des users 

