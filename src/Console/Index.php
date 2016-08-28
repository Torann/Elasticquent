<?php

namespace Elasticquent\Console;

class Index extends AbstractCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:index
                                {model : Name or comma separated names of the model(s) to index}
                                {--s|silent : Do not output any exceptions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index or reindex all the entries in an Eloquent model.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Perform actions on models
        foreach ($this->getModelArgument() as $model) {
            $model = "\\App\\{$model}";

            if ($this->validateModel($model) === true) {
                $this->line('');
                $this->indexModel($model);
            }
        }
    }

    /**
     * Index all model entries to ElasticSearch.
     *
     * @param string $model
     */
    protected function indexModel($model)
    {
        // Create index if it doesn't exists
        if ($model::mappingExists() === false) {
            // Creating model map
            $this->output->write("- Mapping {$model}...");
            $this->makeCall($model, 'putMapping');

            $this->line('');

            // Index model
            $this->output->write("- Indexing {$model}...");
            $this->makeCall($model, 'addAllToIndex');
        }

        // Index already exists, just reindex data
        else {
            // Index model
            $this->output->write("- Reindexing {$model}...");
            $this->makeCall($model, 'reindex');
        }
    }
}
