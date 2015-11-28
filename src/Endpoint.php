<?php

namespace WpGraphQL;

use GraphQL\GraphQL;

class Endpoint
{
    public function handleRequest()
    {
        // if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
        //     $rawBody = file_get_contents('php://input');
        //     $data = json_decode($rawBody ?: '', true);
        // } else {
        //     $data = $_POST;
        // }

        define("QUERY", 'query FetchLukeQuery {
          human(id: "1000") {
            name
            friends {
              name
            }
          }
        }');

        $data = [
            'query' => QUERY,
        ];

        $requestString = isset($data['query']) ? $data['query'] : null;
        $operationName = isset($data['operation']) ? $data['operation'] : null;
        $variableValues = isset($data['variables']) ? $data['variables'] : null;

        // try {
            // Define your schema:
            $schema = SchemaFactory::build();
            $result = GraphQL::execute(
                $schema,
                $requestString,
                /* $rootValue */ null,
                $variableValues,
                $operationName
            );
        // } catch (\Exception $exception) {
        //     $result = [
        //         'errors' => [
        //             ['message' => $exception->getMessage()]
        //         ]
        //     ];
        // }

        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
