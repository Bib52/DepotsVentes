### Projet tuteuré : Application de gestion d'une bourse de dépôts/ventes ###
### LP CISIIE 2015/2016 ###

---------------------------------------

#### Groupe : ####
* Bergeret Florian
* Bounajra Mourad

---------------------------------------

#### Lien : ####
* site github : http://fbergeret.github.io/DepotsVentes/

---------------------------------------

#### Prérequis : ####
* Serveur apache et mysql;
* Composer sur le serveur (https://getcomposer.org/).

---------------------------------------

#### Installation : ####
* Téléchargez le projet;
* Dézippez-le dans la racine de votre serveur web;
* Renommez le dossier en "DepotsVentes";
* Commande : `composer install` dans "DepotsVentes/Server/";
* Base de données : 
 	* créer une base de données de nom : `depotsventes`;
 	* importer le script "DepotsVentes/Server/depotsventes.sql" dans la base de données créé;
* Configurez : mettre vos informations dans le fichier "DepotsVentes/Server/app/Configuration.php";
* Testez : "http://server/DepotsVentes/Client".

---------------------------------------

#### Technologies utilisées : ####
* Les langages : PHP, JavaScript, HTML, CSS, SCSS;
* AngularJS : framework JS utilisé pour le développement front-End;
* Slim 3 : micro-framework PHP utilisé pour le développement de l'API;
* Eloquent ORM : framework PHP utilisé pour l'intéraction avec la base de données;
* Bootstrap : framework CSS utilisé pour le design;
* CharJS : librairie JS pour l'affichage de graphiques;
* JSPDF : librairie PHP pour l'extraction de fichier pdf;
* MySQL : système de gestion de base de données;
* PhpMyAdmin : interface de gestion de la base de données.
