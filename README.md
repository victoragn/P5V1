Bienvenue dans la solution de gestion de classe
===============================================

1)Installation en local :
-------------------------
- Copier le dossier P5 ci-dessous dans le dossier de votre server web local (exemple : C:/wamp/www).
- Lancer la console dans ce nouveau dossier P5.
- Tapez "php composer.phar install" dans la console (composer doit être installé). Cela va ajouter les vendors.
- Tapez "php bin/console doctrine:database:create" pour créer votre Base De Données.
- Tapez "php bin/console doctrine:schema:update --dump-sql" puis "php bin/console doctrine:schema:update --force" pour créer les tables de la BDD.
- Importer la base de données gestionclasse.sql dans phpMyAdmin.
- L'application est prête.

2)Fonctionnement Général :
--------------------------
Certaines contraintes sont à connaître : 

    * La date de rentrée est pour le moment fixée au 04/09/2017 : @AgnezCore/Services
    
    * Le nombre de semaines dans l'année est de 40 : @AgnezCore/Services
    
    * Le nombre d'élèves max est fixé à 30 : @AgnezCore/Entity/Classe. (Attention l'affichage ne peut aussi qu'en afficher 30 pour l'instant)
    
    * 2 Users ne peuvent pas avoir le même pseudo ni le même email : @AgnezUser/Entity/User
    
    * Un User ne peut pas avoir 2 classes ayant le même nombre : @AgnezUser/Entity/User
    
    * Une classe ne peut pas avoir 2 élèves avec les mêmes nom et prénom : @AgnezCore/Entity/Eleve



Symfony Standard Edition
========================

**WARNING**: This distribution does not support Symfony 4. See the
[Installing & Setting up the Symfony Framework][15] page to find a replacement
that fits you best.

Welcome to the Symfony Standard Edition - a fully-functional Symfony
application that you can use as the skeleton for your new applications.

For details on how to download and get started with Symfony, see the
[Installation][1] chapter of the Symfony Documentation.

What's inside?
--------------

The Symfony Standard Edition is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev env) - Adds code generation
    capabilities

  * [**WebServerBundle**][14] (in dev env) - Adds commands for running applications
    using the PHP built-in web server

  * **DebugBundle** (in dev/test env) - Adds Debug and VarDumper component
    integration

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.

Enjoy!

[1]:  https://symfony.com/doc/3.4/setup.html
[6]:  https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
[7]:  https://symfony.com/doc/3.4/doctrine.html
[8]:  https://symfony.com/doc/3.4/templating.html
[9]:  https://symfony.com/doc/3.4/security.html
[10]: https://symfony.com/doc/3.4/email.html
[11]: https://symfony.com/doc/3.4/logging.html
[13]: https://symfony.com/doc/current/bundles/SensioGeneratorBundle/index.html
[14]: https://symfony.com/doc/current/setup/built_in_web_server.html
[15]: https://symfony.com/doc/current/setup.html
