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
                                {action : Mapping action to perform (add or remove)}
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
        $action = $this->getActionArgument(['add', 'remove']);

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
     * Add ElasticSearch model mapping.
     *
     * @param  string $model
     *
     * @return bool
     */
    protected function add($model)
    {
        $this->output->write("Adding {$model} mapping...");

        return $this->makeCall($model, 'putMapping');
    }

    /**
     * Remove ElasticSearch model mapping.
     *
     * @param  string $model
     *
     * @return bool
     */
    protected function remove($model)
    {
        $this->output->write("Removing {$model} mapping...");

        return $this->makeCall($model, 'deleteMapping');
    }
}
