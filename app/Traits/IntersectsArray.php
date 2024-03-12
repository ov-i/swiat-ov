<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Collection;

trait IntersectsArray
{
    /**
     * Checks whether needle and haystack intersects with each other.
     *
     * @param array<array-key, mixed>|Collection<array-key, mixed> $needle
     * @param array<array-key, mixed>|Collection<array-key, mixed> $haystack
     *
     * @return bool Returns true if the count of intersections are the same.
     */
    public function intersectSame(array|Collection $needle, array|Collection $haystack): bool
    {
        if (false === $needle instanceof Collection || false === $haystack instanceof Collection) {
            $needle = collect($needle);
            $haystack = collect($haystack);
        }

        if ($needle->isEmpty() && !$haystack->isEmpty()) {
            return false;
        }

        $needle = $this->convertItemsToJson($needle);
        $haystack = $this->convertItemsToJson($haystack);

        $diff = $haystack->intersectAssoc($needle);

        return $needle->only($haystack->keys())->count() === $diff->count();
    }

    /**
     * Returns json encoded text if an item of the array | collection is array or object
     */
    public function convertItemsToJson(array|Collection $collection): Collection
    {
        if(is_array($collection)) {
            $collection = collect($collection);
        }

        return $collection->map(function (mixed $item) {
            return is_array($item) || is_object($item) ? json_encode($item) : $item;
        });
    }
}
