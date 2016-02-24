<?php

/**
 * Documentation for Restful service extension
 */
return new \oat\taoRestAPI\service\docs\RestApiDocsService([
    'proxy' => 'Swagger',
    'routes' => DEBUG_MODE ? [
        'Example' => '\oat\taoRestAPI\model\example\v1\HttpRoute'
    ] : []
]);