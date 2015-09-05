<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

abstract class GroupAggregateRelation extends Relation
{
    /**
     * List of models that this relation is called on.
     *
     * @var array
     */
    protected $models;

    /**
     * Default relationship value.
     *
     * @var mixed
     */
    protected $defaultValue = null;

    /**
     * Property on the resulting MongoDB documents to use as the relationship
     * value.
     *
     * @var string
     */
    protected $groupKey = null;

    /**
     * Create a new group aggregate "relationship" instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $parent
     * @param  string  $foreignKey
     * @param  string  $otherKey
     * @return void
     */
    public function __construct(Builder $query, Model $parent, $foreignKey, $localKey)
    {
        $this->foreignKey = $foreignKey;
        $this->localKey = $localKey;
        parent::__construct($query, $parent);
    }

    /**
     * Unused. (For now.)
     */
    public function addConstraints()
    {
        // unused
    }

    /**
     * Unused. (For now.)
     */
    public function addEagerConstraints(array $models)
    {
        // unused
    }

    /**
     * Unused. (For now.)
     */
    public function getResults()
    {
        // unused
    }

    /**
     * Set default value for the relation on the models.
     *
     * @param  array  $models
     * @param  string  $relation
     * @return array
     */
    public function initRelation(array $models, $relation)
    {
        $this->models = $models;
        foreach ($models as $model) {
            $model->setRelation($relation, $this->defaultValue);
        }
        return $models;
    }

    /**
     * Match groups to their parent models.
     *
     * @param  array  $models
     * @param  \Illuminate\Database\Eloquent\Collection  $results
     * @param  string  $relation
     * @return array
     */
    public function match(array $models, Collection $results, $relation)
    {
        $dict = [];
        foreach ($results as $result) {
            $dict[(string) $result['_id']] = $result[$this->groupKey];
        }
        foreach ($models as $model) {
            $key = (string) $model->getAttribute($this->foreignKey);
            if (array_has($dict, $key)) {
                $model->setRelation($relation, $dict[$key]);
            }
        }
        return $models;
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get()
    {
        $keys = $this->getKeys($this->models, $this->foreignKey);
        $results = $this->related->pipeline(
            ['$match' => [$this->localKey => ['$in' => $keys]]],
            ['$group' => $this->getGroup()]
        );
        // rather hacky, just to make sure that match() gets the right type
        return new Collection($results);
    }

    /**
     * Get the MongoDB $group command for this relationship.
     */
    abstract protected function getGroup();
}

