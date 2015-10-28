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

use Exception;

/**
 * Class principale du plugin.
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
        load_plugin_textdomain('docalist-search-demo-book', false, 'docalist-search-demo-book/languages');

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
                __("Test de l'API de recherche docalist-search", 'docalist-search-demo-book/languages'),
                __('API SearchRequest', 'docalist-search-demo-book/languages'),
                'manage_options',
                'docalist-book-search-request', function () {
                    $this->view('searchrequest');
                });
        });
    }

    /**
     * Crée la taxonomie WordPress "Types de livres".
     */
    protected function registerTaxonomy()
    {
        register_taxonomy(self::TAXONOMY, [], [
            'labels' => [
                'name' => __('Types de livres', 'docalist-search-demo-book'),
                'singular_name' => __('Type de livre', 'docalist-search-demo-book'),
                'menu_name' => __('Types de livres', 'docalist-search-demo-book'),
                'all_items' => __('Tous les types', 'docalist-search-demo-book'),
                'new_item_name' => __('Nouveau type', 'docalist-search-demo-book'),
                'add_new_item' => __('Ajouter un type', 'docalist-search-demo-book'),
                'edit_item' => __('Modifier le type', 'docalist-search-demo-book'),
                'update_item' => __('Enregistrer', 'docalist-search-demo-book'),
                'view_item' => __('Voir le type', 'docalist-search-demo-book'),
                'separate_items_with_commas' => __('Séparez les types avec une virgule', 'docalist-search-demo-book'),
                'add_or_remove_items' => __('Ajouter ou supprimer des types', 'docalist-search-demo-book'),
                'choose_from_most_used' => __('Choisissez parmi les types les plus souvent utilisés', 'docalist-search-demo-book'),
                'popular_items' => __('Types courants', 'docalist-search-demo-book'),
                'search_items' => __('Rechercher un type', 'docalist-search-demo-book'),
                'not_found' => __('Non trouvé', 'docalist-search-demo-book'),

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
                'name' => _x('Livres', 'Post Type General Name', 'docalist-search-demo-book'),
                'singular_name' => _x('Livre', 'Post Type Singular Name', 'docalist-search-demo-book'),
                'menu_name' => __('Livres (demo)', 'docalist-search-demo-book'),
                'name_admin_bar' => __('Livre (demo)', 'docalist-search-demo-book'),
                'all_items' => __('Liste des livres', 'docalist-search-demo-book'),
                'add_new_item' => __('Ajouter un livre', 'docalist-search-demo-book'),
                'add_new' => __('Ajouter un livre', 'docalist-search-demo-book'),
                'new_item' => __('Nouveau livre', 'docalist-search-demo-book'),
                'edit_item' => __('Modifier le livre', 'docalist-search-demo-book'),
                'update_item' => __('Enregistrer', 'docalist-search-demo-book'),
                'view_item' => __('Voir le livre', 'docalist-search-demo-book'),
            ],
        ]);
    }

    /**
     * Affiche une vue (un template).
     *
     * @param string $view Nom de la vue à afficher (dans le répertoire 'views' du plugin,
     * ne pas indiquer l'extension '.php' qui est ajoutée automatiquement).
     * @param array $data données à transmettre à la vue
     *
     * @throws Exception
     */
    public function view($view, array $data = [])
    {
        // Détermine le path exact de la vue
        $path = __DIR__ . '/../views/' . $view . '.php';
        if (! is_readable($path)) {
            $msg = __('Vue non trouvée "%s"', 'docalist-search-demo-book');
            throw new Exception(sprintf($msg, $view));
        }

        // Crée la closure qui exécute le template (sandbox)
        $render = function (array $view) {
            extract($view, EXTR_OVERWRITE | EXTR_REFS);

            return require $view['path'];
        };

        $data['view'] = ['name' => $view, 'path' => $path, 'data' => $data];

        // Binde la closure pour que $this soit dispo dans la vue
        $context = isset($data['this']) ? $data['this'] : null;
        $render = $render->bindTo($context, $context);

        // Exécute le template
        return $render($data);
    }
}
