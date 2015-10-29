# Introduction

Le plugin [Docalist Search Book Demo](https://github.com/docalist/docalist-search-book-demo) est un plugin WordPress de démo qui explique comment fonctionne [docalist-search](https://github.com/docalist/docalist-search) sur un exemple simple (une liste de livres).

Le code source du plugin est commenté et il est accompagné d'un tutoriel qui explique les différentes étapes.

Il illustre également quelques unes des bonnes pratiques [que nous promouvons](https://github.com/docalist/docalist-core) en matière de développement pour WordPress.

Utilisez le [gestionnaire de tickets du projet](https://github.com/docalist/docalist-search-book-demo/issues) si vous constatez des erreurs ou si vous avez des questions, nous ferons de notre mieux pour y répondre.

Et bien sûr, [les pull requests sont plus que bienvenues](https://help.github.com/articles/using-pull-requests/) si vous avez des améliorations ou des corrections à nous proposer !

##Table des matières

### [Présentation et objectifs](presentation.md)
  - [Elastic Search](presentation.md#elastic-search)
  - [A quoi ça sert ?](presentation.md#a-quoi-ça-sert-)
  - [Docalist Search](presentation.md#docalist-search)
  - [Le plugin de démo](presentation.md#le-plugin-de-démo)

### [Installation](install.md)
  - [Pré-requis](install.md#pré-requis)
  - [Installation des plugins docalist](install.md#installation-des-plugins-docalist)
    - [Installation manuelle](install.md#installation-manuelle)
    - [Installation via GitHub Updater](install.md#installation-via-github-updater)
    - [Installation via Git](install.md#installation-via-git)
    - [Installation via Subversion](install.md#installation-via-subversion)
    - [Installation via Composer](install.md#installation-via-composer)
    - [Activation des plugins](install.md#activation-des-plugins)
  - [Installation de Elastic Search](install.md#installation-de-elastic-search)
    - [Installation de Elastic Search en local](install.md#installation-de-elastic-search-en-local)
    - [Utilisation d'un service Elastic Search hébergé](install.md#utilisation-dun-service-elastic-search-hébergé)

### [Code du plugin](structure.md)
  - [Structure des fichiers](structure.md#structure-des-fichiers)
  - [Fichier de démarrage](structure.md#fichier-de-démarrage)
  - [La classe `Plugin`](structure.md#la-classe-plugin)
  - [La classe `BookIndexer`](structure.md#la-classe-bookindexer)
    - [La méthode `mapping()`](structure.md#la-méthode-mapping)
    - [La méthode `map()`](structure.md#la-méthode-map)

### [Première indexation](indexing.md)
  - [Créons notre index](indexing.md#créons-notre-index)
  - [Consulter le mapping généré](indexing.md#consulter-le-mapping-généré)
  - [Voir les settings de l'index](indexing.md#voir-les-settings-de-lindex)
  - [Supprimons notre index ElasticSearch](indexing.md#supprimons-notre-index-elasticsearch)
  - [Indexons nos livres](indexing.md#indexons-nos-livres)
  - [Vérifions notre index](indexing.md#vérifions-notre-index)
  - [Faisons quelques recherches](indexing.md#faisons-quelques-recherches)
  - [Indexation en temps réel](indexing.md#indexation-en-temps-réel)

### [API de recherche](searchapi.md)
  - [Introduction](searchapi.md#introduction)
  - [Créer une requête](searchapi.md#créer-une-requête)
    - [La classe `SearchRequest`](searchapi.md#la-classe-searchrequest)
    - [Autres paramètres de la requête](searchapi.md#autres-paramètres-de-la-requête)
    - [Voir le contenu de la requête](searchapi.md#voir-le-contenu-de-la-requête)
  - [Exécuter la requête](searchapi.md#exécuter-la-requête)
    - [La classe `SearchResults`](searchapi.md#la-classe-searchresults)
    - [Afficher une page de résultats](searchapi.md#afficher-une-page-de-résultats)
  - [Créons un formulaire de recherche utilisateur](searchapi.md#créons-un-formulaire-de-recherche-utilisateur) (TODO)

### Annexe
  - [Architecture, conventions et bonnes pratiques](architecture.md)
