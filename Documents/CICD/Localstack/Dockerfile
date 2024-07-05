# Utilisez l'image officielle Node.js 14 avec Alpine comme base.
FROM node:14-alpine

# Créez le répertoire de travail pour votre application.
WORKDIR /usr/src/app

# Copiez les fichiers package.json et package-lock.json dans le répertoire de travail.
COPY package*.json ./

# Installez les dépendances de votre projet.
RUN npm install

# Copiez les autres fichiers et dossiers de votre projet dans le conteneur.
COPY . .

# Exposez le port sur lequel votre application va s'exécuter.
EXPOSE 3000

# Définissez la commande pour démarrer votre application.
CMD [ "node", "src/app.js" ]
