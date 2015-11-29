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
        $userInterface = new UserInterface();

        $authorType = new AuthorType($userInterface);

        $postInterface = new PostInterface($authorType);

        $postTypes = $this->wpUtils->getPostTypes();

        $postObjectTypes = array_map(function ($type) use ($postInterface, $authorType) {
            return new ObjectType(
                $this->getPostTypeSpecification($type, $postInterface, $authorType)
            );
        }, $postTypes);


        $queryType = new QueryType(
            $postTypes,
            $postInterface,
            $postObjectTypes,
            $authorType,
            $this->wpUtils
        );

        return new Schema($queryType);
    }

    protected function getPostTypeSpecification($type, PostInterface $postInterface, AuthorType $authorType)
    {
        return [
            'name' => $type,
            'description' => "A post of type {$type}",
            'interfaces' => [$postInterface],
            'isTypeOf' => function ($value, ResolveInfo $info) use ($type) {
                if (!is_array($value) || !isset($value['type'])) {
                    return false;
                }

                return ($value['type'] === $type);
            },
            'fields' => [
                'id' => [
                    'type' => Type::int(),
                    'description' => "The id of the {$type}",
                ],
                'author' => [
                    'type' => $authorType,
                    'description' => "The {$type} author",
                    'resolve' => function ($value) {
                        return $this->wpUtils->fetchAuthor($value['author']);
                    },
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => "The {$type}'s slug",
                ],
                'type' => [
                    'type' => Type::string(),
                    'description' => "See Post Types",
                ],
                'title' => [
                    'type' => Type::string(),
                    'description' => "The title of the {$type}",
                ],
                'date' => [
                    'type' => Type::string(),
                    'description' => "Formatted according to ISO-8601",
                ],
                'content' => [
                    'type' => Type::string(),
                    'description' => "The full content of the {$type}",
                ],
                'excerpt' => [
                    'type' => Type::string(),
                    'description' => "User-defined {$type} excerpt",
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
                    'description' => "Number of comments on {$type}",
                ],
                'menuOrder' => [
                    'type' => Type::int(),
                    'description' => "Order value as set through page-attribute when enabled",
                ],
            ],
        ];
    }
}
