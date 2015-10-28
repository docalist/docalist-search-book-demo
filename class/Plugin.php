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

/**
 * Classe principale du plugin.
 */
class Plugin
{
    /**
     * @var string Nom interne du custom post type "Livre"
     */
    const POST_TYPE = 'bookdemo';

    /**
     * @var string Nom interne de la taxonomie "Types de livres"
     */
    const TAXONOMY = 'booktype';

    /**
     * Initialise le plugin.
     */
    public function __construct()
    {
        // Charge les fichiers de langue du plugin
        load_plugin_textdomain('docalist-search-book-demo', false, 'docalist-search-book-demo/languages');

        // Crée le type "livre" et la taxonomie associée "types de livre"
        add_action('init', function () {
            $this->registerTaxonomy();
            $this->registerPostType();
        });

        // Indique à docalist-search que le type "livre" est un contenu indexable
        add_filter('docalist_search_get_types', function (array $types) {
            $types[self::POST_TYPE] = 'Livres (démo)';

            return $types;
        });

        // Indique à docalist-search l'indexeur à utiliser pour indexer les livres.
        add_filter('docalist_search_get_' . self::POST_TYPE . '_indexer', function () {
            return new BookIndexer();
        });

        // Crée une page dans le menu WP pour illustrer le fonctionnement de SearchRequest
        add_action('admin_menu', function () {
            add_submenu_page(
                'edit.php?post_type=bookdemo',
                __("Test de l'API de recherche docalist-search", 'docalist-search-book-demo/languages'),
                __('API SearchRequest', 'docalist-search-book-demo/languages'),
                'manage_options',
                'docalist-book-search-request',
                function () {
                    docalist('views')->display('docalist-search-book-demo:searchrequest');
                }
            );
        });
    }

    /**
     * Crée la taxonomie WordPress "Types de livres".
     */
    protected function registerTaxonomy()
    {
        register_taxonomy(self::TAXONOMY, [], [
            'labels' => [
                'name' => __('Types de livres', 'docalist-search-book-demo'),
                'singular_name' => __('Type de livre', 'docalist-search-book-demo'),
                'menu_name' => __('Types de livres', 'docalist-search-book-demo'),
                'all_items' => __('Tous les types', 'docalist-search-book-demo'),
                'new_item_name' => __('Nouveau type', 'docalist-search-book-demo'),
                'add_new_item' => __('Ajouter un type', 'docalist-search-book-demo'),
                'edit_item' => __('Modifier le type', 'docalist-search-book-demo'),
                'update_item' => __('Enregistrer', 'docalist-search-book-demo'),
                'view_item' => __('Voir le type', 'docalist-search-book-demo'),
                'separate_items_with_commas' => __('Séparez les types avec une virgule', 'docalist-search-book-demo'),
                'add_or_remove_items' => __('Ajouter ou supprimer des types', 'docalist-search-book-demo'),
                'choose_from_most_used' => __('Choisissez parmi plus souvent utilisés', 'docalist-search-book-demo'),
                'popular_items' => __('Types courants', 'docalist-search-book-demo'),
                'search_items' => __('Rechercher un type', 'docalist-search-book-demo'),
                'not_found' => __('Non trouvé', 'docalist-search-book-demo'),

            ],
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
        ]);
    }

    /**
     * Crée le custom post type WordPress "Livre".
     */
    protected function registerPostType()
    {
        register_post_type(self::POST_TYPE, [
            'public' => true,
            'taxonomies' => [self::TAXONOMY],
            'has_archive' => true,
            'menu_icon' => 'dashicons-book-alt',
            'show_in_nav_menus' => false,
            'labels' => [
                'name' => _x('Livres', 'Post Type General Name', 'docalist-search-book-demo'),
                'singular_name' => _x('Livre', 'Post Type Singular Name', 'docalist-search-book-demo'),
                'menu_name' => __('Livres (demo)', 'docalist-search-book-demo'),
                'name_admin_bar' => __('Livre (demo)', 'docalist-search-book-demo'),
                'all_items' => __('Liste des livres', 'docalist-search-book-demo'),
                'add_new_item' => __('Ajouter un livre', 'docalist-search-book-demo'),
                'add_new' => __('Ajouter un livre', 'docalist-search-book-demo'),
                'new_item' => __('Nouveau livre', 'docalist-search-book-demo'),
                'edit_item' => __('Modifier le livre', 'docalist-search-book-demo'),
                'update_item' => __('Enregistrer', 'docalist-search-book-demo'),
                'view_item' => __('Voir le livre', 'docalist-search-book-demo'),
            ],
        ]);
    }
}
