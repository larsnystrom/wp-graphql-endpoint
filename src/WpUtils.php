<?php

namespace WpGraphQL;

/**
 * Abstract away all WordPress function calls to make
 * debugging a litte bit easier and testing a lot easier.
 */
class WpUtils
{
    public function getPostTypes()
    {
        return get_post_types([
                'public' => true,
            ],
            'names'
        );
    }

    public function fetchPost($id)
    {
        $post = get_post($id, ARRAY_A);
        return $post;
    }
}
