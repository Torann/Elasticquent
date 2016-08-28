<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom Elasticsearch Client Configuration
    |--------------------------------------------------------------------------
    |
    | This array will be passed to the Elasticsearch client.
    | See configuration options here:
    |
    | http://www.elasticsearch.org/guide/en/elasticsearch/client/php-api/current/_configuration.html
    */

    'config' => [
        'hosts' => ['localhost:9200'],
        'retries' => 1,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Index Name
    |--------------------------------------------------------------------------
    |
    | This is the index name that Elasticquent will use for all
    | Elasticquent models.
    */

    'default_index' => 'my_custom_index_name',

    /*
    |--------------------------------------------------------------------------
    | Default Index Settings
    |--------------------------------------------------------------------------
    |
    | This is the settings used when creating an Elasticsearch index.
    |
    | 'default_settings' => [
    |     'number_of_shards' => 1,
    |     'analysis' => [
    |         'filter' => [
    |             'autocomplete_filter' => [
    |                 'type' => 'edge_ngram',
    |                 'min_gram' => 1,
    |                 'max_gram' => 20,
    |             ],
    |         ],
    |         'analyzer' => [
    |             'autocomplete' => [
    |                 'type' => 'custom',
    |                 'tokenizer' => 'standard',
    |                 'filter' => [
    |                     'lowercase',
    |                     'autocomplete_filter',
    |                 ],
    |             ],
    |         ],
    |     ],
    | ],
    */

    'default_settings' => null,
];
