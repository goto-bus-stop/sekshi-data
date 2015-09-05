<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Super hacky, but not terribly inefficient way of getting total karma for
 * a collection of users.
 */
class TotalKarma extends GroupAggregateRelation
{
    /**
     * Default relationship value.
     *
     * @var mixed
     */
    protected $defaultValue = 0;

    /**
     * Property on the resulting MongoDB documents to use as the relationship
     * value.
     *
     * @var string
     */
    protected $groupKey = 'karma';

    /**
     * Create a new karma "relationship" instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $parent
     * @param  string  $foreignKey
     * @param  string  $otherKey
     * @return void
     */
    public function __construct(Builder $query, Model $parent, $foreignKey = 'raw_id', $localKey = 'target')
    {
        parent::__construct($query, $parent, $foreignKey, $localKey);
    }

    /**
     * Get the MongoDB $group command for this relationship.
     */
    protected function getGroup()
    {
        return [
            '_id' => '$' . $this->localKey,
            'karma' => ['$sum' => '$amount']
        ];
    }
}
