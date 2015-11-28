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
                'ID' => [
                    'type' => Type::int(),
                    'description' => "The ID of the post",
                ],
                'post_author' => [
                    'type' => Type::string(),
                    'description' => "The post author's user ID (numeric string)",
                ],
                'post_name' => [
                    'type' => Type::string(),
                    'description' => "The post's slug",
                ],
                'post_type' => [
                    'type' => Type::string(),
                    'description' => "See Post Types",
                ],
                'post_title' => [
                    'type' => Type::string(),
                    'description' => "The title of the post",
                ],
                'post_date' => [
                    'type' => Type::string(),
                    'description' => "Format: 0000-00-00 00:00:00",
                ],
                'post_date_gmt' => [
                    'type' => Type::string(),
                    'description' => "Format: 0000-00-00 00:00:00",
                ],
                'post_content' => [
                    'type' => Type::string(),
                    'description' => "The full content of the post",
                ],
                'post_excerpt' => [
                    'type' => Type::string(),
                    'description' => "User-defined post excerpt",
                ],
                'post_status' => [
                    'type' => Type::string(),
                    'description' => "See get_post_status for values",
                ],
                'comment_status' => [
                    'type' => Type::string(),
                    'description' => "Returns: { open, closed }",
                ],
                'ping_status' => [
                    'type' => Type::string(),
                    'description' => "Returns: { open, closed }",
                ],
                'post_password' => [
                    'type' => Type::string(),
                    'description' => "Returns empty string if no password",
                ],
                'post_parent' => [
                    'type' => Type::int(),
                    'description' => "Parent Post ID (default 0)",
                ],
                'post_modified' => [
                    'type' => Type::string(),
                    'description' => "Format: 0000-00-00 00:00:00",
                ],
                'post_modified_gmt' => [
                    'type' => Type::string(),
                    'description' => "Format: 0000-00-00 00:00:00",
                ],
                'comment_count' => [
                    'type' => Type::string(),
                    'description' => "Number of comments on post (numeric string)",
                ],
                'menu_order' => [
                    'type' => Type::string(),
                    'description' => "Order value as set through page-attribute when enabled (numeric string. Defaults to 0)",
                ],
            ],
        ]);
    }
}
