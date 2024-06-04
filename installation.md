## Installation

[Retour à la lable des matières](README.md)

Vous voulez participer ? Vous pouvez facilement installer le projet en local.

Clonez le code :

`git clone git@github.com:bestmomo/sillo`

Créez un fichier **.env** avec vos éléments pour la connexion à la base de données et procédez à l'installation :

`composer install`
`npm install`
`php artisan migrate --seed`
`npm run dev`

La population crée 5 utilisateurs dont un administrateur avec l'email admin@example.com et le mot de passe **password**. Elle crée aussi des catégories, des séries, des articles (les images sont déjà présentes), des pages, des menus, des commentaires et des contacts. Vous obtenez donc un site fonctionnel et déjà garni.
