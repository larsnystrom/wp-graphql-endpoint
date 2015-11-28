<?php

namespace WpGraphQL;

class WpHooks
{
    const ENDPOINT = 'graphql';

    /**
     * Initialization hook
     *
     * Creates routes.
     *
     * @return null
     */
    public static function init()
    {
        add_rewrite_endpoint(self::ENDPOINT, EP_ROOT);
    }

    /**
     * Template redirect hook.
     *
     * Handles routing.
     *
     * @return null
     */
    public static function templateRedirect()
    {
        global $wp_query;

        if (empty($wp_query->get(self::ENDPOINT))) {
            return;
        }

        $endpoint = new Endpoint();
        $endpoint->handleRequest();

        exit();
    }
}
