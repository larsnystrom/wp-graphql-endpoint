<?php

namespace WpGraphQL;

use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\Type;

/**
 * Characters in the Star Wars trilogy are either humans or droids.
 *
 * This implements the following type system shorthand:
 *   interface Character {
 *     id: String!
 *     name: String
 *     friends: [Character]
 *     appearsIn: [Episode]
 *   }
 */
class CharacterInterface extends InterfaceType
{
    public function __construct(
        EpisodeEnum $episodeEnum
    ) {
        $characterInterface = $this;

        parent::__construct([
            'name' => 'Character',
            'description' => 'A character in the Star Wars Trilogy',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The id of the character.',
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => 'The name of the character.'
                ],
                'friends' => [
                    'type' => function () use (&$characterInterface) {
                        return Type::listOf($characterInterface);
                    },
                    'description' => 'The friends of the character.',
                ],
                'appearsIn' => [
                    'type' => Type::listOf($episodeEnum),
                    'description' => 'Which movies they appear in.'
                ]
            ],
        ]);
    }
}
