<?php

namespace WpGraphQL;

class WpUserMapper
{
    /**
     * Map field names to WordPress keys
     */
    const FIELD_MAP = [
        'id' => 'ID',
        'nickname' => 'nickname',
        'firstName' => 'first_name',
        'lastName' => 'last_name',
        'displayName' => 'display_name',
        'description' => 'description',
        'email' => 'user_email',
        'url'=> 'user_url',
        'registered' => 'user_registered',
        'authoredCount' => 'authored_count',
    ];

    /**
     * Define default field values
     */
    const FIELD_DEFAULT = [
        'id' => '0',
        'nickname' => '',
        'firstName' => '',
        'lastName' => '',
        'displayName' => '',
        'description' => '',
        'email' => '',
        'url' => '',
        'registered' => '0000-00-00 00:00:00',
        'authoredCount' => '0',
    ];

    /**
     * Map a WordPress user to a GraphQL object
     *
     * @param  array  $user User information from WordPress
     * @return array        User information to expose.
     */
    public function mapWpUser(array $user)
    {
        $map = [];

        foreach (self::FIELD_MAP as $field => $key) {
            $val = (isset($user[$key])) ? $user[$key] : self::FIELD_DEFAULT[$field];

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
            case 'authoredCount' :
                return (int) $val;
            case 'registered' :
                return \DateTime::createFromFormat('Y-m-d H:i:s', $val)
                    ->format(\DateTime::ISO8601);
            default :
                return $val;
        }
    }
}
