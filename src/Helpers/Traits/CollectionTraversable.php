<?php

namespace MreeP\QuickTemplate\Helpers\Traits;

use ArrayIterator;
use Traversable;

/**
 * trait CollectionTraversable
 *
 * A simple collection traversable trait
 *
 * @property array $items
 */
trait CollectionTraversable
{

    /**
     * Retrieve an external iterator
     *
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}