<?php

namespace MreeP\QuickTemplate\Helpers;

use ArrayAccess;
use IteratorAggregate;
use MreeP\QuickTemplate\Helpers\Traits\CollectionArrayAccess;
use MreeP\QuickTemplate\Helpers\Traits\CollectionTraversable;

/**
 * class Collection
 *
 * A simple collection class
 */
class Collection implements ArrayAccess, IteratorAggregate
{

    use CollectionArrayAccess;
    use CollectionTraversable;

    /**
     * Create a new instance of the class.
     *
     * @param  array $items
     */
    public function __construct(
        protected array $items = [],
    ) {}

    /**
     * Static method to create a new instance of the class.
     *
     * @param  array $items
     * @return static
     */
    public static function make(array $items = []): static
    {
        return new static($items);
    }

    /**
     * Return all items.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Return the first item.
     *
     * @param  null|callable $callback
     * @param  null|mixed    $default
     * @return mixed
     */
    public function first(callable $callback = null, mixed $default = null): mixed
    {
        if (is_null($callback)) {
            if (empty($this->items)) {
                return $default;
            }

            foreach ($this->items as $item) {
                return $item;
            }
        }

        foreach ($this->items as $key => $item) {
            if ($callback($item, $key)) {
                return $item;
            }
        }

        return $default;
    }

    /**
     * Execute a callback over each item.
     *
     * @param  callable $callback
     * @return $this
     */
    public function each(callable $callback): static
    {
        foreach ($this->items as $key => $item) {
            $callback($item, $key);
        }

        return $this;
    }
}