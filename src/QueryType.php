<?php

namespace WpGraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct(
        EpisodeEnum $episodeEnum,
        CharacterInterface $characterInterface,
        HumanType $humanType,
        DroidType $droidType
    ) {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'hero' => [
                    'type' => $characterInterface,
                    'args' => [
                        'episode' => [
                            'description' => 'If omitted, returns the hero of the whole saga. If provided, returns the hero of that particular episode.',
                            'type' => $episodeEnum
                        ]
                    ],
                    'resolve' => function ($root, $args) {
                        return StarWarsData::getHero(isset($args['episode']) ? $args['episode'] : null);
                    },
                ],
                'human' => [
                    'type' => $humanType,
                    'args' => [
                        'id' => [
                            'name' => 'id',
                            'description' => 'id of the human',
                            'type' => Type::nonNull(Type::string())
                        ]
                    ],
                    'resolve' => function ($root, $args) {
                        $humans = StarWarsData::humans();
                        return isset($humans[$args['id']]) ? $humans[$args['id']] : null;
                    }
                ],
                'droid' => [
                    'type' => $droidType,
                    'args' => [
                        'id' => [
                            'name' => 'id',
                            'description' => 'id of the droid',
                            'type' => Type::nonNull(Type::string())
                        ]
                    ],
                    'resolve' => function ($root, $args) {
                        $droids = StarWarsData::droids();
                        return isset($droids[$args['id']]) ? $droids[$args['id']] : null;
                    }
                ]
            ]
        ]);
    }
}
