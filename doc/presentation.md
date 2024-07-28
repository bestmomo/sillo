# Présentation

[Retour à la table des matières](../README.md)

Je suis ravi de présenter mon projet de création de blog. Ce projet, dont le développement est déjà bien avancé, vise à offrir une plateforme complète et intuitive pour la publication et la gestion de contenu. L'idée première est de remplacer WordPress que j'utilise depuis plus de 10 ans pour mon blog par une application réalisée avec Laravel.

Laravel évolue rapidement, de nouvelles technologies comme Volt, Livewire et MaryUI sont désormais à notre disposition, transformant radicalement notre façon de coder.

La solution se compose de deux parties principales : le frontend et le backend, chacune avec des fonctionnalités spécifiques.

## Frontend

Le frontend est la partie visible de l'application que les utilisateurs interagissent directement. Voici les principales fonctionnalités :

* Page d'accueil :
  * Menu de navigation : Accès rapide aux différentes sections du site.
  * Derniers articles avec pagination : Affichage des articles récents avec une navigation facile pour parcourir les articles plus anciens.
  * Affichage par catégorie ou par série

* Articles :
  * Les articles peuvent comporter du code et des images.
  * Commentaires : Les utilisateurs peuvent lire et laisser des commentaires sur les articles. On peut répondre aux commentaires avec une certaine profondeur.

* Pages fixes :
  * Contenu statique comme les pages "À propos", "Conditions d'utilisation", etc.

* Page de contact :
  * Formulaire de contact pour permettre aux visiteurs de nous joindre directement depuis le site.

## Backend

Le backend est la partie de l'application où l'administrateur et les rédacteurs gèrent le contenu et les différentes configurations du site. Voici les principales fonctionnalités :

* Gestion des articles :
  * Création, édition, suppression et publication des articles.
* Gestion des pages :
  * Création et gestion des pages fixes.
* Gestion des catégories :
  * Création et gestion des catégories.
* Gestion des séries :
  * Création et gestion de séries d'articles sur un même thème. c’est quelque chose qui manque dans WordPress où les articles s’enchaînent en fonction des dates.

* Gestion des images :
  * Liste des images classées par années et par mois
  * Modification des images : Taille, couleurs, effets...

* Gestion des menus et sous-menus :
  * Personnalisation de la navigation sur le site.

* Gestion des profils utilisateurs :
  * Gestion des rôles des utilisateurs :
    * Le niveau principal et administrateur qui a tous les droits
    * Ensuite les rédacteurs pour rédiger des articles et gérer les commentaires correspondants
    * Enfin les utilisateurs peuvent juste ajouter et gérer des commentaires

* Gestion des contacts :
  * Consultation et gestion des messages envoyés via le formulaire de contact.
