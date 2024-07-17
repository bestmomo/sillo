# La base de données (tables principales présentées)

[Retour à la lable des matières](../README.md)

## Table users

Cette table stocke les informations des utilisateurs enregistrés sur le site.

* **id** : Clé primaire auto-incrémentée pour chaque utilisateur.
* **name** : Nom de l'utilisateur.
* **email** : Adresse email unique de l'utilisateur.
* **password** : Mot de passe de l'utilisateur.
* **role** : Rôle de l'utilisateur (peut être 'user', 'redac' ou 'admin'). La valeur par défaut est 'user'.
* **valid** : Indicateur booléen pour savoir si l'utilisateur est validé. La valeur par défaut est false.
* **remember_token** : Token utilisé pour la fonctionnalité "Se souvenir de moi" lors de la connexion.
* **created_at** et **updated_at** : Horodatages automatiques de la création et de la mise à jour de l'utilisateur.

## Table posts

Cette table stocke les articles publiés sur le site.

* **id** : Clé primaire auto-incrémentée pour chaque article.
* **created_at** et **updated_at** : Horodatages automatiques de la création et de la mise à jour de l'article.
* **title** : Titre de l'article.
* **slug** : URL unique et lisible pour l'article.
* **body** : Contenu principal de l'article.
* **excerpt** : Extrait de l'article.
* **active** : Indicateur booléen pour savoir si l'article est actif. La valeur par défaut est false.
* **image** : Chemin de l'image associée à l'article (peut être nul).
* **user_id** : Référence à l'utilisateur (auteur) qui a créé l'article. Liée à la table users.
* **category_id** : Référence à la catégorie de l'article. Liée à la table categories.
* **serie_id** : Référence à la série à laquelle l'article appartient (peut être nul). Liée à la table series.
* **parent_id** : Référence à un autre article parent (pour les articles liés ou les suites d'articles, peut être nul).

## Table series

Cette table stocke les séries d'articles du site.

* **id** : Clé primaire auto-incrémentée pour chaque série.
* **title** : Titre unique de la série.
* **slug** : URL unique et lisible pour la série.
* **category_id** : Référence à la catégorie de la série. Liée à la table categories.
* **user_id** : Référence à l'utilisateur (créateur de la série). Liée à la table users.

## Table pages

Cette table stocke les pages fixes du site.

* **id** : Clé primaire auto-incrémentée pour chaque page.
* **slug** : URL unique et lisible pour la page.
* **title** : Titre de la page.
* **body** : Contenu de la page.

## Table menus

Cette table stocke les éléments de menu du site.

* **id** : Clé primaire auto-incrémentée pour chaque élément de menu.
* **label** : Étiquette du menu.
* **link** : Lien associé à l'élément de menu (peut être nul).
* **order** : Ordre d'affichage de l'élément de menu.

## Table submenus

Cette table stocke les sous-éléments de menu du site.

* **id** : Clé primaire auto-incrémentée pour chaque sous-élément de menu.
* **label** : Étiquette du sous-menu.
* **order** : Ordre d'affichage du sous-élément de menu.
* **link** : Lien associé au sous-élément de menu (par défaut '#').
* **menu_id** : Référence à l'élément de menu parent. Liée à la table menus.
