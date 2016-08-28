<?php

namespace Elasticquent\Console;

class Map extends AbstractCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:map
                                {action : Mapping action to perform (update or delete)}
                                {model : Name or comma separated names of the model(s) to initialize}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize a Eloquent model.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->getActionArgument(['update', 'delete']);

        // Perform actions on models
        foreach ($this->getModelArgument() as $model) {
            $model = "\\App\\{$model}";

            if ($this->validateModel($model) === true) {
                $this->$action($model);
            }
        }

        return true;
    }

    /**
     * Update ElasticSearch model mapping.
     *
     * @param  string $model
     *
     * @return bool
     */
    protected function update($model)
    {
        $this->output->write("Updating {$model} mapping...");

        return $this->makeCall($model, 'putMapping');
    }

    /**
     * Delete ElasticSearch model mapping.
     *
     * @param  string $model
     *
     * @return bool
     */
    protected function delete($model)
    {
        $this->output->write("Deleting {$model} mapping...");

        return $this->makeCall($model, 'deleteMapping');
    }
}
