<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Super hacky, but not terribly inefficient way of getting the amount of
 * unlocked achievements per achievement type.
 */
class AchievementUnlockCount extends GroupAggregateRelation
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
    protected $groupKey = 'count';

    /**
     * Create a new unlocked achievements "relationship" instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $parent
     * @param  string  $foreignKey
     * @param  string  $otherKey
     * @return void
     */
    public function __construct(Builder $query, Model $parent, $foreignKey = 'raw_id', $localKey = 'achievement')
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
            'count' => ['$sum' => 1]
        ];
    }
}
