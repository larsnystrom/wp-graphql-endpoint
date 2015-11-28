<?php

namespace WpGraphQL;

use GraphQL\Schema;

class SchemaFactory
{
    public static function build()
    {
        $episodeEnum = new EpisodeEnum();
        $characterInterface = new CharacterInterface($episodeEnum);
        $humanType = new HumanType($episodeEnum, $characterInterface);
        $droidType = new DroidType($episodeEnum, $characterInterface);

        $queryType = new QueryType($episodeEnum, $characterInterface, $humanType, $droidType);

        return new Schema($queryType);
    }
}
