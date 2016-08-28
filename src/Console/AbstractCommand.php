<?php

namespace Elasticquent\Console;

use Illuminate\Console\Command;

abstract class AbstractCommand extends Command
{
    /**
     * Get action argument.
     *
     * @param  array $validActions
     * @return array
     */
    protected function getActionArgument($validActions = [])
    {
        $action = strtolower($this->argument('action'));

        if (in_array($action, $validActions) === false) {
            throw new \RuntimeException("The \"{$action}\" option does not exist.");
        }

        return $action;
    }

    /**
     * Get model argument.
     *
     * @return array
     */
    protected function getModelArgument()
    {
        return explode(',', preg_replace('/\s+/', '', $this->argument('model')));
    }

    /**
     * Validate model.
     *
     * @param  string $model
     * @return bool
     */
    protected function validateModel($model)
    {
        // Verify model existence
        if (class_exists($model) === false) {
            $this->error("Model '{$model}' not found");

            return false;
        }

        // Verify model is Elasticsearch ready
        if (method_exists($model, 'addToIndex') === false) {
            $this->error("Model '{$model}' is not a valid ElasticSearch model.");

            return false;
        }

        return true;
    }

    /**
     * Make request to ElasticSearch.
     *
     * @param  string $model
     * @param  string $method
     * @return bool
     */
    protected function makeCall($model, $method)
    {
        $results = $model::$method();

        // Check for errors
        if (array_get($results, 'errors') === true) {
            $this->output->writeln("<error>failed</error>");
            dd($results);

            return false;
        }

        // Check for acknowledgment errors
        if (array_get($results, 'acknowledged') === false) {
            $this->output->writeln("<error>failed</error>");
            dd($results);

            return false;
        }

        $this->output->writeln("<info>success</info>");

        return true;
    }
}
