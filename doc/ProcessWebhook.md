# Procédé pour recevoir notification des pushes sur Github dans un canal Discord 

*Document provisoire*

Pour recevoir des notifications dans votre canal Discord à chaque fois que vous faites un push dans votre dépôt GitHub, vous pouvez suivre ces étapes :

Créez un webhook sur Discord :
Allez dans les paramètres de votre serveur Discord.
Sélectionnez “Intégrations”, puis “Webhooks”.
Cliquez sur “Créer un webhook”.
Donnez un nom à votre webhook et sélectionnez le canal où vous voulez recevoir les notifications.
Copiez l’URL du webhook.
Ajoutez le webhook à votre dépôt GitHub :
Rendez-vous dans les paramètres de votre dépôt GitHub.
Cliquez sur “Webhooks”, puis sur “Ajouter un webhook”.
Collez l’URL du webhook que vous avez copiée depuis Discord.
Ajoutez /github à la fin de l’URL.
Sélectionnez “application/json” comme type de contenu.
Choisissez les événements pour lesquels vous souhaitez recevoir des notifications. Pour un push, sélectionnez “Just the push event”.
Cliquez sur “Ajouter un webhook”.
Après avoir configuré le webhook, vous devriez recevoir des notifications dans votre canal Discord chaque fois que vous faites un push dans votre dépôt GitHub1.
