<?php

namespace WpGraphQL;

class WpPostMapper
{
    const FIELD_MAP = [
        'id' => 'ID',
        'author' => 'post_author',
        'name' => 'post_name',
        'type' => 'post_type',
        'title' => 'post_title',
        'date' => 'post_date',
        'content' => 'post_content',
        'excerpt' => 'post_excerpt',
        'status' => 'post_status',
        'commentStatus' => 'comment_status',
        'pingStatus' => 'ping_status',
        'password' => 'post_password',
        'parent' => 'post_parent',
        'modified' => 'post_modified',
        'commentCount' => 'comment_count',
        'menuOrder' => 'menu_order',
   ];

    const FIELD_DEFAULT = [
        'id' => '0',
        'author' => '0',
        'name' => '',
        'type' => '',
        'title' => '',
        'date' => '0000-00-00 00:00:00',
        'content' => '',
        'excerpt' => '',
        'status' => '',
        'commentStatus' => '',
        'pingStatus' => '',
        'parent' => '0',
        'modified' => '0000-00-00 00:00:00',
        'commentCount' => '0',
        'menuOrder' => '0',
   ];

    /**
     * Map a WordPress post to a GraphQL object
     *
     * @param  array  $post Post information from WordPress
     * @return array        Post information to expose.
     */
    public function mapWpPost(array $post)
    {
        $map = [];

        foreach (self::FIELD_MAP as $field => $key) {
            $val = (isset($post[$key])) ? $post[$key] : self::FIELD_DEFAULT[$field];

            $map[$field] = $this->formatVal($field, $val);
        }

        return $map;
    }

    /**
     * Format field values
     *
     * @param  string $field Field key
     * @param  string $val   Value from WordPress
     * @return mixed         Formatted value.
     */
    protected function formatVal($field, $val)
    {
        switch ($field) {
            case 'id' :
            case 'author' :
            case 'parent' :
            case 'commentCount' :
            case 'menuOrder' :
                return (int) $val;
            case 'date' :
            case 'modified' :
                return \DateTime::createFromFormat('Y-m-d H:i:s', $val)
                    ->format(\DateTime::ISO8601);
            default :
                return $val;
        }
    }
}
