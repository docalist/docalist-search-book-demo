<?php
/**
 * This file is part of the "Docalist Search: Book Demo" plugin.
 *
 * Copyright (C) 2015 Daniel Ménard
 *
 * For copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 *
 * @author      Daniel Ménard <daniel.menard@laposte.net>
 */
namespace Docalist\BookDemo\Views;

use Docalist\Search\SearchRequest;

/*
 * Démo de l'API SearchRequest de docalist-search.
 */
?>
<div class="wrap">
    <h2><?=get_admin_page_title()?></h2>

    <p>Cette page crée une requête docalist-search qui recherche :</p>
    <ul class="ul-square">
        <li>les documents de type <code>bookdemo</code>,</li>
        <li>qui ont le genre littéraire <code>roman</code>,</li>
        <li>et contiennent le mot <code>vie</code> et l'expression exacte
            <code>"remise en question"</code> dans la description.
        </li>
    </ul>
    <p>La requête est codée en dur dans le code source
        (<code>/plugins/docalist-search-book-demo/views/searchrequest-test.php</code>).
    </p>
<?php
    // Crée la requête
    $request = (new SearchRequest())
        ->filter('_type', 'bookdemo')
        ->search('booktype', 'roman')
        ->search('content', 'vie')
        ->search('content', '"remise en question"');

    // Exécute la requête
    $results = $request->execute();

    // Affiche la requête exécutée
    echo '<h2>Recherche de livres</h2>';
    printf('<p>Votre recherche : <code>%s</code></p>', $request->asEquation());

    // Affiche le temps d'exécution de la requête
    printf(
        '<p><small>Requête exécutée en %d ms (temps total %d ms).</small></p>',
        $results->took(),
        $results->time() * 1000
    );

    // Aucune réponse ?
    if (empty($hits = $results->hits())) {
        echo '<h2>Aucune réponse, désolé !</h2>';
    }

    // Affiche les réponses obtenues
    else {
        // Indique le nombre de réponses obtenues et la position des résultats affichés
        printf(
            '<h2>%d réponse(s) trouvée(s), affichage des réponses %d à %d :</h2>',
            $total = $results->total(),
            $start = 1 + ($request->page() - 1) * $request->size(),
            min($total, $start + $request->size() - 1)
        );

        // Affiche la liste des réponses
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
?>
</div>
