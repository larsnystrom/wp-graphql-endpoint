<?php

namespace WpGraphQL;

use GraphQL\Type\Definition\EnumType;

/**
 * The original trilogy consists of three movies.
 *
 * This implements the following type system shorthand:
 *   enum Episode { NEWHOPE, EMPIRE, JEDI }
 */
class EpisodeEnum extends EnumType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Episode',
            'description' => 'One of the films in the Star Wars Trilogy',
            'values' => [
                'NEWHOPE' => [
                    'value' => 4,
                    'description' => 'Released in 1977.'
                ],
                'EMPIRE' => [
                    'value' => 5,
                    'description' => 'Released in 1980.'
                ],
                'JEDI' => [
                    'value' => 6,
                    'description' => 'Released in 1983.'
                ],
            ]
        ]);
    }
}
