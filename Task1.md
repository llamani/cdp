## Tâches pour le Sprint 1

| ID | User Stories ID | Tâche | Charge | Responsable | Dépendances |
| -- | --------------- | ------| ------ | ----------- | ----------- |
| T1 | - | Mise en place de l'architecture du projet. un dossier **app** contenant le projet en PHP avec Symfony 4.3. L'architecture du back-end est expliquée à la fin de ce document.| | | |
| T2 | - | Mise en place de l'architecture de la base de données MySQL. Rédaction du schéma de la base de données (expliqué à la fin du document). | | | |
| T3 | US9 | Création de la page HTML "/issues" affichant l'ensemble des issues du backlog du projet, séparées par leur statut (TODO / IN PROGRESS / DONE). La page doit contenir un bouton "Ajouter une issue", ainsi que des boutons "Modifier" et "Supprimer" à coté de chaque issue affichée sur la page.
| T4 | US11 | Création du formulaire d'ajout d'une issue (page "/add-issue"), accessible par le bouton "Ajouter une issue" sur la page "/issues".
| T5 | US11 | Création du formulaire de modification d'une issue (page "/update-issue/{id}"), accessible par le bouton "Modifier" sur la page "/issues".
| T6 | US12 | Affichage d'une pop-up de confirmation de suppression au clic du bouton "Supprimer" de la page "/issues".
| T7 | US14 | Création de la page HTML "/tasks" affichant l'ensemble des tâches du projet, séparées par leur statut (TODO / IN PROGRESS / DONE). La page doit contenir un bouton "Ajouter une tâche", ainsi que des boutons "Modifier" et "Supprimer" à coté de chaque tâche affichée sur la page.
| T8 | US16 | Création du formulaire d'ajout d'une tâche (page "/add-task"), accessible par le bouton "Ajouter une tâche" sur la page "/tasks".
| T9 | US16 | Création du formulaire de modification d'une tâche (page "/update-task/{id}"), accessible par le bouton "Modifier" sur la page "/tasks".
| T10 | US17 | Affichage d'une pop-up de confirmation de suppression au clic du bouton "Supprimer" de la page "/tasks".
| T11 | US9 | Récupérer l'ensemble des issues de la base de données dans le backend et les renvoyer au format JSON au front-end. (Définir une route dans le backend et un traitement spécifique dans un controleur)
| T12 | US11 | Récupérer les données du formulaire d'ajout dans le backend, les traiter pour ensuite sauvegarder une nouvelle issue dans la base de données.
| T13 | US12 | Récupérer les données du formulaire de modification dans le backend, les traiter pour ensuite modifier l'issue concernée dans la base de données.
| T14 | US12 | Récupérer l'identifiant de l'issue à supprimer dans le backend, pour ensuite supprimer l'issue concernée dans la base de données.
| T15 | US14 | Récupérer l'ensemble des tâches de la base de données dans le backend et les renvoyer au format JSON au front-end. (Définir une route dans le backend et un traitement spécifique dans un controleur)
| T16 | US16 | Récupérer les données du formulaire d'ajout dans le backend, les traiter pour ensuite sauvegarder une nouvelle tâche dans la base de données.
| T17 | US16 | Récupérer les données du formulaire de modification dans le backend, les traiter pour ensuite modifier la tâche concernée dans la base de données.
| T18 | US17 | Récupérer l'identifiant de la tâche à supprimer dans le backend, pour ensuite supprimer l'issue concernée dans la base de données.
