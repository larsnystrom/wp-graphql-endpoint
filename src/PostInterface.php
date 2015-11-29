<?php

namespace WpGraphQL;

use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\Type;

/**
 * Post interface
 */
class PostInterface extends InterfaceType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Post Interface',
            'description' => 'A post of any post type',
            'fields' => [
                'id' => [
                    'type' => Type::int(),
                    'description' => "The id of the post",
                ],
                'author' => [
                    'type' => Type::string(),
                    'description' => "The post author's user id (numeric string)",
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => "The post's slug",
                ],
                'type' => [
                    'type' => Type::string(),
                    'description' => "See Post Types",
                ],
                'title' => [
                    'type' => Type::string(),
                    'description' => "The title of the post",
                ],
                'date' => [
                    'type' => Type::string(),
                    'description' => "Formatted according to ISO-8601",
                ],
                'content' => [
                    'type' => Type::string(),
                    'description' => "The full content of the post",
                ],
                'excerpt' => [
                    'type' => Type::string(),
                    'description' => "User-defined post excerpt",
                ],
                'status' => [
                    'type' => Type::string(),
                    'description' => "See get_post_status for values",
                ],
                'commentStatus' => [
                    'type' => Type::string(),
                    'description' => "Returns: { open, closed }",
                ],
                'pingStatus' => [
                    'type' => Type::string(),
                    'description' => "Returns: { open, closed }",
                ],
                'parent' => [
                    'type' => Type::int(),
                    'description' => "Parent Post id (default 0)",
                ],
                'modified' => [
                    'type' => Type::string(),
                    'description' => "Formatted according to ISO-8601",
                ],
                'commentCount' => [
                    'type' => Type::int(),
                    'description' => "Number of comments on post",
                ],
                'menuOrder' => [
                    'type' => Type::int(),
                    'description' => "Order value as set through page-attribute when enabled",
                ],
            ],
        ]);
    }
}
