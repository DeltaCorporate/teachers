# Maquette application mobile Teach'r
Cette application est développé sur la base de :
- React native pour le front end
- Symfony pour le backend.

Cette application permet de mettre en relation des professeurs à des étudiants. Ce n'est bien sûr qu'une ébauche mais déjà capable de gérer quelques actions.

# Installation

### Prérequis
Assurez vous d'avoir les élèments suivants:
- Un serveur mysql version 5.7
- Un serveur nodeJs
- openjdk8
- php
- composer
#### _Vous pouvez utiliser la commande ci dessous pour nodeJs et openjdk8_

``choco install -y nodejs.install openjdk8``

### _Installez le repo sur votre machine_
``git clone https://github.com/DeltaCorporate/teachers.git``

``cd teachers``

### Il vous faut d'abord lancer l'api. Pour cela vous devez vous rendre dans le dossier `api/`

- Tapez maintenant la commande ``ipconfig`` afin de récupérer votre addresse ipv4 (essentielle)
- Modifiez le fichier .env avec les bonnes informations de la base de données
- Tapez ensuite les commandes suivantes 
``composer install``
``php bin/console doctrine:database:create``
``php -S IPV4:8000 -t public`` (n'utilisez surtout pas la commande `symfony serve` car elle fera tourner votre api sur le localhost)
- Retournez ensuite dans le dossier principal
``cd ..``
- Modifiez le fichier config.js avec la bonne ipv4
- Installez les modules nodeJs
```yarn install``` (si yarn n'est pas installer tapez d'abord ``npm install yarn -g``)
- assurez vous d'avoir le package expo installé sur votre pc sinon tapez la commande
``npm install expo-cli --g``

Votre application est maintenant allumé.
Pour avoir un visuel je vous conseille d'installer l'application [Expo](https://play.google.com/store/apps/details?id=host.exp.exponent&referrer=www)

Ensuite connectez vous en scannant le code QR sur votre terminal.

Il est nécessaire pour que le visuel s'affiche que votre téléphone et votre machine soit sur le même réseau internet.