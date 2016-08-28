<?php

namespace Elasticquent\Console;

use Elasticquent\ElasticquentClientTrait;

class Uninstall extends AbstractCommand
{
    use ElasticquentClientTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the Elasticsearch index.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get Elasticsearch client
        $client = $this->getElasticSearchClient();

        $index = [
            'index' => $this->getIndexName(),
        ];

        // Check for index
        if ($client->indices()->exists($index) === false) {
            $this->comment('Index does not exists');
            exit;
        }

        return $client->indices()->delete($index);
    }
}
