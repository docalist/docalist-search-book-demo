# Architecture, conventions et bonnes pratiques

(à détailler et à justifier)

Tous les plugins docalist suivent les principes suivants :

- Architecture objet : que des classes, aucune variable globale, aucune fonction
- [Architecture micro-services](https://en.wikipedia.org/wiki/Microservices), chaque service peut être surchargé ou changé
- [SoC](https://en.wikipedia.org/wiki/Separation_of_concerns) (separation of concerns), [SRP](https://en.wikipedia.org/wiki/Single_responsibility_principle) (Single Responsibility Principe) : chaque plugin, chaque classe, chaque méthode ne fait qu'une seule chose mais essaie de le faire bien
- [Injection de dépendances](https://fr.wikipedia.org/wiki/Injection_de_d%C3%A9pendances) : utilisation d'un DIC (containeur) similaire à [pimple](http://pimple.sensiolabs.org/).
- [MVC](https://fr.wikipedia.org/wiki/Mod%C3%A8le-vue-contr%C3%B4leur) (adapté) : séparation claire entre comportement et interface
- Système de vues, toutes les vues sont surchargeables dans les thèmes
- [Code testable](http://misko.hevery.com/code-reviewers-guide/) ([phpunit](https://phpunit.de/)) : on n'a pas des tests unitaires pour tout, mais chaque classe est *conçue* pour pouvoir être testée en isolation
- Code (très) commenté
- Génération automatique de la documentation de l'API avec des outils comme [ApiGen](http://www.apigen.org/), [Sami](https://github.com/FriendsOfPHP/Sami) ou [PhpDocumentor](http://www.phpdoc.org/). Conformité [PSR-5](https://github.com/phpDocumentor/fig-standards/tree/master/proposed).
- [DDD](https://en.wikipedia.org/wiki/Domain-driven_design) (Domain Driven Dev), respect du vocabulaire métier, la classe SearchRequest par exemple ne s'appelle pas HitCollection ou Docalist_Search_Results, les champs sont du texte ou du html, pas des 'string'.
- Typage fort, sémantique : [modélisation](https://fr.wikipedia.org/wiki/Mod%C3%A8le_entit%C3%A9-association) à partir de types, de schémas et d'entités
- Utilisation de toutes les possibilités modernes de php (espaces de noms, closures, traits)
- Compatibilité php 7 (en cours pour docalist-core)
- NIH (not invented here) : utilisation de composants existants quand c'est judicieux (Symfony Components, HandsOnTable, Monolog...)
- Autoloader : aucun include ou require dans le code, conformité [PSR-4](http://www.php-fig.org/psr/psr-4/)
- Conformité [PSR-1](http://www.php-fig.org/psr/psr-1/) et [PSR-2](http://www.php-fig.org/psr/psr-2/) pour le formattage du code
- Respect de l'API WordPress (mais on se fout des conventions de codage WP qui sont à mille lieues de PSR-2, sauf si on propose un patch à WordPress)
- Démarche qualité : vérification automatique de la qualité du code (à chaque commit) avec des outils comme [CodeClimate](https://codeclimate.com/) ou [Sension Insights](https://insight.sensiolabs.com/) : respect du formattage, degré de complexité du code, code dupliqué, code mort, variables ou fonctions non utilisées, non respect des conventions de nommage, code à risque, utilisation de fonctions dépréciées/dangereuses, etc.
- Compatibilité avec [GitHub Updater](https://github.com/afragen/github-updater)
- Compatibilité avec [Composer](https://getcomposer.org/)
- Plugins wordpress prêts à la traduction (i10n et i18n)
- etc.