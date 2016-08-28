<?php

namespace Elasticquent\Console;

use Elasticquent\ElasticquentClientTrait;

class Install extends AbstractCommand
{
    use ElasticquentClientTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the Elasticsearch index.';

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
        if ($client->indices()->exists($index)) {
            $this->comment('Index already exists');
            exit;
        }

        // Check for default settings
        if ($settings = config('elasticquent.default_settings')) {
            $index['body'] = [
                'settings' => $settings
            ];
        }

        return $client->indices()->create($index);
    }
}
