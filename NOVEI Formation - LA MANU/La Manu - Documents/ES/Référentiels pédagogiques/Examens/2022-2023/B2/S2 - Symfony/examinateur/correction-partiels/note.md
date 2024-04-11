# Setup Projet

- Créer le projet avec l'outil de votre choix : symfony-cli, composer ou docker
- Configurer la base de donnée du projet lorsque cela est nécessaire.
- Peuple les tables `categories` et `task_status` avec les données de tests fournis en annexe lorsqu'elles seront créées.

# Template

- Ajoutez les cdn de bootstrap et les styles fournis en source au template de base de l'application.
- Créez un template `nav.html.twig` et y mettre le code de la barre de navigation de l'utilisateur connecté.
- Integrez ce template partiel aux templates de base des pages de l'utilisateur connecté.
- Modifiez la configuration de twig pour utiliser le template bootstrap 5 sur tous les formulaires de l'application.

# Doctrine ORM

- Générer la classe d'utilisateur de l'application symfony
- Modifier l'entité créée par la commande précédente pour la compléter avec les manquante manque que vous trouvez dans le Merise fourni.
- Générer les entites Task, TaskStatus, Category de l'application.
- Créer les relations entre entités de l'application en vous basant sur le Merise fourni.
- Générer les fichiers de migration
- Appliquer les migrations à la base de données.

# Authentification

- Générer un système d'authentification basé sur l'authentication par formulaire pour l'application à l'aide de la commande symfony apropriée.
- Modifier la méthode `onAuthenticationSuccess()` de la classe d'authentication générée pour rédiger l'utilisateur vers la page d'accueil en cas de succès de l'authentification.

`/!\ : Voir le message affiché dans votre terminal à issue de la génération du système d'authentification`

# Formulaire

- Générer les types de formulaire permettant d'hydrater l'entité suivante :
  - Task
  - User (utilisateur)
- Définir des règles de validation pour les champs des formulaires nécessitant une validation des données envoyées par l'utilisateur.

# Routing - Controller - Vue

# UserController

- Générez le contrôleur des fonctionnalités de l'utilisateur
- Créez la méthode `create` permettant de créer un utilisateur.
- Créez la méthode `update` permettant de modifier les informations suivantes de l'utilisateur :
  - Nom
  - Prénom
  - avatar

/!\ Vous pouvez retirer des champs d'un formulaire en utilisant sa méthode remove.

Exemple : $userForm->remove('age');

# HomeController

- Générer le contrôleur de la page d'accueil de l'utilisateur.
- Dans la méthode `index` du contrôleur :
  - Récupérer et stocker la liste des catégories
  - Transmettre la variable contenant les categories au template chargé par le contrôleur.
- Dans le template `index.html.twig`:
  - Boucler sur les catégories pour afficher les cartes des catégories
  - Dans chaque catégories, boucler sur la liste de tâches et afficher celle appartenant à l'utilisateur courant.
  - Chaque item (tâche) doit contenir un lien de modification et de suppression fonctionnel.
  - Dans le dernier item de la carte catégorie, créer un lien vers la page de création de tâche. Le lien doit transmettre en paramètre d'url (GET) l'identifiant de la catégorie.

# TaskController

- Générer le contrôleur des fonctionnalités des tâches

## Creation de tâche :

- Récupérer la categories correspondant à l'ID passé en paramètre d'url.
- Récupérer l'utilisateur authentifié courant de l'application
- Créer une instance de l'entité Task et définir ses propriétés `category` et `user` avec les données récupérée ci-dessus.
- Créer un formulaire de création de tâche et le prépeuple avec les données de l'instance de l'entité Task.
- Afficher le formulaire dans le template `task/create.html.twig` que vous créerez.

- Traitez les données du formulaire lors qu'il sera soumis par l'utilisateur
- Persistez la tâche dans la base de données et créez un message flash pour notifier l'utilisateur.

## Édition de tâche :

- Créez la méthode qui permet de mettre à jour une tâche.
- Implémenter le code permettant de réaliser la mise à jour d'une tâche.

## Suppression de tâche :

- Créez la méthode qui permet de supprimer une tâche.
- Implémenter le code permettant de réaliser la suppression d'une tâche.

/!\ La confirmation de suppression peut être ignorée.

# Upload d'image

- Installer et configure le bundle VichUploader pour la réalisation de l'upload de fichier.
- Configurer l'entité User pour que l'utilisateur puisse ajouter une photo à son profil dans l'application.
- Modifier le formulaire de création d'utilisateur pour qu'il puisse téléverser une photo de profil lors de la création de son compte.

/!\ L'upload d'image sur l'entité "Utilisateur" peut générer une erreur qui peut être corrigée par l'implémentation de l'interface `Serializer` comment dans l'exemple fourni en annexe.

# DQL - QueryBuilder

- Ajouter une formulaire de recherche à la page d'accueil de l'application.
- Implementer dans le repository TaskRepository une méthode permettant à un utilisateur de réaliser une recherche sur les noms des tâches.
- Implementer dans l'application le code permettant de faire recherche et d'afficher le resulat dans la page d'accueil de l'application.

# Annexe 1

## Types de tâche

- Personnelle (#0369a1)
- Professionnelle (#059669)
- Bénévolat (#f97316)
- Loisir (#9333ea)
- Domestique (#ea580c)

## Status

- En cours
- Terminé
- Annulé

# Annexe 2

```php

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
...
class User implements UserInterface, PasswordAuthenticatedUserInterface, Serializable
{
   ...

    #region Functions

    /**
     * String representation of object
     * Should return the string representation of the object.
     * @return string|null Returns the string representation of the object or `null`
     */
    function serialize(): string|null
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
            $this->firstname,
            $this->lastname,
            $this->avatar,
            $this->createdAt,
            $this->updatedAt
        ]);
    }

    /**
     * Constructs the object
     * Called during unserialization of the object.
     *
     * @param string $data The string representation of the object.
     * @return void
     */
    function unserialize($data): void
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->firstname,
            $this->lastname,
            $this->avatar
        ) = unserialize($data);
    }
}
```
