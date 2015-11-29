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

        $data = [
            'query' => 'query FetchPageQuery {
                page(id: 2) {
                    id
                    author
                    name
                    type
                    title
                    date
                    content
                    excerpt
                    status
                    commentStatus
                    pingStatus
                    parent
                    modified
                    commentCount
                    menuOrder
                }
            }',
        ];
        // $data = [
        //     'query' => 'query FetchPageQuery {
        //         author(id: 1) {
        //             id
        //             nickname
        //             first_name
        //             last_name
        //             display_name
        //             description
        //             email
        //             url
        //             registered
        //             authored_count
        //         }
        //     }',
        // ];

        $requestString = isset($data['query']) ? $data['query'] : null;
        $operationName = isset($data['operation']) ? $data['operation'] : null;
        $variableValues = isset($data['variables']) ? $data['variables'] : null;

        // try {
            // Define your schema:
            $factory = new SchemaFactory();
            $schema = $factory->build();
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
