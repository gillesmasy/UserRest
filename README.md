User REST
=========

Projet de formation à Symfony 2. 
<br/><br/>
L'objectif est de fournir une interface RESTFull servant à l'édtion d'utilisateurs (communication au format JSON), et une page web, fournissant la liste des utilisateurs. Cette page est sécurisée, nécessitant une authentification sur base des utilisateurs présents en base de données.
<br/><br/>
Le endpoint est défini à l'adresse ~/rest. Ainsi, au GET, UPDATE et DELETE correspondra l'URL ~/rest/{id}, avec les données communiquées POST si nécessaire, toujours au format JSON.
<br/><br/>
La page web est définie à l'adresse ~/secure/list. Si la personne n'est pas authentifiée, elle sera redirigée vers ~/secure/login. Si elle souhaite se déconnecter, elle sera amenée à l'adresse ~/secure/logout.


Installation
------------

Configuration<br/>
<ul>
    <li> Serveur Apache 2.2 avec un module PHP 5.3 (http://apache.org/dyn/closer.cgi)
    <li> Mysql 5.5 (http://dev.mysql.com/downloads/)
    <li> Symfony 2 (http://symfony.com/download)
</ul>

NOTE
    J'ai interprété "champ obligatoire" comme "champ non vide".
