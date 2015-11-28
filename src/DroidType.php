<?php

namespace WpGraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * We define our droid type, which implements the character interface.
 *
 * This implements the following type system shorthand:
 *   type Droid : Character {
 *     id: String!
 *     name: String
 *     friends: [Character]
 *     appearsIn: [Episode]
 *   }
 */
class DroidType extends ObjectType
{
    public function __construct(
        EpisodeEnum $episodeEnum,
        CharacterInterface $characterInterface
    ) {
        parent::__construct([
            'name' => 'Droid',
            'description' => 'A droid in the Star Wars universe.',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The id of the droid.',
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => 'The name of the droid.',
                ],
                'friends' => [
                    'type' => Type::listOf($characterInterface),
                    'description' => 'The friends of the droid',
                    'resolve' => function ($droid) {
                        return StarWarsData::getFriends($droid);
                    },
                ],
                'appearsIn' => [
                    'type' => Type::listOf($episodeEnum),
                    'description' => 'Which movies they appear in.'
                ],
                'homePlanet' => [
                    'type' => Type::string(),
                    'description' => 'The home planet of the droid, or null if unknown.'
                ],
            ],
            'interfaces' => [$characterInterface],
            'isTypeOf' => function ($value, ResolveInfo $info) {
                if (!is_array($value) || !isset($value['id'])) {
                    return false;
                }

                return ($value['id'] >= 2000 && $value['id'] <= 2999);
            },
        ]);
    }
}
