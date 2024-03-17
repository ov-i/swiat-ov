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
        if (!$needle instanceof Collection || !$haystack instanceof Collection) {
            [$needle, $haystack] = $this->convertArrayToCollection($needle, $haystack);
        }

        if ($needle->isEmpty() && !$haystack->isEmpty()) {
            return false;
        }

        $needle = $this->convertItemsToJson($needle);
        $haystack = $this->convertItemsToJson($haystack);

        $diff = $haystack->intersectAssoc($needle);

        return $needle->only($haystack->keys())->count() === $diff->count();
    }

    public function differences(array|Collection $needle, array|Collection $haystack): array
    {
        if (!$needle instanceof Collection || !$haystack instanceof Collection) {
            [$needle, $haystack] = $this->convertArrayToCollection($needle, $haystack);
        }

        if ($needle->isEmpty() && !$haystack->isEmpty()) {
            return [];
        }

        $needle = $this->convertItemsToJson($needle);
        $haystack = $this->convertItemsToJson($haystack);

        $diff = $haystack->diffAssoc($needle);

        return $diff->toArray();
    }

    /**
     * Returns json encoded text if an item of the array | collection is array or object
     *
     * @param non-empty-list<array-key, mixed>|Collection<array-key, mixed>
     *
     * @return Collection<array-key, mixed>
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

    /**
     * @param non-empty-array<array-key, scalar> ...$arrays
     *
     * @return non-empty-array<array-key, Collection>
     */
    private function convertArrayToCollection(...$arrays): array
    {
        return array_map(fn ($array) => collect($array), $arrays);
    }
}
