## Installation

[Retour à la la table des matières](README.md)

### &nbsp;I / Récupérez le dépôt:

##### Optez pour l'un des moyens ci-dessous:

- Pour 'juste' avoir tout en local en 1 minute
  (Même pas besoin d'avoir de compte GitHub et néanmoins récupérer tout le code pleinement opérationnel !):<br>
  ![Comment télécharger un dépôt](..\public\storage\imgs_doc\get_repository_by_zip.png)
  Décompressez puis passez au **II /** ci-dessous.
  
<p align="center">Ou:</p>

- Vous voulez avoir tout cela, mais en plus, la possibilité de partager vos propres changements à venir ?<br>
      1. ***Forkez*** le projet **[sillo **de** BestMomo](https://github.com/bestmomo/sillo)**
      <sub>(À ce stade, il vous faut vous loguer dans votre compte Github, voire le créer en 30 seconde si vous n'en avez pas déjà un...)</sub><br>
      ![Comment Fork un dépôt](..\public\storage\imgs_doc\fork.png)<br>
      2. ***Clonez*** le code de **VOTRE** copie du dépôt distant (Chez GitHub) sur votre serveur local via SSH :<br>
    `git clone git@github.com:Votre_Pseudo_GitHub/sillo.git`<br>
    
    *En cas de doute, juste récupérer cela ici:*<br>
      ![Comment Fork un dépôt](..\public\storage\imgs_doc\clone.png)<br>
    
    <sub>(Si cela échoue, autant régler le problème, car pour uploader (***push***) vos futurs changements, ne serait-ce sur votre propre dépôt distant, il le faudra! Dans ce cas: [Installez votre clé SSH](https://docs.github.com/fr/authentication/connecting-to-github-with-ssh/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent))</sub>
  
### II / Installez votre propre version locale: 

Créez un fichier **.env** (Copier/Coller du **.env_example** que vous trouvez à la racine) et adaptez si souhaité, avec vos éléments, comme par exemple d'autres paramètres pour la connexion à la base de données.<br>
Puis procédez à l'installation :<br>

  `composer install`<br>
  `php artisan key:generate`<br>
  `php artisan storage:link`<br>
  `npm install`<br>
  `php artisan migrate --seed`<br>
  `npm run dev`
  
  La population crée 5 utilisateurs dont un administrateur avec l'email admin@example.com et le mot de passe **password**. Elle crée aussi des catégories, des séries, des articles (les images sont déjà présentes), des pages, des menus, des commentaires et des contacts. Vous obtenez donc un site fonctionnel et déjà garni.

