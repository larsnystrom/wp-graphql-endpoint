<?php

namespace WpGraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * We define our human type, which implements the character interface.
 *
 * This implements the following type system shorthand:
 *   type Human : Character {
 *     id: String!
 *     name: String
 *     friends: [Character]
 *     appearsIn: [Episode]
 *   }
 */
class HumanType extends ObjectType
{
    public function __construct(
        EpisodeEnum $episodeEnum,
        CharacterInterface $characterInterface
    ) {
        parent::__construct([
            'name' => 'Human',
            'description' => 'A humanoid creature in the Star Wars universe.',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The id of the human.',
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => 'The name of the human.',
                ],
                'friends' => [
                    'type' => Type::listOf($characterInterface),
                    'description' => 'The friends of the human',
                    'resolve' => function ($human) {
                        return StarWarsData::getFriends($human);
                    },
                ],
                'appearsIn' => [
                    'type' => Type::listOf($episodeEnum),
                    'description' => 'Which movies they appear in.'
                ],
                'homePlanet' => [
                    'type' => Type::string(),
                    'description' => 'The home planet of the human, or null if unknown.'
                ],
            ],
            'interfaces' => [$characterInterface],
            'isTypeOf' => function ($value, ResolveInfo $info) {
                if (!is_array($value) || !isset($value['id'])) {
                    return false;
                }

                return ($value['id'] >= 1000 && $value['id'] <= 1999);
            },
        ]);
    }
}
