<?php
/**
 * This file is part of the "Docalist Search: Book Demo" plugin.
 *
 * Copyright (C) 2015 Daniel Ménard
 *
 * For copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 *
 * Plugin Name: Docalist Search: Book Demo
 * Plugin URI:  http://docalist.org
 * Description: Tutoriel docalist-search pour l'indexation d'un CPT "book".
 * Version:     0.1
 * Author:      Daniel Ménard
 * Author URI:  http://docalist.org/
 * Text Domain: docalist-search-book-demo
 * Domain Path: /languages
 *
 * @author      Daniel Ménard <daniel.menard@laposte.net>
 */
namespace Docalist\BookDemo;

// Définit une constante pour indiquer que ce plugin est activé
define('DOCALIST_SEARCH_BOOK_DEMO', __FILE__);

/*
 * Initialise le plugin
 */
add_action('plugins_loaded', function () {
    // Auto désactivation si les plugins dont on a besoin ne sont pas activés
    $dependencies = ['DOCALIST_CORE', 'DOCALIST_SEARCH'];
    foreach ($dependencies as $dependency) {
        if (! defined($dependency)) {
            return add_action('admin_notices', function () use ($dependency) {
                deactivate_plugins(plugin_basename(__FILE__));
                unset($_GET['activate']); // empêche wp d'afficher "extension activée"
                $dependency = ucwords(strtolower(strtr($dependency, '_', ' ')));
                $plugin = get_plugin_data(__FILE__, true, false)['Name'];
                echo "<div class='error'><p><b>$plugin</b> requires <b>$dependency</b>.</p></div>";
            });
        }
    }

    // Ok, nos dépendances sont dispos
    docalist('autoloader')->add(__NAMESPACE__, __DIR__ . '/class');
    docalist('services')->add('docalist-search-book-demo', new Plugin());
});
