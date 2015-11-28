<?php

namespace WpGraphQL;

use GraphQL\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;

class SchemaFactory
{
    public function __construct()
    {
        $this->wpUtils = new WpUtils();
    }

    /**
     * Construct a GraphQL Schema
     *
     * @return GraphQL\Schema
     */
    public function build()
    {
        $postInterface = new PostInterface();

        $postTypes = $this->wpUtils->getPostTypes();
        $postObjectTypes = [];

        foreach ($postTypes as $key => $type) {
            $postObjectTypes[$key] = new ObjectType(
                $this->getPostTypeSpecification($type, $postInterface)
            );
        }

        $queryType = new QueryType($postTypes, $postInterface, $postObjectTypes, $this->wpUtils);

        return new Schema($queryType);
    }

    protected function getPostTypeSpecification($type, PostInterface $postInterface)
    {
        return [
            'name' => $type,
            'description' => "A post of type {$type}",
            'fields' => [
                'ID' => [
                    'type' => Type::int(),
                    'description' => "The ID of the {$type}",
                ],
                'post_author' => [
                    'type' => Type::string(),
                    'description' => "The {$type} author's user ID (numeric string)",
                ],
                'post_name' => [
                    'type' => Type::string(),
                    'description' => "The {$type}'s slug",
                ],
                'post_type' => [
                    'type' => Type::string(),
                    'description' => "See Post Types",
                ],
                'post_title' => [
                    'type' => Type::string(),
                    'description' => "The title of the {$type}",
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
                    'description' => "The full content of the {$type}",
                ],
                'post_excerpt' => [
                    'type' => Type::string(),
                    'description' => "User-defined {$type} excerpt",
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
                    'description' => "Number of comments on {$type} (numeric string)",
                ],
                'menu_order' => [
                    'type' => Type::string(),
                    'description' => "Order value as set through page-attribute when enabled (numeric string. Defaults to 0)",
                ],
            ],
            'interfaces' => [$postInterface],
            'isTypeOf' => function ($value, ResolveInfo $info) use ($type) {
                if (!is_array($value) || !isset($value['post_type'])) {
                    return false;
                }

                return ($value['post_type'] === $type);
            },
        ];
    }
}
