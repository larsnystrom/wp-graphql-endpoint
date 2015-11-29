<?php

namespace WpGraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct(
        array $postTypes,
        PostInterface $postInterface,
        array $postObjectTypes,
        AuthorType $authorType,
        WpUtils $wpUtils
    ) {
        $fields = [
            'author' => [
                'type' => $authorType,
                'args' => [
                    'id' => [
                        'description' => "The id of the author",
                        'type' => Type::nonNull(Type::int()),
                    ],
                ],
                'resolve' => function ($root, $args) use ($wpUtils) {
                    return $wpUtils->fetchAuthor($args['id']);
                },
            ],
        ];

        foreach ($postTypes as $key => $type) {
            $fields[$type] = [
                'type' => $postObjectTypes[$key],
                'args' => [
                    'id' => [
                        'description' => "The id of the {$type}",
                        'type' => Type::nonNull(Type::int()),
                    ],
                ],
                'resolve' => function ($root, $args) use ($wpUtils) {
                    return $wpUtils->fetchPost($args['id']);
                }
            ];
        }

        parent::__construct([
            'name' => 'Query',
            'fields' => $fields,
        ]);
    }
}
