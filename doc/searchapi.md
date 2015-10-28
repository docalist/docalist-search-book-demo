# API de recherche

## Introduction

Docalist Search dispose d'une API qui permet de créer des requêtes et de les exécuter : 
- la classe `SearchRequest` permet de créer une requête (c'est l'équivalent de la classe `WP_Query` de WordPress)
- la classe `SearchResults` représente les résultats obtenus (c'est l'équivalent du tableau de posts retourné par `WP_Query->get_posts()`).

## Créer une requête

Imaginons qu'on veuille faire une requête qui recherche : 
- les documents de type `bookdemo`,
- qui ont le genre littéraire `roman`,
- et contiennent le mot `vie` et l'expression exacte `"remise en question"` dans la description.

Avec la syntaxe Lucene/ElasticSearch, la requête à exécuter s'écrirait de la façon suivante :
```
_type:bookdemo AND booktype:roman AND content:vie AND content:"remise en question"
```

### La classe `SearchRequest`

Avec l'API docalist search, la même requête peut être construite comme ceci :
```php
$request = new SearchRequest();
$request->filter('_type', 'bookdemo');
$request->search('booktype', 'roman');
$request->search('content', 'vie');
$request->search('content', '"remise en question"');
```

Comme l'API implémente une interface fluide, on aurait pu aussi écrire :

```php
$request = (new SearchRequest())
    ->filter('_type', 'bookdemo')
    ->search('booktype', 'roman')
    ->search('content', 'vie')
    ->search('content', '"remise en question"');
```

Enfin, on peut aussi construire la requête en passant les paramètres directement au constructeur :

```php
$request = (new SearchRequest([
    '_type' => 'bookdemo',
    'booktype' => 'roman',
    'content' => ['vie', '"remise en question"']
]));
```

C'est pratique, notamment, si la requête à exécuter provient d'un formulaire (new SearchRequest($_GET) par exemple) :
```php
$request = new SearchRequest($_GET);
```

### Autres paramètres de la requête

(à détailler)

Outre les critères de recherche, la requête contient des paramètres qui permettent de choisir les réponses à retourner :

- `size` permet de choisir le nombre de réponses qui seront retournées (10 par défaut).
- `page` permet d'indiquer la page de résultats en cours (pour la pagination), 1 par défaut.
- `sort` permet de définir l'ordre de tri des réponses (par pertinence par défaut). ATTENTION : non implémenté pour le moment.
- `facet` permet de définir les facettes qu'on veut créer

**Exemple :**

Affichage de la 3ème page de réponses (20 réponses par page), tri par titre croissants et génération d'une facette par type de livre (top 10) :

```php
$request = (new SearchRequest())
    ->filter('_type', 'bookdemo')
    ->search('booktype', 'roman')
    ->search('content', 'vie')
    ->search('content', '"remise en question"')
    ->page(3)
    ->size(20)
    ->sort('title+')
    ->facet('booktypefacet', 10);
```

>TODO : la facette, c'est juste pour l'exemple, ça ne marchera pas car la facette 'booktypefacet' doit au préalable avoir été définie via le filtre `docalist_search_get_facets`.
>
>La définition et la gestion des facettes est l'un des points à revoir dans docalist search.

### Voir le contenu de la requête

Quel que soit le mode de création, on peut faire de l'introspection sur le contenu de la requête :

```php
echo $request->asEquation();
```

```
booktype:roman AND content:(vie OR "remise en question")
```
> Remarque : `_type` n'est pas affiché car c'est un filtre "privé" (avec un underscore).

On peut aussi voir le code exact de la requête ([Query DSL](https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl.html)) qui sera envoyée à ElasticSearch :

```php
echo json_encode($request->elasticSearchRequest(), JSON_PRETTY_PRINT);
```

```json
{
    "query": {
        "filtered": {
            "query": {
                "bool": {
                    "must": [
                        {
                            "query_string": {
                                "query": "roman",
                                "default_operator": "AND",
                                "analyze_wildcard": true,
                                "lenient": true,
                                "default_field": "booktype"
                            }
                        },
                        {
                            "bool": {
                                "should": [
                                    {
                                        "query_string": {
                                            "query": "vie",
                                            "default_operator": "AND",
                                            "analyze_wildcard": true,
                                            "lenient": true,
                                            "default_field": "content"
                                        }
                                    },
                                    {
                                        "query_string": {
                                            "query": "\"remise en question\"",
                                            "default_operator": "AND",
                                            "analyze_wildcard": true,
                                            "lenient": true,
                                            "default_field": "content"
                                        }
                                    }
                                ]
                            }
                        }
                    ]
                }
            },
            "filter": [
                {
                    "term": {
                        "_type": "bookdemo"
                    }
                }
            ]
        }
    },
    "fields": [],
    "size": 20,
    "from": 3
}
```

>TODO : ah ben non, on ne peut pas faire ça car la méthode SearchRequest::elasticSearchRequest() est protected... A changer.


## Exécuter la requête

Une fois que la requête est préparée, on peut l'exécuter et récupérer les résultats obtenus (un objet de type SearchResults) :

```php
$results = $request->execute();
```

> Remarque : execute() accepte également un paramètre qui permet d'indiquer le type de recherche qu'on veut exécuter (cf. [documentation ElasticSearch](https://www.elastic.co/guide/en/elasticsearch/guide/current/_search_options.html#search-type)). 
>
> On peut notamment exécuter une requête de type `count` qui se contente de retourner le nombre de réponses obtenues sans les lister toutes : c'est beauoup plus performant si seul le nombre de réponse nous intéresse.


### La classe `SearchResults`

L'objet `SearchResults` obtenu contient plusieurs informations :

- le temps d'exécution de la requête (time & took)
- les hits obtenus
- les facettes demandées
- etc.

(à détailler)

### Afficher une page de résultats

On peut ainsi créer une SERP très simple avec le code suivant :
```php
    // Crée la requête
    $request = (new SearchRequest())
        ->filter('_type', 'bookdemo')
        ->search('booktype', 'roman')
        ->search('content', 'vie')
        ->search('content', '"remise en question"');

    // Exécute la requête
    $results = $request->execute();

    // Affiche la requête exécutée (et le temps total d'exécution)
    echo '<h2>Recherche de livres</h2>';
    printf('<p>Votre recherche : <code>%s</code></p>', $request->asEquation());
    printf(
        '<p><small>Requête exécutée en %d ms (temps total %d ms).</small></p>',
        $results->took(),
        $results->time() * 1000
    );

    // Affiche le nombre de réponses obtenues
    if (empty($hits = $results->hits())) {
        echo '<h2>Aucune réponse, désolé !</h2>';
    } else {
        $total = $results->total();
        $start = 1 + ($request->page() - 1) * $request->size();
        $end = min($total, $start + $request->size() - 1);
        printf('<h2>%d réponse(s) trouvée(s), affichage des réponses %d à %d :</h2>',
            $total, $start, $end
        );

        echo '<ul class="ul-square">';
        foreach ($hits as $hit) {
            $post = get_post($hit->_id); /* @var $post WP_Post */
            printf(
                '<li><h3><a href="%s">%s</a></h3><p>%s</p></li>',
                esc_attr(get_the_permalink($post)),
                get_the_title($post),
                wp_trim_words($post->post_content, 30)
            );
        }
        echo '</ul>';
    }
```

> TODO : il y a un bug dans SearchResults, time() retourne une durée en secondes alors que took() retourne une durée en milli-secondes (c'est la raison du "*1000" dans le code ci-dessus). A corriger.

> Le code complet de cet exemple figure dans le fichier vue `views/searchrequest.php` du plugin.

## Créons un formulaire de recherche utilisateur

(todo) 