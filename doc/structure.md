# Code du plugin

## Structure des fichiers

Le plugin Book Démo est structuré de la façon suivante :

```
/class/                                Classes, services et objets
  - Plugin.php                         Classe principale du plugin
  - BookIndexer.php.php                Indexeur pour les livres
/data
  - 10-books.xml                       Fichier à importer contenant 10 livres
/doc                                   Tutoriel et documentation du plugin
  - ...                                (format markdown)
/languages                             Fichiers de traduction (PO/MO)
  - ...
/views                                 Vues et templates utilisés
  - ...
-docalist-search-book-demo.php         Fichier principal du plugin
```

>Remarque : seuls les fichies principaux sont mentionnés, il existe d'autres fichiers (readme, licence, codeclimate, composer...) qui ne sont pas décrits içi.

## Fichier de démarrage

Le code de démarrage de notre plugin de démo se trouve dans le fichier `docalist-search-book-demo.php`.

C'est ce fichier qui contient les entêtes qui permettent d'indiquer à WordPress les informations dont il a besoin (nom du plugin, version, etc.) : 
```php
/**
 * This file is part of the "Docalist Search: Book Demo" plugin.
 *
 * Copyright (C) 2015 Daniel Ménard
 *
 * For copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 *
 * Plugin Name:         Docalist Search: Book Demo
 * Plugin URI:          http://docalist.org
 * Description:         Tutoriel docalist-search pour l'indexation d'un CPT "book".
 * Version:             1.0.0
 * Author:              Daniel Ménard
 * Author URI:          http://docalist.org/
 * Text Domain:         docalist-search-book-demo
 * Domain Path:         /languages
 * GitHub Plugin URI:   https://github.com/docalist/docalist-search-book-demo
 * GitHub Branch:       master
 */
```

**Remarque :**
> Cet entête contient également les entrées permettant à notre plugin d'être compatible avec le plugin [Github Updater](https://github.com/afragen/github-updater) (installation et mise à jour automatique d'un plugin WordPress hébergé sur Github, BitBucket ou GitLab). [Plus d'informations](install.md#installation-via-github-updater).

Ce fichier de démarrage fait seulement deux choses :

- Il gère les dépendances et empêche notre plugin de démo de s'activer si les plugins docalist-core et docalist-plugin [ne sont pas activés]([Activation des plugins](install.md#activation-des-plugins).

- Il crée une instance de la classe `Plugin`, la classe principale de notre plugin, et enregistre l'objet obtenu comme *service docalist* (architecture micro-services). 

C'est dans cette classe `Plugin` que les choses intéressantes commencent.


## La classe `Plugin`

Cette classe est responsable de l'initialisation de notre plugin :

1. Elle crée le custom post type `bookdemo` et la taxonomie associée `booktype` (cf. codex wordpress).

2. Elle indique à docalist-search que ce type de contenu peut être indexé :

    ```php
    add_filter('docalist_search_get_types', function (array $types) {
        $types['bookdemo'] = 'Livres (démo)';

        return $types;
    });
    ```

    **Remarques :**

    > C'est le fait d'implémenter ce filtre qui fait que nos livres seront proposés sur la page "paramètres de l'indexeur" de docalist-search.
    >
    > Le nom de code du type de contenu (`bookdemo` dans notre cas) est un identifiant qui sera utilisé pour définir le nom du type elasticsearch.
    >
    > C'est également cet identifiant qu'on utilisera par la suite pour faire des recherches filtrées par type (par exemple `_type:bookdemo AND title:gulliver`)
    >
    > Dans notre cas, le plus simple consiste à utiliser le même identifiant que pour le Custom Post Type WordPress.

3. Elle indique à docalist-search l'indexeur à utiliser pour indexer ce type de contenu :

    ```php
    add_filter('docalist_search_get_bookdemo_indexer', function() {
        return new BookIndexer();
    });
    ```

    **Remarques :**

    > Ce filtre sera appellé à chaque fois que docalist-search aura besoin d'indexer un livre : réindexation complète, indexation en temps réel, etc.
    >
    > L'objet retourné doit obligatoirement hériter de la classe `Docalist\Search\TypeIndexer` ou de l'une de ses classes descendantes (`Docalist\Search\PostIndexer` par exemple).
    >
    > Attention : le nom du filtre contient l'identifiant de votre type (`bookdemo`), cela doit coller avec ce que vous avez indiqué auparavant dans le filtre `docalist_search_get_types`. Si ce n'est pas le cas, docalist-search affichera un message du style `"Warning: indexer for type 'bookdemo' is not available"`.


> Note for myself : ce serait mieux si BookIndexer était défini sous forme de micro-service docalist.

## La classe `BookIndexer`

C'est cette classe qui gère l'indexation de nos livres dans ElasticSearch :

```php
    class BookIndexer extends PostIndexer
    {
        public function mapping() : array {
        }

        public function map($post) : array {
        }
    }
```

Elle indique à docalist-search comment indexer ce type de contenu :

- La méthode `mapping()` indique comment on veut indexer les livres  : quels sont les champs à indexer ? comment indexer chaque champ ? quels sont les champs que l'on veut pouvoir utiliser comme filtre, facette ou clé de tri ? quels sont les champs pour lesquels on voudra pouvoir faire de l'auto-complétion, etc.

  Autrement dit, elle *fournit les paramètres* d'indexation.

- La méthode `map()` se charge de convertir un livre en document ElasticSearch : elle va récupérer les données concernant un livre (ses champs, ses metas, etc.) et les rassembler en un tableau unique qui sera transmis à ElasticSearch.

  Autrement dit, elle *fournit les données*.

Comme notre type livre est un custom post type WordPress, on hérite de la classe `PostIndexer` (l'un dex indexeurs standards fournis par docalist-search) car elle fait déjà plein de choses dont on a besoin :

- Elle sait comment parcourir tous les posts de ce type et implémente la méthode `indexAll()` qui est utilisée, par exemple, pour faire une réindexation complète.

- Elle sait déjà comment indexer les champs communs à tous les post types WordPress : `ID`, `post_type`, `post_status`, `post_name`, `post_parent`, `post_author`, `post_date`, `post_modified`, `post_title`, `post_content` et `post_excerpt`)

- Elle implémente déjà l'indexation en temps réel et met en place les hooks nécessaires pour que l'index ElasticSearch soit mis à jour automatiquement lorsqu'un post est créé, modifié ou supprimé.

**Remarques :**
> La classe PostIndexer hérite elle-même d'une classe plus générique : `TypeIndexer`.
>
> Si on voulait indexer avec docalist-search autre chose que des custom post types WordPress (par exemple les profils utilisateurs, les commentaires, des données stockées dans un table mysql non WordPress ou encore le texte intégral des fichiers présents dans le répertoire uploads de WordPress), c'est cette classe `TypeIndexer` qu'on utiliserait.

### La méthode `mapping()`

La méthode `mapping()` doit retourner un [mapping ElasticSearch complet](https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping.html) qui décrit de façon précise les informations qui seront stockées dans l'index ElasticSearch. 

Exemple de mapping :

```php
    return [
        'dynamic' => true, // cf. https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping-dynamic-mapping.html
        'dynamic_templates' => [ // cf. https://www.elastic.co/guide/en/elasticsearch/guide/current/custom-dynamic-mapping.html#dynamic-templates
            'template pour les autres titres' => [
                'path_match' => 'title_*', // par exemple : title_fr, title_en, etc.
                'mapping' => [
                    'type' => 'string',
                    'analyzer' => 'text', // pas de stemming car la langue varie selon le titre
                    'copy_to' => 'title' // title:truc recherchera aussi title_fr:truc ou title_en:truc
                ],
            ]
        ],

        // Liste des champs
        'properties' => [
            'slug' => [ // post_name
                'type' => 'string',
                'analyzer' => 'fr-text'
            ],
            'title' => [ // post_title
                'type' => 'string',
                'analyzer' => 'fr-text'
            ],
            'creation' => [ // post_date
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss||yyyy-MM-dd',
                'ignore_malformed' => true
            ],
            'status' => [
                'type' => 'string',
                'analyzer' => 'fr-text',
                'fields' => [
                    'filter' => [
                        'type' => 'string',
                        'index' => 'not_analyzed'
                    ]
                ]
            ]
        ]
    ];
```

On peut bien sûr faire comme ça et coder le tableau "à la main", mais cela présente plusieurs
inconvénients :

- C'est fastidieux et le mapping généré peut très vite devenir très complexe (près de 600 lignes
par exemple pour le mapping complet d'une notice documentaire).

- Il est très facile de faire une erreur (sans s'en rendre compte) et c'est difficile à maintenir.

- D'un champ à un autre, d'un trype à un autre, on aura beaucoup de redondance (not [DRY](https://fr.wikipedia.org/wiki/Ne_vous_r%C3%A9p%C3%A9tez_pas)).

- Un même champ peut se retrouver indexé différemment d'un type à un autre, ce qui peut poser des
problèmes dans ElasticSearch

Pour simplifier ça, docalist-search dispose d'un objet utilitaire, `MappingBuilder`, qui permet de générer plus facilement le tableau de mappings.

Pour l'exemple ci-dessus, ça donnerait :

```php
    $builder = new MappingBuilder('fr-text'); // analyseur par défaut pour les champs texte

    $builder->field('slug')->text();
    $builder->field('title')->text();
    $builder->field('creation')->date();
    $builder->field('status')->text()->filter();
    $builder->template('title_*')->idem('title')->copyTo('title');

    return $builder->mapping();
```

> C'est un peu plus simple, non ?

Revenons à nos livres.

Dans notre cas, notre indexeur hérite de PostIndexer et celui-ci sait déjà comment indexer tous les champs standards de WordPress, donc la seule chose qu'on a à faire, c'est ajouter le mapping des champs qu'on a en plus :

- `post_title` (titre du livre) : déjà fait
- `post_content` (description du livre) : déjà fait
- taxonomie "types de livres" (`booktype`) : à faire

On peut donc simplement écrire :

```php
    public function mapping()
    {
        // Crée un mapping contenant nos champs spécifiques
        $builder = new MappingBuilder('fr-text');
        $builder->field('booktype')->text()->filter();

	    // Fusionne avec le mapping standard des posts
        return array_merge_recursive(parent::mapping(), $builder->mapping());
    }
```

### La méthode `map()`

On a fait le plus dur !

La seule chose qu'il nous reste à faire, c'est d'indiquer comment convertir un post WordPress de type livre en document ElasticSearch respectant le mapping qu'on vient de définir.

Là encore, la classe `PostIndexer` nous simplifie les choses car elle sait déjà gérer tous les champs standard d'un post WordPress. On peut donc récupérer le travail déjà fait et on a juste à ajouter les termes de notre taxonomie :

```php
    public function map($post)
    {
        $document = parent::map($post);
        $document['booktype'] = wp_get_post_terms($post->ID, 'booktype', ['fields' => 'names']);

        return $document;
  }
```
