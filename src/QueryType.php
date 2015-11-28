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
        WpUtils $wpUtils
    ) {
        $fields = [];
        foreach ($postTypes as $key => $type) {
            $fields[$type] = [
                'type' => $postObjectTypes[$key],
                'args' => [
                    'ID' => [
                        'description' => "The ID of the {$type}",
                        'type' => Type::nonNull(Type::int()),
                    ],
                ],
                'resolve' => function ($root, $args) use ($wpUtils) {
                    return $wpUtils->fetchPost($args['ID']);
                }
            ];
        }

        parent::__construct([
            'name' => 'Query',
            'fields' => $fields,
        ]);
    }
}
