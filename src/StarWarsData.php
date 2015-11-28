<?php

namespace WpGraphQL;

class StarWarsData
{
    public static function getHero($episode = null)
    {
        return self::droids()['2001'];
    }

    public static function droids()
    {
        return [
            '2000' => [
                'id' => '2000',
                'name' => 'C-3PO',
                'friends' => ['1000', '1002', '1003', '2001'],
                'appearsIn' => [4, 5, 6],
                'homePlanet' => 'Tatooine',
            ],
            '2001' => [
                'id' => '2001',
                'name' => 'R2-D2',
                'friends' => ['1000', '1002', '1003', '2000'],
                'appearsIn' => [4, 5, 6],
                'homePlanet' => 'Tatooine',
            ],
        ];
    }

    public static function humans()
    {
        return [
            '1000' => [
                'id' => '1000',
                'name' => 'Luke Skywalker',
                'friends' => ['1002', '1003', '2000', '2001'],
                'appearsIn' => [4, 5, 6],
                'homePlanet' => 'Tatooine',
            ],
            '1002' => [
                'id' => '1002',
                'name' => 'Han Solo',
                'friends' => ['1000', '1003', '2000', '2001'],
                'appearsIn' => [4, 5, 6],
                'homePlanet' => 'Unknown',

            ],
            '1003' => [
                'id' => '1003',
                'name' => 'Leia Organa',
                'friends' => ['1000', '1002', '2000', '2001'],
                'appearsIn' => [4, 5, 6],
                'homePlanet' => 'Princessland',
            ],
        ];
    }

    public static function getFriends(array $character)
    {
        if (!isset($character['friends']) || !is_array($character['friends'])) {
            throw new \Exception("Impossible! This character has no friends!");
        }

        $humans = self::humans();
        $droids = self::droids();

        $characters = array_combine(
            array_merge(
                // Lets just assume the keys are unique within the character set
                // and not just the human and droid set respectively.
                array_keys($humans),
                array_keys($droids)
            ),
            array_merge(
                array_values($humans),
                array_values($droids)
            )
        );
        $friends = [];

        foreach ($character['friends'] as $friend) {
            if (!isset($characters[$friend])) {
                var_dump($characters);
                throw new \Exception("Fake friend detected");
            }

            $friends[] = $characters[$friend];
        }

        return $friends;
    }
}
