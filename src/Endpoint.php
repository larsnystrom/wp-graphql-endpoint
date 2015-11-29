<?php

namespace WpGraphQL;

use GraphQL\GraphQL;

class Endpoint
{
    /**
     * Handle incoming GraphQL request
     *
     * Handle incoming GraphQL request, send headers
     * and echo json content.
     *
     * @param  string                 $query     GraphQL query.
     * @param  string|null            $operation Operation name.
     * @param  array|ArrayAccess|null $variables Variable values.
     * @return null
     */
    public function handleRequest($query, $operation = null, $variables = null)
    {
        try {
            $factory = new SchemaFactory();
            $schema = $factory->build();

            $result = GraphQL::execute(
                $schema,
                $query,
                /* $rootValue */ null,
                $variables,
                $operation
            );
        } catch (\Exception $exception) {
            $result = [
                'errors' => [
                    ['message' => $exception->getMessage()]
                ]
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
