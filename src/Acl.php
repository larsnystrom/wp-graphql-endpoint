<?php

namespace WpGraphQL;

use GraphQL\Type\Definition\ResolveInfo;

class Acl
{
    public function isAuthorized(ResolveInfo $info)
    {
        return true;
    }
}
