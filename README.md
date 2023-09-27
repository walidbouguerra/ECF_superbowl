# ECF_superbowl
ECF - Bachelor Développeur 22/24 : [Énoncé](https://github.com/walidbouguerra/ECF_superbowl/blob/main/documents/cahier_des_charges.pdf) 

## Documents du projet
[Manuel d'utilisation](https://github.com/walidbouguerra/ECF_superbowl/blob/main/documents/manuel_utilisation.pdf)  
[Maquettes](https://github.com/walidbouguerra/ECF_superbowl/blob/main/documents/maquettes.pdf)  
[Documentation technique](https://github.com/walidbouguerra/ECF_superbowl/blob/main/documents/documentation_technique.pdf)
[Diagramme d'utilisation](https://github.com/walidbouguerra/ECF_superbowl/blob/main/documents/diagramme_utilisation.pdf)  

### Gestion de projet
Kanban réalisé avec Trello  
[Image du kanban](https://github.com/walidbouguerra/ECF_superbowl/blob/main/documents/kanban.PNG)  
[Lien du kanban Trello](https://trello.com/invite/b/Nkz4Af41/ATTI5d14aec00a804ecbbf9785b14dd385ffFEC99A69/ecfsuperbowl)

### Base de données 
[Database](https://github.com/walidbouguerra/ECF_superbowl/blob/main/documents/database.sql)  
[MCD](https://github.com/walidbouguerra/ECF_superbowl/blob/main/documents/database.sql)

## App Web

Mettre le projet dans votre localhost  
Changer les informations de connexion à la base de données dans le fichier :  
```bash
  app_web/app/models/Model.php
```
Changer les informations de connexion pour envoyer des e-mails dans le fichier:  
```bash
  app_web/app/models/UserModel.php
  Dans la fonction sendmail
```


Lancer l'app dans votre nivagteur

```bash
  localhost/app_web
```
## App Mobile

Installer nodejs

```bash
  https://nodejs.org/fr
```

Créer un projet expo

```bash
  npx create-expo-app votreProjet
```

```bash
  Mettre le dossier api du projet app_mobile dans votre localhost
```

```bash
  Mettre les fichiers du dossier app dans votre projet
```

Remplacer les informations de connexion à la base de données

```bash
  Dans le fichier database.php du dossier api
```

Installer les dépendances

```bash
  npm install @react-navigation/native @react-navigation/native-stack
  npx expo install react-native-screens react-native-safe-area-context
```

Aller dans le dossier de votre projet

```bash
  cd votreProjet
```

Lancer le serveur

```bash
  npm run web 
```

## App Desktop

Ouvrez le projet dans votre IDE python   

Changer les informations de connexion à la base de données dans le fichier :  
```bash
  app_desktop/models/model.py
```
Lancer l'app dans votre IDE
