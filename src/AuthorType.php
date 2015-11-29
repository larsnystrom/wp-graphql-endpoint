<?php

namespace WpGraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;

class AuthorType extends ObjectType
{
    public function __construct(UserInterface $userInterface, Acl $acl)
    {
        parent::__construct([
            'name' => 'Author',
            'description' => 'A user who has authored some posts',
            'interfaces' => [$userInterface],
            'isTypeOf' => function ($value, ResolveInfo $info) use ($type) {
                if (!is_array($value) || !isset($value['authoredCount'])) {
                    return false;
                }

                return ($value['authoredCount'] > 0);
            },
            'resolveField' => function (array $value, array $args, ResolveInfo $info) use ($acl) {
                if (!$acl->isAuthorized($info)) {
                    return null;
                }

                return $value[$info->fieldName];
            },
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
