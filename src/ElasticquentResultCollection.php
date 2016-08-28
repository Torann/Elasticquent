<?php namespace Elasticquent;

use Illuminate\Support\Arr;
use Elasticquent\ElasticquentPaginator as Paginator;

class ElasticquentResultCollection extends \Illuminate\Database\Eloquent\Collection
{
    /**
     * Metadata
     *
     * @var array
     */
    protected $meta = [];

    /**
     * Create a new instance containing Elasticsearch results
     *
     * @param  mixed $items
     * @param  array $meta
     */
    public function __construct($items, $meta = [])
    {
        parent::__construct($items);

        $this->meta = $meta;
    }

    /**
     * Total Hits
     *
     * @return int
     */
    public function totalHits()
    {
        return Arr::get($this->meta, 'hits.total');
    }

    /**
     * Limit of hits
     *
     * @return int
     */
    public function getLimit()
    {
        return Arr::get($this->meta, 'hits.limit');
    }

    /**
     * Max Score
     *
     * @return float
     */
    public function maxScore()
    {
        return Arr::get($this->meta, 'hits.max_score');
    }

    /**
     * Get Shards
     *
     * @return array
     */
    public function getShards()
    {
        return Arr::get($this->meta, 'shards');
    }

    /**
     * Took
     *
     * @return string
     */
    public function took()
    {
        return Arr::get($this->meta, 'took');
    }

    /**
     * Timed Out
     *
     * @return bool
     */
    public function timedOut()
    {
        return (bool) Arr::get($this->meta, 'timed_out');
    }

    /**
     * Get Hits
     *
     * Get the raw hits array from
     * Elasticsearch results.
     *
     * @return array
     */
    public function getHits()
    {
        return Arr::get($this->meta, 'hits', []);
    }

    /**
     * Get the raw hits array from Elasticsearch results.
     *
     * @return array
     */
    public function getAggregations()
    {
        return Arr::get($this->meta, 'aggregations', []);
    }

    /**
     * Paginate Collection
     *
     * @return Paginator
     */
    public function paginate()
    {
        $page = Paginator::resolveCurrentPage() ?: 1;

        return new Paginator($this->items, $this->getHits(), $this->totalHits(), $this->getLimit(), $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }
}
