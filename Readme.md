# ZipProject

## Pré-requis

• Symfony 6 et composer (https://symfony.com/doc/current/setup.html)  
• npm/node (https://nodejs.org/fr)

## Installation

• Cloner le projet github dans un dossier  
• Installer les dépendances pour le projet 
```bash
cd /projet 

composer install
npm install
```

## Lancer l'application

• Lancer les commandes suivantes dans 2 terminaux
```bash
symfony server:start

npm run watch
```

## Spécifications

• Placer les dossiers sources dans le même repertoire que le projet  
• Si on rencontre cette erreur: "ZipArchive not found", aller dans le fichier de configuration php.ini de notre
installation php et rajouter cette ligne en fin de fichier 
```extension=zip.dll```

## Eteindre les serveurs
• Lancer la commande ci-dessous depuis un autre terminal
```bash
symfony server:stop
```

• Ctrl + C dans le terminal qui a lancé 
```bash
npm run watch
```

