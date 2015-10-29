# Installation

## Pré-requis

Pour installer notre [plugin de démo](presentation.md), il va nous falloir :
- une pile [LAMP](https://fr.wikipedia.org/wiki/LAMP) à jour (version [PHP](http://php.net/) : minimum PHP 5.4, extension [cURL](http://php.net/curl) activée),
- un [WordPress](https://wordpress.org/download/) fonctionnel,
- le plugin [docalist-search](https://github.com/docalist/docalist-search),
- le plugin [docalist-core](https://github.com/docalist/docalist-core) (nécessaire au fonctionnement de docalist-search),
- le plugin [Book Démo](https://github.com/docalist/docalist-search-book-demo),
- un serveur ou service [Elastic Search](https://www.elastic.co/products/elasticsearch).

Je passe sous silence la vérification de votre version de PHP et l'installation de WordPress, j'imagine que vous savez faire et sinon, il existe [plein de ressources pour ça](https://codex.wordpress.org/fr:Installer_WordPress).

## Installation des plugins docalist

Pour le moment, les plugins docalist ne sont pas distribués sur wordpress.org, ils sont développés et diffusés sur GitHub :

- Docalist Core : https://github.com/docalist/docalist-core
- Docalist Search : https://github.com/docalist/docalist-search
- Book Demo : https://github.com/docalist/docalist-search

Plusieurs possibilités sont disponibles pour l'installation.

### Installation manuelle

  Allez sur le dépôt GitHub du plugin docalist à installer (cf. liens ci-dessus) et cliquez sur le lien "Download ZIP" qui est proposé (en bas à droite).

  Décompressez ensuite l'archive obtenue dans le répertoire `plugins` de votre site WordPress.

  > **Important** :
  >
  >Par défaut, le zip créé par github et le dossier contenu dans l'archive sont de la forme `docalist-search-xxx` où `xxx` représente un numéro de version : master, v1.1.0, v2.0.0-beta, etc.
  >
  > Quand vous décompressez l'archive **vous devez renommer le répertoire** et enlever cette mention de version.
  >
  > Par exemple pour docalist-search, le répertoire d'installation dans votre site WordPress doit être `plugins/docalist-search` et non pas `plugins/docalist-search-master`.

### Installation via GitHub Updater

  [GitHub Updater](https://github.com/afragen/github-updater) est un excellent plugin WordPress (j'ai participé à la traduction en français !) qui permet d'installer et de mettre à jour automatiquement des plugins WordPress hébergés sur GitHub, BitBucket ou GitLab.

  Tous les plugins docalist sont compatibles avec GitHub Updater. Pour installer un plugin docalist, il suffit d'aller dans la page "réglages" de GitHub Updater et de coller l'url du dépôt du plugin à installer (cf. liens donnés plus haut).

  Pour plus d'informations, consultez la [documentation de GitHub Updater](https://github.com/afragen/github-updater/blob/develop/README.md).

  > **Remarque : **En installant les plugins docalist avec GitHub Updater, vous obtiendrez automatiquement les mises à jour, comme si ceux-ci étaient publiés sur wordpress.org.

### Installation via Git

  Si vous utilisez [git](https://fr.wikipedia.org/wiki/Git), vous pouvez très facilement [cloner le dépôt du plugin](https://help.github.com/articles/which-remote-url-should-i-use/) docalist à installer.

  > Remarque : pour chaque plugin docalist, les urls à utiliser pour exécuter la commande `git clone` sont indiquées en bas à droite de la page d'accueil GitHub.

  Exemple :

  ```sh
  $ cd wordpress/wp-content/plugins
  $ git clone https://github.com/docalist/docalist-search.git
  Cloning into 'docalist-search'...
  remote: Counting objects: 4356, done.
  Receiving objects: 100% (4356/4356), 831.34 KiB | 533.00 KiB/s, done.

  Resolving deltas: 100% (2256/2256), done.
  Checking connectivity... done.
  ```

  Par la suite, les nouvelles versions des plugins docalist pourront être récupérées et installées simplement en tapant :

  ```sh
  $ cd wordpress/wp-content/plugins/docalist-search
  $ git pull
  Up-to-date.
  ```

  > Pour participer au développement, c'est la meilleure méthode

  > TODO : ne pas inciter à faire des clone du master, utiliser les tags.


### Installation via Subversion

  Tous les dépôts GitHub sont également accessibles comme s'il s'agissait de dépôts [Subversion](https://fr.wikipedia.org/wiki/Apache_Subversion) :

  ```sh
  $ cd wordpress/wp-content/plugins
  $ svn co https://github.com/docalist/docalist-search
  ```

### Installation via Composer

  [Composer](https://getcomposer.org/) est un (excellent) gestionnaire de paquets pour PHP.

  Tous les plugins docalist sont compatibles avec Composer. Pour ajouter un plugin docalist à votre projet, il suffit d'indiquer le dépôt et le nom du package dans votre fichier `composer.json` :

  ```JSON
    {
        "repositories": [
            {
                "type": "git",
                "url": "https://github.com/docalist/docalist-core.git"
            },
            {
                "type": "git",
                "url": "https://github.com/docalist/docalist-search.git"
            },
            {
                "type": "git",
                "url": "https://github.com/docalist/docalist-search-book-demo.git"
            }
        ],

        "require": {
            "php": ">=5.4",

            "docalist/docalist-core": "dev-master",
            "docalist/docalist-search": "dev-master",
            "docalist/docalist-search-book-demo": "dev-master",
        },
    }
  ```

  **Remarque :** quand les plugins docalist seront dispos sur [Packagist](https://packagist.org/) (et sur [WPackagist](http://wpackagist.org/)), ce sera encore plus simple, car il suffira de lancer la commande `require` pour installer automatiquement le plugin et toutes ses dépendances (et les dépendances des dépendances, et ainsi de suite) :

  ```sh
  $ composer require docalist/docalist-search-book-demo
  ```

Composer peut aussi être utilisé pour installer et mettre à jour un site WordPress complet (code wordpress, config, tous les plugins requis, les thèmes, etc.) en tapant juste une commande unique du style :

  ```php
  $ composer install mon/projet
  ```

Consultez la [documentation de Composer](https://getcomposer.org/doc/) pour plus d'informations.


###  Activation des plugins

Du fait des dépendances entre les différents plugins, vous devez activer dans l'ordre :

1. docalist-core
2. docalist-search
3. docalist-search-book-demo

**Remarques :**

> Les plugins docalist disposent d'un système de détection des dépendances qui fait que vous ne pourrez pas activer un plugin si les dépendances dont il a besoin ne sont pas disponibles.
>
> Si par la suite vous désactivez l'une des dépendances (par exemple docalist-core), cela désactivera automatiquement tous les plugins qui en dépendent.
>
> Dans tous les cas, un message est affiché dans le Back-Office WordPress si cela se produit.


## Installation de Elastic Search

### Installation de Elastic Search en local

ElasticSearch est [très simple à installer](https://www.elastic.co/guide/en/elasticsearch/reference/current/_installation.html) et cela ne prend que quelques minutes : c'est une application java, il suffit de décompresser le zip téléchargé et de lancer l'exécutable.

Sur les systèmes qui utilisent un gestionnaire de paquets (apt, yum, rpm...), c'est encore plus simple car il suffit de lancer une commande pour faire l'installation ou la mise à jour (par exemple, sur une debian, il suffit de faire `sudo apt-get install elasticsearch` après avoir mis à jour le fichier `sources.list`).

Quel que soit le système, une installation classique comporte les étapes suivantes :

1. Vérifiez la version de java dont vous disposez : ElasticSearch requiert java 7 (et de préférence java 8).

  > Vous pouvez vérifier votre version de java en tapant `java -version` en ligne de commande.
  >
  > Sous Windows : Panneau de configuration » Java » onglet "Général", bouton "A propos"
  >
  > Pour plus d'information sur l'installation du JDK, consultez la [documentation de Oracle](http://docs.oracle.com/javase/8/docs/technotes/guides/install/install_overview.html).

2. Vérifiez que la variable d'environnement `JAVA_HOME` est correctement définie

  > En ligne de commande, `echo $JAVA_HOME` (ou `echo %JAVA_HOME%` dans le prompt de Windows) doit vous afficher le répertoire complet dans lequel java est installé :
  >
  >  ```sh
  >  $ echo $JAVA_HOME                 
  >  c:\Program Files\Java\jdk1.7.0_17\
  >  ```
  >
  > Si ce n'est pas le cas, repérez dans quel répertoire Java est installé puis :
  >
  > - sous *nix : utilisez une commande du style `export JAVA_HOME=répertoire`.
  >
  > - sous Windows : Ordinateur » Propriétés (menu contextuel) » Paramètres système avancés » Bouton "Variables d'environnement" puis ajoutez la variable d'environnement dans la section "Variables système"
  >
  > Pour plus d'information sur le paramétrage de JAVA_HOME, consultez la [documentation de Oracle](http://docs.oracle.com/cd/E19182-01/820-7851/inst_cli_jdk_javahome_t/).

3. Récupérez la dernière version stable de ElasticSearch (https://www.elastic.co/downloads/elasticsearch) et décompressez l'archive obtenue dans le répertoire de votre choix.

4. *Optionnel : *vérifiez et modifiez la configuration d'ElasticSearch (nom du cluster, port utilisé, etc.) Le fichier de configuration se trouve dans `esdir/config/elasticsearch.yml`.

  > Cette étape est vraiment optionnelle : ElasticSearch fonctionne très bien avec les options par défaut.

5. Lancez l'exécutable ElasticSearch. Il s'agit du fichier `esdir/bin/elasticsearch` (sous *nix) ou du fichier `esdir/bin/elasticsearch.bat` (sous Windows).

  > Si vous lancez l'application en ligne de commande (dans un terminal ou une fenêtre de prompt), cela vous permettra de voir plus facilement ce qui se passe (affichage des logs au fur et à mesure) et d'arrêter facilement l'application (`ctrl+break` !).
  >
  > Par défaut, les logs d'ElasticSearch se trouvent dans le fichier `esdir/logs/elasticsearch.log`

**Ressources complémentaires :**
  - Documentation ElasticSearch sur l'installation :
    - [Principe général](https://www.elastic.co/guide/en/elasticsearch/reference/current/_installation.html)
    - [Démarrage et arrêt](https://www.elastic.co/guide/en/elasticsearch/reference/current/setup.html)
    - [Installation à partir d'un dépôt](https://www.elastic.co/guide/en/elasticsearch/reference/current/setup-repositories.html)
    - [Démarrage automatique sous *nix](https://www.elastic.co/guide/en/elasticsearch/reference/current/setup-service.html)
    - [Démarrage automatique sous Windows](https://www.elastic.co/guide/en/elasticsearch/reference/current/setup-service-win.html)
    - [Procédure de mise à jour](https://www.elastic.co/guide/en/elasticsearch/reference/current/setup-upgrade.html)
	- [Configuration](https://www.elastic.co/guide/en/elasticsearch/reference/current/setup-configuration.html)

  - Quelques notes que j'avais rédigées (voir s'il y a un intérêt / si c'est obsolète) :
    - [Installation sur une debian](https://github.com/docalist/docalist/issues/8#issuecomment-23172135)
    - [Mise à jour sur une Debian](https://github.com/docalist/docalist/issues/89#issuecomment-45757097)
    - [Installation simultanée de deux versions différentes de ES](https://github.com/docalist/docalist/issues/54#issuecomment-34356640)

> Remarque : il existe plein d'autres façon d'installer ElasticSearch, par exemple en récupérant [une image docker](http://dockerfile.github.io/#/elasticsearch) qu'il suffit de lancer avec un système de virtualisation comme [VirtualBox](https://www.virtualbox.org/)...

### Utilisation d'un service Elastic Search hébergé

De plus en plus de sociétés proposent des services Elastic Search en mode SaaS (hébergé). On peut citer par exemple :
- [found.no](https://www.elastic.co/found) (qui vient d'être rachetée par [elastic](https://www.elastic.co/about/press/elastic-acquires-elasticsearch-saas-provider-found))
- [bonsai.io](http://bonsai.io/)
- [qbox.io](http://qbox.io/)
- [facetflow.com](http://facetflow.com/)
- [Heroku](http://heroku.com/)
- [OpenShift](https://www.openshift.com/) (RedHat)
- etc.

L'intérêt de ces offres, c'est que vous n'avez pas à vous soucier de l'installation, des mises à jour, du monitoring, des sauvegardes, de la redondance, etc.

Les prix varient en fonction des services proposés, des engagements pris (SLA, GTR...) et des caractéristiques du cluster que vous choisissez : proximité géographique (pour limiter le temps de latence réseau), espace disque, quantité de RAM, nombre de serveurs différens (redondance et équilibrage de charge), etc.

A titre d'information, les [tarifs proposés par elastic](https://www.elastic.co/found/pricing) vont de 45 dollars par mois (un petit serveur sans redondance) à 17 000 dollars par mois (de quoi refaire google !)

> A noter : [bonsai.io](http://bonsai.io/) et [OpenShift](https://www.openshift.com/) proposent une offre découverte, gratuite et non limitée dans le temps (petit serveur sans redondance, 1 Go de disque et de RAM) qui peuvent être utiles pour démarrer.

Une autre solution, intermédiaire, consiste à louer un serveur virtuel dans le cloud et à bénéficier de l'installation quasi automatique qui est proposée. Parmi les acteurs du Big Data qui proposent ce genre de services, on peut citer :
- [Amazon Elasticsearch Service](https://aws.amazon.com/fr/elasticsearch-service/)
- [Elasticsearch on Google Compute Engine](https://cloud.google.com/solutions/elasticsearch/)
- [ElasticSearch sur Microsoft Azure](https://azure.microsoft.com/fr-fr/documentation/templates/elasticsearch/)
- etc.

> Remarque : les sociétés qui propose ElasticSearch en mode SaaS utilisent en général l'une de ces trois infrastructures.