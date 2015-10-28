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
namespace Docalist\BookDemo;

use Docalist\Search\PostIndexer;
use Docalist\Search\MappingBuilder;

/**
 * Indexeur docalist-Search pour les livres.
 */
class BookIndexer extends PostIndexer
{
    /**
     * Crée un nouvel indexeur de livres.
     */
    public function __construct() {
        parent::__construct(Plugin::POST_TYPE);
    }

    /**
     * Retourne le mapping ElasticSearch pour les livres.
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping.html
     *
     * @return array Le mapping à utiliser pour ce type.
     */
    public function mapping()
    {
        $builder = new MappingBuilder('fr-text');
        $builder->field('booktype')->text()->filter();

        return array_merge_recursive(parent::mapping(), $builder->mapping());

        // Note for myself : utiliser array_merge_recursive() fonctionne dans notre cas,
        // mais ce n'est pas top car ça dédouble les meta (et de manière générale les entrées
        // qui ont une clé numérique)
        // Ce serait mieux d'avoir une méthode ad hoc du style :
        //     MappingBuilder::mergeWith(array otherMapping).
        // On pourrait alors écrire :
        //     $builder->mergeWith(parent::mapping());
        //     return $builder->mapping();
    }

    /**
     * Convertit un post WordPress de type 'bookdemo' en document Elastic Search.
     *
     * @param WP_Post $post Le post WordPress à convertir.
     *
     * @return array Les données à stocker dans ElasticSearch.
     */
    public function map($post) /* @var $post WP_Post */
    {
        $document = parent::map($post);
        $document['booktype'] = wp_get_post_terms($post->ID, 'booktype', ['fields' => 'names']);

        return $document;
    }
}