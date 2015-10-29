# Première indexation

## Créons notre index

Notre code contient maintenant tout ce qu'il faut pour voir ce que ça donne. Pour activer l'indexation de nos livres, il suffit de dire qu'on veut les indexer : 

1. Allez dans "Réglages" » "Docalist Search" puis "Paramètres du serveur ElasticSearch"
2. Indiquez l'adresse du serveur Elastic Search
  - Si vous avez [installé ElasticSearch en local](install.md#installation-de-elastic-search-en-local), l'adresse sera probablement de la forme `http://localhost:9200`.
    - Remarque : si vous êtes sous Windows (Windows 7 ou Windows 2008 notamment) et que la couche IPV6 est activée, il est parfois préférable d'indiquer une adresse IP (127.0.0.1) plutôt que le nom `localhost` (c'est la même chose quand on paramètre un serveur MySql par exemple) car Windows essaiera à chaque requête de faire une résolution DNS (et échouera en timeout) si votre fichier `etc/hosts` est mal configuré. [Plus d'infos](http://www.victor-ratajczyk.com/post/2012/02/25/mysql-fails-to-resolve-localhost-disable-ipv6-on-windows.aspx).
  - S'il s'agit d'un [serveur distant](install.md#utilisation-dun-service-elastic-search-hébergé) (dans le cloud, par exemple), utilisez l'adresse fournie par votre fournisseur.
  - Si l'accès à votre serveur ES est protégé par login/mot de passe indiquez une adresse de la forme `https://user:password@serveur.url`
  - Indiquez le nom de l'index ElasticSearch à utiliser (il sera créé s'il n'existe pas déjà).
    - Il est recommandé de créer un index différent pour chaque application.
    - Assurez-vous que le nom d'index indiqué n'est pas déjà utilisé !
  - Autres paramètres :
    - timeouts : 5 et 10 secondes,
    - compression http : à activer si vous utilisez un serveur ES distant.
3. Allez ensuite dans "Réglages » Docalist Search" puis "Paramétres de l'indexeur"
4. Choisissez les contenus à indexer : nos livres (cochez la case)
  - Autres paramètres : buffer 10 Mo / 100 documents, indexation temps réel : à activer après avoir fait une réindexation manuelle et vérifié que tout est ok.
  - Pour la mise en route, il est conseillé de n'activer qu'un seul type à la fois : si cela ne fonctionne pas comme on veut, c'est plus facile de savoir d'où vient le problème.
5. Lorsque vous validez la page, l'index ElasticSearch va être créé (s'il n'existe pas déjà) et les mappings des types choisis vont être envoyés à ElasticSearch.

Avec le code présent présent dans le plugin de démo, voici le mapping complet qui est généré pour nos livres :

```json
{
   "bookdemo": {
      "mappings": {
         "bookdemo": {
            "dynamic": "true",
            "include_in_all": true,
            "_meta": {
               "docalist-search": "2.0.0"
            },
            "numeric_detection": true,
            "_all": {
               "enabled": true
            },
            "_timestamp": {
               "enabled": true
            },
            "properties": {
               "booktype": {
                  "type": "string",
                  "analyzer": "fr-text",
                  "fields": {
                     "filter": {
                        "type": "string",
                        "index": "not_analyzed"
                     }
                  },
                  "include_in_all": true
               },
               "content": {
                  "type": "string",
                  "analyzer": "fr-text",
                  "include_in_all": true
               },
               "createdby": {
                  "type": "string",
                  "analyzer": "fr-text",
                  "fields": {
                     "filter": {
                        "type": "string",
                        "index": "not_analyzed"
                     }
                  },
                  "include_in_all": true
               },
               "creation": {
                  "type": "date",
                  "ignore_malformed": true,
                  "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd HH:mm||yyyy-MM-dd HH'h'mm||yyyy-MM-dd||yyyy/MM/dd HH:mm:ss||yyyy/MM/dd HH:mm||yyyy/MM/dd HH'h'mm||yyyy/MM/dd||yyyy.MM.dd HH:mm:ss||yyyy.MM.dd HH:mm||yyyy.MM.dd HH'h'mm||yyyy.MM.dd||yyyyMMdd HH:mm:ss||yyyyMMdd HH:mm||yyyyMMdd HH'h'mm||yyyyMMdd||dd-MM-yyyy HH:mm:ss||dd-MM-yyyy HH:mm||dd-MM-yyyy HH'h'mm||dd-MM-yyyy||dd/MM/yyyy HH:mm:ss||dd/MM/yyyy HH:mm||dd/MM/yyyy HH'h'mm||dd/MM/yyyy||dd.MM.yyyy HH:mm:ss||dd.MM.yyyy HH:mm||dd.MM.yyyy HH'h'mm||dd.MM.yyyy",
                  "include_in_all": true
               },
               "excerpt": {
                  "type": "string",
                  "analyzer": "fr-text",
                  "include_in_all": true
               },
               "lastupdate": {
                  "type": "date",
                  "ignore_malformed": true,
                  "format": "yyyy-MM-dd HH:mm:ss||yyyy-MM-dd HH:mm||yyyy-MM-dd HH'h'mm||yyyy-MM-dd||yyyy/MM/dd HH:mm:ss||yyyy/MM/dd HH:mm||yyyy/MM/dd HH'h'mm||yyyy/MM/dd||yyyy.MM.dd HH:mm:ss||yyyy.MM.dd HH:mm||yyyy.MM.dd HH'h'mm||yyyy.MM.dd||yyyyMMdd HH:mm:ss||yyyyMMdd HH:mm||yyyyMMdd HH'h'mm||yyyyMMdd||dd-MM-yyyy HH:mm:ss||dd-MM-yyyy HH:mm||dd-MM-yyyy HH'h'mm||dd-MM-yyyy||dd/MM/yyyy HH:mm:ss||dd/MM/yyyy HH:mm||dd/MM/yyyy HH'h'mm||dd/MM/yyyy||dd.MM.yyyy HH:mm:ss||dd.MM.yyyy HH:mm||dd.MM.yyyy HH'h'mm||dd.MM.yyyy",
                  "include_in_all": true
               },
               "parent": {
                  "type": "long",
                  "ignore_malformed": true,
                  "include_in_all": true
               },
               "slug": {
                  "type": "string",
                  "analyzer": "fr-text",
                  "include_in_all": true
               },
               "status": {
                  "type": "string",
                  "analyzer": "fr-text",
                  "fields": {
                     "filter": {
                        "type": "string",
                        "index": "not_analyzed"
                     }
                  },
                  "include_in_all": true
               },
               "title": {
                  "type": "string",
                  "analyzer": "fr-text",
                  "include_in_all": true
               }
            }
         }
      }
   }
}
```

> Remarque : les champs ne sont pas dans l'ordre dans lequel on les a créés, c'est normal : ElasticSearch les trie par ordre alphabétique car la notion "d'ordre des champs" n'a pas de sens dans un objet JavaScript/JSON.

## Consulter le mapping généré

Le mapping présenté plus haut peut être obtenu "en live" en envoyant une requête "GET" sur le endpoint `_mapping` de votre index.

A partir d'un navigateur, on peut par exemple appeller l'url suivante :

```
http://localhost:9200/monindex/_mapping?pretty
```

Si vous utilisez [curl](http://curl.haxx.se/) (vous devriez !), cela donnerait :

```sh
$ curl -XGET http://localhost:9200/monindex/_mapping?pretty
```

> Remarque : par défaut, ElasticSearch retourne du JSON compressé (non indenté). Le paramètre `pretty` permet d'obtenir une sortie formattée.

## Voir les settings de l'index

De la même façon, on peut voir les *settings* de l'index (les paramètres) et consulter la liste des analyseurs et des filtres que docalist search a créé pour vous :

```
http://localhost:9200/monindex/_settings?pretty
```
ou
```sh
$ curl -XGET http://localhost:9200/monindex/_settings?pretty
```


```json
{
   "bookdemo": {
      "settings": {
         "index": {
            "number_of_shards": "1",
            "auto_expand_replicas": "0",
            "creation_date": "1445976091114",
            "analysis": {
               "filter": {
                  "it-elision": {
                     "type": "elision",
                     "articles": [
                        "c",
                        "l",
                        "all",
                        "dall",
                        "dell",
                        "nell",
                        "sull",
                        "coll",
                        "pell",
                        "gl",
                        "agl",
                        "dagl",
                        "degl",
                        "negl",
                        "sugl",
                        "un",
                        "m",
                        "t",
                        "s",
                        "v",
                        "d"
                     ]
                  },
                  "de-stem2": {
                     "name": "german",
                     "type": "stemmer"
                  },
                  "es-stop": {
                     "type": "stop",
                     "stopwords": [
                        "_spanish_"
                     ]
                  },
                  "es-stem": {
                     "type": "stemmer",
                     "name": "spanish"
                  },
                  "es-stem-light": {
                     "name": "light_spanish",
                     "type": "stemmer"
                  },
                  "de-stem": {
                     "type": "stemmer",
                     "name": "german"
                  },
                  "it-stem-light": {
                     "type": "stemmer",
                     "name": "light_italian"
                  },
                  "url-stopwords": {
                     "type": "stop",
                     "stopwords": [
                        "http",
                        "https",
                        "ftp",
                        "www"
                     ]
                  },
                  "en-stem-light": {
                     "type": "stemmer",
                     "name": "light_english"
                  },
                  "it-stop": {
                     "type": "stop",
                     "stopwords": [
                        "_italian_"
                     ]
                  },
                  "fr-stem-minimal": {
                     "name": "minimal_french",
                     "type": "stemmer"
                  },
                  "en-possessives": {
                     "type": "stemmer",
                     "language": "possessive_english"
                  },
                  "de-stop": {
                     "type": "stop",
                     "stopwords": [
                        "_german_"
                     ]
                  },
                  "en-stem": {
                     "type": "stemmer",
                     "name": "english"
                  },
                  "fr-stop": {
                     "type": "stop",
                     "stopwords": [
                        "_french_"
                     ]
                  },
                  "de-stem-minimal": {
                     "type": "stemmer",
                     "name": "minimal_german"
                  },
                  "en-stem-minimal": {
                     "type": "stemmer",
                     "name": "minimal_english"
                  },
                  "fr-elision": {
                     "type": "elision",
                     "articles": [
                        "l",
                        "m",
                        "t",
                        "qu",
                        "n",
                        "s",
                        "j",
                        "d",
                        "c",
                        "jusqu",
                        "quoiqu",
                        "lorsqu",
                        "puisqu"
                     ]
                  },
                  "it-stem": {
                     "type": "stemmer",
                     "name": "italian"
                  },
                  "en-stop": {
                     "type": "stop",
                     "stopwords": [
                        "_english_"
                     ]
                  },
                  "fr-stem-light": {
                     "type": "stemmer",
                     "name": "light_french"
                  },
                  "de-stem-light": {
                     "type": "stemmer",
                     "name": "light_german"
                  },
                  "fr-stem": {
                     "name": "french",
                     "type": "stemmer"
                  }
               },
               "analyzer": {
                  "de-text": {
                     "filter": [
                        "lowercase",
                        "de-stop",
                        "asciifolding",
                        "de-stem-light"
                     ],
                     "char_filter": [
                        "html_strip"
                     ],
                     "type": "custom",
                     "tokenizer": "standard"
                  },
                  "fr-text": {
                     "filter": [
                        "lowercase",
                        "fr-elision",
                        "fr-stop",
                        "asciifolding",
                        "fr-stem-light"
                     ],
                     "char_filter": [
                        "html_strip"
                     ],
                     "type": "custom",
                     "tokenizer": "standard"
                  },
                  "en-text": {
                     "filter": [
                        "lowercase",
                        "en-possessives",
                        "en-stop",
                        "asciifolding",
                        "en-stem"
                     ],
                     "char_filter": [
                        "html_strip"
                     ],
                     "type": "custom",
                     "tokenizer": "standard"
                  },
                  "suggest": {
                     "type": "custom",
                     "filter": [
                        "lowercase",
                        "asciifolding"
                     ],
                     "tokenizer": "keyword"
                  },
                  "text": {
                     "filter": [
                        "lowercase",
                        "asciifolding"
                     ],
                     "char_filter": [
                        "html_strip"
                     ],
                     "type": "custom",
                     "tokenizer": "standard"
                  },
                  "url": {
                     "filter": [
                        "url-stopwords"
                     ],
                     "type": "custom",
                     "tokenizer": "lowercase"
                  },
                  "es-text": {
                     "filter": [
                        "lowercase",
                        "es-stop",
                        "asciifolding",
                        "es-stem-light"
                     ],
                     "char_filter": [
                        "html_strip"
                     ],
                     "type": "custom",
                     "tokenizer": "standard"
                  },
                  "it-text": {
                     "filter": [
                        "lowercase",
                        "it-elision",
                        "it-stop",
                        "asciifolding",
                        "it-stem-light"
                     ],
                     "char_filter": [
                        "html_strip"
                     ],
                     "type": "custom",
                     "tokenizer": "standard"
                  }
               }
            },
            "number_of_replicas": "0",
            "version": {
               "created": "1050299"
            },
            "uuid": "gTXA8u7KSCuOer3rRSBcbg"
         }
      }
   }
}
```

## Supprimons notre index ElasticSearch

Lors du développement, il est courant d'avoir à "peaufiner" les mappings et les settings (on n'avait pas indexé tel champ mais on en a besoin, on veut changer l'analyseur utilisé, etc.)

Mais ElasticSearch ne supporte que modérement les changements de mappings : tant qu'on se contente d'ajouter des champs, ça ira, mais si on veut changer les mappings d'un champ existant pour lequel on a déjà du contenu indexé, il refusera de faire la mise à jour (cela fait partie des principes de résilience qui assurent la robustesse d'ElasticSearch).

Dans ce cas, la solution la plus simple consiste à supprimer l'index, puis à le recréer avec les nouveaux mappings.

Pour cela, il faut adresser une requête http `DELETE` sur le endpoint de notre index : 

```sh
$ CURL -XDELETE http://localhost:9200/monindex/?pretty
```

Remarques :
> - Ce type de requête ne peut pas être fait depuis le navigateur (ça fait du GET)
> - Attention de ne pas se tromper d'index ! Il n'y a pas de demande de confirmation ou quoi que ce soit.
> - Si vous utilisez un service ElasticSearch dans le cloud, il se peut que le fournisseur du service ait désactivé la possibilité de supprimer un index. Dans ce cas, il faudra utiliser leur tableau de bord ou voir avec eux.

Une fois que l'index a été supprimé, vous pouvez modifier votre méthode `mapping()` et recréer l'index (retournez sur la page "Paramètres de l'indexeur" et validez sans rien changer : docalist-search teste si l'index existe et le recrée si ce n'est pas le cas).


## Indexons nos livres

Pour indexer nos livres, il suffit de demander à docalist-search de faire une réindexation complète.

Mais pour ça, il nous faut des livres !

- Donc prenez le temps de créer quelques genres littéraires et quelques livres

*ou :* 

- **Importez le fichier test que nous proposons !**

  Il s'agit d'un fichier wxr qui contient 10 livres. Il se trouve dans le répertoire `data` du plugin (fichier `10-books.xml`).

  - Dans WordPress, allez dans "Outils" » "Importer", choisissez l'importateur "WordPress" (il sera installé automatiquement si ce n'est pas encore fait) et importez le fichier de livres.
  - Vous devriez obtenir 10 livres répartis dans 10 genres.

> Crédits : les descriptions des livres qui figurent dans le fichier d'exemple proviennent de Wikipedia.

On peut maintenant lancer notre indexation :

1. Allez dans "Réglages » Docalist Search" puis choisissez "Réindexation manuelle"
2. Sélectionnez le type "Livres" et validez.
3. Docalist-search lance alors une réindexation complète et affiche un résumé des opérations :
  ```html
  Livres (démo)

  Chargement des documents à indexer à partir de la base WordPress...

  10 documents indexés, flush du cache (27 kB)... OK (0.29 secondes)
  Terminé. Nouveaux documents : 0, mis à jour : 10, supprimés : 0.
  ```


## Vérifions notre index

Pour s'assurer qu'on a bien nos livres dans l'index ElasticSearch, on peut faire une requête directement sur le serveur ElasticSearch (depuis un navigateur par exemple).

Le endpoint `_count` ([cf. documentation](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-count.html)) nous permet d'avoir directement le nombre de documents dans l'index :

```sh
http://localhost:9200/monindex/_count?pretty
```

```javascript
{
  "count" : 10,       // Ouf, on a bien nos 10 livres !
  "_shards" : {
    "total" : 1,
    "successful" : 1,
    "failed" : 0
  }
}
```

Le _endpoint `_search` ([cf. documentation](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-uri-request.html)) nous permet de lancer une recherche. Il prend en paramètre une équation de recherche (cf. [documentation lucene](http://lucene.apache.org/core/5_3_1/queryparser/org/apache/lucene/queryparser/classic/package-summary.html#package_description) et [documentation ElasticSearch](https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-query-string-query.html#query-string-syntax)).

```sh
http://localhost:9200/monindex/_search?q=policier&pretty
```

```javascript
{
  "took" : 1,                       // Durée d'exécution de la requête ES, en millisecondes
  "timed_out" : false,
  "hits" : {
    "total" : 2,                    // 2 réponses contiennent le terme "policier"
    "max_score" : 0.19480552,
    "hits" : [
      {                             // Premier hit obtenu
        "_index" : "bookdemo",
        "_type" : "bookdemo",
        "_id" : "9",                // C'est le post_id du post WordPress
        "_score" : 0.19480552,      // Score de pertinence
        "_source":                  // Source du document = ce qu'on a indexé
        {
            "status":"Publié",
            "slug":"le-nom-de-la-rose",
            "createdby":"dmenard",
            "title":"Le Nom de la rose",
            "content":"Le Nom de la rose est un roman de l'Italien Umberto Eco [...]",
            "booktype":["Médiéval","Roman","Thriller"]
            // [...]
        }
      },
      {                             // Seconde réponse obtenue
        "_index" : "bookdemo",
        "_type" : "bookdemo",
        "_id" : "13",
        "_score" : 0.08609269,
        "_source":
        {
          "status":"Publié",
          "slug":"1984",
          "creation":"2015-10-27 22:06:05",
          "lastupdate":"2015-10-27 22:06:05",
          "title":"1984",
          "content":"le plus célèbre roman de George Orwell",
          "booktype":["Roman","Science Fiction"]
          // [...]
        }
      }
    ]
  }
}
```

## Faisons quelques recherches

Le langage des équations de recherche permet déjà de faire pas mal de choses.

Exemples : les posts qui contiennent le mot "rose" dans le titre, l'expression exacte "policier médiéval" dans le contenu et qui sont du genre "Thriller" (suspense, suspense !)

```sh
http://localhost:9200/monindex/_search?q=title:rose AND content:"policier médiéval" AND booktype:Thriller&pretty
```

```javascript
{
  "took" : 1,
  "hits" : {
    "total" : 1,
    "max_score" : 1.740477,
    "hits" : [ {
      "_index" : "bookdemo",
      "_type" : "bookdemo",
      "_id" : "9",
      "_score" : 1.740477,
      "_source":{
        "title":"Le Nom de la rose",
        "content":"...peut être qualifié comme un policier médiéval",
        "booktype":["Médiéval","Roman","Thriller"]
        // [...]
      }
    } ]
  }
}
```

**Remarques :**

- On pourrait tout à fait s'arrêter là et développer un front-end offrant déjà de grandes possibilités de recherche : un formulaire permettant de saisir une requête de recherche, un script php qui appelle le endpoint `_search`, un simple décodage du JSON retourné.

- C'est même faisable directement à partir d'un front-end en javascript. Dans ce cas, les performances sont encore meilleures, car le navigateur va communiquer directement avec le serveur ElasticSearch et on évite les étages intermédiaires apache/php/mysql/wordpress...

- Mais pour des besoins plus classiques, docalist-search offre une API de recherche qui permet de faire tout ça plus facilement (cf. [API docalist search](searchapi.md)).

## Indexation en temps réel

Une fois qu'on a vérifié que notre index était correct, on peut désormais activer l'indexation en temps réel : "Réglages" » "Docalist Search" » "Paramètres de l'indexeur" » "Indexation en temps réel".

Dèsormais, lorsque vous créez un nouveau livre ou lorsque vous modifiez ou supprimez un livre existant, l'index ElasticSearch est mis à jour.

Et ce, en temps réel.