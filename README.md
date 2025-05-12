# Le Piège Photographique Connecté

Le Piège Photographique Connecté est un projet réalisé dans le cadre de notre année de Terminale STI2D au lycée Saint-Gabriel. 

Ce projet s'inscrit dans notre parcours scolaire et technique, où nous avons pour mission de concevoir, développer et finaliser un produit innovant répondant à une problématique réelle.

Notre objectif : concevoir un piège photographique capable de capturer des images de manière autonome et de les transmettre à distance via une connexion internet.  
Ce système vise à améliorer la rapidité d'accès aux données collectées, tout en offrant une solution adaptée aux environnements isolés.

---

## Notre équipe

Nous sommes un groupe de 3 élèves, un en spécialité SIN et 2 autres en spécialité ITEC.
À travers ce projet, nous mettons en œuvre les compétences acquises en STI2D, notamment dans les domaines :
- de l'électronique,
- de l'informatique,
- de l'énergie,
- et de l'innovation technique.

Notre formation à Saint-Gabriel nous prépare à relever ce défi en mobilisant à la fois des savoirs théoriques et des pratiques concrètes de gestion de projet.

---

## Notre mission

- **Imaginer** une solution concrète pour améliorer les pièges photographiques classiques,
- **Concevoir** un dispositif fiable, autonome et connecté,
- **Développer** une interface simple pour la récupération des images,
- **Tester** notre prototype dans des conditions réelles,
- **Présenter** notre projet final lors des épreuves de baccalauréat.

---

## Prérequis

Pour lancer le site, vous devez :
1. Avoir un logiciel qui permet d'executer des fichiers `.php` et une base de donnée phpMyAdmin,
2. Créer la base de donnée avec la commande : 
```
CREATE DATABASE users_db;

USE users_db;

CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
);
```
3. Lancer le site sur le fichier `home.php` *(si lancement sur 404.php alors cliquez sur `Retour à la page d'accueil`)*
