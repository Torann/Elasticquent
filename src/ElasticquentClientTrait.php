<?php

namespace Elasticquent;

use Elasticsearch\Client;

trait ElasticquentClientTrait
{
    /**
     * Get ElasticSearch Client
     *
     * @return \Elasticsearch\Client
     */
    public function getElasticSearchClient()
    {
        return app(Client::class);
    }

    /**
     * Get Index Name
     *
     * @return string
     */
    public function getIndexName()
    {
        return config('elasticquent.default_index', 'default');
    }
}
