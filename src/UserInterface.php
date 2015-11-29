<?php

namespace WpGraphQL;

use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\Type;

/**
 * Post interface
 */
class UserInterface extends InterfaceType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'User Interface',
            'description' => 'A user on this site',
            'fields' => [
                'id' => [
                    'type' => Type::int(),
                    'description' => "The id of the user",
                ],
                'nickname' => [
                    'type' => Type::string(),
                    'description' => "The user's nickname",
                ],
                'firstName' => [
                    'type' => Type::string(),
                    'description' => "The user's given name",
                ],
                'lastName' => [
                    'type' => Type::string(),
                    'description' => "The user's surname",
                ],
                'displayName' => [
                    'type' => Type::string(),
                    'description' => "User's preferred name",
                ],
                'description' => [
                    'type' => Type::string(),
                    'description' => "A description of the user",
                ],
                'email' => [
                    'type' => Type::string(),
                    'description' => "User's email address",
                ],
                'url' => [
                    'type' => Type::string(),
                    'description' => "User's website",
                ],
                'registered' => [
                    'type' => Type::string(),
                    'description' => "Formatted according to ISO-8601",
                ],
                'authoredCount' => [
                    'type' => Type::int(),
                    'description' => "Number of authored public posts",
                ],
            ],
        ]);
    }
}
