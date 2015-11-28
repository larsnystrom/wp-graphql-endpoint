<?php
/*
Plugin Name: WP GraphQL Endpoint
Description: A GraphQL endpoint for WordPress.
Version: 0.1
Author: Lars Nyström
*/

namespace WpGraphQL;

// Require composers autoloader.
// Let's just hope nobody else uses an autoloader for now.
require __DIR__ . '/vendor/autoload.php';

// Initialization hook
add_action('init', [WpHooks::class, 'init']);

// Routing hook
add_action('template_redirect', [WpHooks::class, 'templateRedirect']);
