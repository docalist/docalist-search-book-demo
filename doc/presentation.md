# Présentation et objectifs

## Elastic Search

Elasticsearch est un [moteur de recherche](https://fr.wikipedia.org/wiki/Moteur_de_recherche). Il est [libre](https://fr.wikipedia.org/wiki/Logiciel_libre), [open source](https://fr.wikipedia.org/wiki/Open_source) et il utilise [Lucene](https://fr.wikipedia.org/wiki/Lucene) (un des projets de l'[Apache Software Foundation](https://fr.wikipedia.org/wiki/Apache_Software_Foundation)).

- Il est distribué (architecture de type [cloud computing](https://fr.wikipedia.org/wiki/Cloud_computing)).
- Il est capable de gérer et de traiter des volumes de données colossaux ([scalabilité horizontale](https://fr.wikipedia.org/wiki/Scalability)).
- Il utilise [Lucene](https://fr.wikipedia.org/wiki/Lucene) pour l'indexation et la recherche des données.
- Il propose une interface suivant les principes d'une architecture [REST](https://fr.wikipedia.org/wiki/Representational_State_Transfer). L'indexation des données s'effectue à partir d'une [requête HTTP PUT](https://fr.wikipedia.org/wiki/Hypertext_Transfer_Protocol#M.C3.A9thodes) et la recherche des données s'effectue avec des requêtes [HTTP GET](https://fr.wikipedia.org/wiki/Hypertext_Transfer_Protocol#M.C3.A9thodes). Les données échangées sont au format [JSON](https://fr.wikipedia.org/wiki/JavaScript_Object_Notation).
- Il garantit que l'indexation des données et les recherches peuvent être effectuées en [quasi temps réel](https://www.elastic.co/guide/en/elasticsearch/guide/current/near-real-time.html).

Elasticsearch a été créé par [Shay Banon](http://www.touilleur-express.fr/2011/04/12/elasticsearch-interview-with-shay-banon/), fondateur en 2004 du projet [Compass](https://en.wikipedia.org/wiki/Compass_Project) en 2004. Lors de la conception de la troisième version de Compass, Banon se rend compte qu'il est [nécessaire de réécrire une grande partie du logiciel](https://web.archive.org/web/20130827121405/http://www.kimchy.org/the_future_of_compass/) pour gérer les montées en charge.

De là est né [Elasticsearch](https://github.com/elastic/elasticsearch), une solution construite pour être distribuée et pour utiliser du JSON via des requêtes HTTP, ce qui rend le moteur de recherche utilisable avec n'importe quel langage de programmation.

La première version sort le 8 février 2010 avec un numéro de version 0.4.0. Suivent des sorties quasi mensuelles avec plusieurs versions certains mois, numérotées 0.X jusqu'à une version 1.0, sortie le 12 février 2014 soit quatre ans après la première version. La version 2.0 a été [publiée le 28 octobre 2015](https://www.elastic.co/blog/elasticsearch-2-0-0-released).

En 2012 est créée [l'entreprise ElasticSearch](https://www.elastic.co/about) par Shay Banon et Steven Schuurmann. Le siège social est situé à Amsterdam aux Pays-Bas. S'ensuit une première levée de fond de [10 millions de dollars](http://www.zdnet.com/big-data-search-startup-elasticsearch-raises-10m-7000007116/), puis [24 millions de dollars](http://www.eu-startups.com/2013/02/amsterdam-based-elasticsearch-closes-24m-series-b-round/) en 2013 et [70 millions en 2014](http://www.journaldunet.com/solutions/saas-logiciel/elasticsearch-leve-70-millions-de-dollars-0614.shtml), ce qui (en juin 2014), valorisait l'entreprise à [700 millions de dollars](http://fortune.com/2014/06/06/latest-funding-round-values-elasticsearch-at-700-million/), d'après le site fortune.com.

En 2015, l'entreprise simplifie son nom pour devenir "[elastic](https://www.elastic.co/about/press/elasticsearch-changes-name-to-elastic-to-reflect-wide-adoption-beyond-search)" tout court et [fait l'acquisition de Found](https://www.elastic.co/about/press/elastic-acquires-elasticsearch-saas-provider-found), une compagnie néerlandaise qui proposait des services ElasticSearch en mode SaaS.

Aujourd'hui, ElasticSearch est présent partout dans le monde et à passé des partenariats avec tous les "Big Players" du cloud : [Amazon](https://aws.amazon.com/fr/elasticsearch-service/), [Google](https://cloud.google.com/solutions/elasticsearch/), [Microsoft](https://azure.microsoft.com/fr-fr/documentation/templates/elasticsearch/), [Cisco](https://www.elastic.co/about/partners/cisco), etc.

[Plusieurs livres](https://www.google.fr/webhp?hl=fr#q=elasticsearch&hl=fr&tbm=bks) sont disponibles, [des conférences](https://www.elastic.co/elasticon), [des ateliers](https://www.elastic.co/community/meetups), [des vidéos](https://www.elastic.co/videos) et [des formations](http://training.elastic.co/) sont très régulièrement proposées et [de nombreux produits](https://www.elastic.co/products) sont venus compléter le produit initial ([Kibana](https://www.elastic.co/products/kibana), [Logstach](https://www.elastic.co/products/logstash), [Marvel](https://www.elastic.co/products/marvel), [Shield](https://www.elastic.co/products/shield), [Watcher](https://www.elastic.co/products/watcher), etc.)

En parallèle, tout un éco-système s'est créé : connecteurs et librairies pour intégrer ElasticSearch dans les principaux frameworks et CMS, entreprise proposant de l'hébergement ElasticSearch en mode SaaS, etc.

Tous les sites en tant soit peu importants utilisent ElasticSearch : Wikipedia, The Guardian, GitHub, StackOverflow, Goldman Sachs, Mozilla, EBay, Adobe, NetFlix, Orange, FaceBook, Reuters, Ing Direct, Verizon, Deezer, la Nasa, le Cern, etc.

Même Microsoft (qui dispose pourtant de son propre moteur de recherche), [utilise ElasticSearch pour plusieurs de ses produits](https://www.elastic.co/elasticon/2015/sf/powering-real-time-search-at-microsoft) (MSN, Azure, etc.)

> Crédits : une partie du texte de ce chapitre provient de [wikipedia](https://fr.wikipedia.org/wiki/Elasticsearch).

## A quoi ça sert ?

ElasticSearch peut être utilisé dans [tellement de contextes différents](https://www.elastic.co/use-cases) qu'il est assez difficile de répondre facilement à la question "à quoi ça sert ?" : [même les développeurs d'ElasticSearch ont du mal !](https://www.elastic.co/blog/describe-elasticsearch)

Souvent, on commence à s'intéresser à ElasticSearch pour des problèmes de performance (la recherche sur mon site est nulle, c'est trop lent, ce n'est pas pertinent, etc.) mais ElasticSearch va vous permettre de faire beaucoup plus de choses :

- Indexer de façon simple vos données, qu'elles soient textuelles, structurées ou semi-structurées.
- Traiter des volumes de données énormes sans avoir à dépenser des fortunes pour l'infrastructure.
- Disposer d'un moteur de recherche bien plus performant que ce qu'on peut faire avec du SQL, que ce soit en termes de possibilités de recherche, en termes de performances, ou en termes de pertinence des réponses obtenues.
- Traiter correctement les problèmes linguistiques et sémantiques.
- Analyser vos données (data mining) et produire de la connaissance à partir des informations dont vous disposez déjà.
- Incorporer en temps réel les flux de données produits (des tweets, des logs...)
- Mettre en place très facilement une interface de recherche moderne : recherche transversale sur plusieurs corpus (recherche universelle), recherche "à la google", auto-completion, recherche guidée par des facettes, etc.
- etc.

Au delà de ça, ElasticSearch influe sur la façon même de développer une application moderne : il devient enfin possible de se libérer des limites et contraintes imposées par les bases relationnelles SQL (jointures, normalisation 3NF, UML) et de revenir à des concepts beaucoup plus simples à appréhender (DDD, modélisation entités-relations, etc.)

## Docalist Search

Docalist Search est un petit plugin pour WordPress. Son objectif est simple : vous permettre de disposer facilement de la puissance d'ElasticSearch pour votre site WordPress.

Par défaut, il ne fait pas grand chose : il sait juste indexer (en temps réel) les articles et les pages de votre site.

Son réel intérêt réside dans son API (entièrement orientée objet) qui permet d'indexer n'importe quel contenu, qu'ils s'agisse de contenus WordPress (custom post types, commentaires, utilisateurs, custom fields, tables sql spécifiques) ou de contenus externes (données provenant d'autres services, ficheiers, etc.)

## Le plugin de démo

Docalist Search Book Demo est un plugin de démonstration qui montre comment utiliser Docalist Search pour indexer un contenu très simple.

Il crée un custom post type "Livre" contenant juste quelques champs (titre, description, genre littéraire) et montre comment développer un indexeur spécifique pour indexer nos livres dans ElasticSearch.

Il montre également comment utiliser l'API Docalist Search pour créer manuellement une recherche ou pour implémenter un formulaire de recherche "à la google".

En marge, il illustre également quelques unes des bonnes pratiques que nous promouvons en matière de développement de plugins WordPress.
