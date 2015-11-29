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

        if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
            $rawBody = file_get_contents('php://input');
            $data = json_decode($rawBody ?: '', true);
        } else {
            $data = $_POST;
        }

        $query = isset($data['query']) ? $data['query'] : null;
        $operation = isset($data['operation']) ? $data['operation'] : null;
        $variables = isset($data['variables']) ? $data['variables'] : null;

        $endpoint = new Endpoint();
        $endpoint->handleRequest($query, $operation, $variables);

        exit();
    }
}
