<?php

namespace WpGraphQL;

/**
 * Abstract away all WordPress function calls to make
 * debugging a litte bit easier and testing a lot easier.
 */
class WpUtils
{
    protected $wpUserMapper;
    protected $wpPostMapper;

    public function __construct()
    {
        $this->wpUserMapper = new WpUserMapper();
        $this->wpPostMapper = new WpPostMapper();
    }

    public function getPostTypes()
    {
        $types = array_values(
            get_post_types([
                    'public' => true,
                ],
                'names'
            )
        );

        return $types;
    }

    public function fetchPost($id)
    {
        $post = get_post($id, ARRAY_A);

        return $this->wpPostMapper->mapWpPost(
            $post
        );
    }

    public function fetchAuthor($id)
    {
        global $wpdb;

        $users = get_users([
            'orderby' => 'ID',
            'order' => 'ASC',
            'number' => 1,
            'has_published_posts' => true,
            'include' => [$id],
        ]);

        if (empty($users)) {
            return [];
        }

        $user = array_pop($users);
        $meta = get_user_meta($user->ID);

        array_walk($meta, function (&$val) {
            if (is_array($val)) {
                $val = array_pop($val);
            }
        });

        $result = $wpdb->get_col(
            "SELECT DISTINCT COUNT(ID) AS count "
            . "FROM $wpdb->posts "
            . "WHERE " . get_posts_by_author_sql($this->getPostTypes(), false, $user->ID, true) . " "
            . "GROUP BY post_author"
        );
        $authoredCount = array_pop($result);

        $data = $this->wpUserMapper->mapWpUser(array_merge(
            $meta,
            ['authored_count' => $authoredCount],
            (array) $user->data
        ));

        return $data;
    }
}
