<?php

namespace MreeP\QuickTemplate\Helpers\Traits;

/**
 * trait CollectionArrayAccess
 *
 * A simple collection array access trait
 *
 * @property array $items
 */
trait CollectionArrayAccess
{

    /**
     * Whether an offset exists
     *
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param  mixed $offset <p>
     *                       An offset to check for.
     *                       </p>
     * @return bool true on success or false on failure.
     *                       </p>
     *                       <p>
     *                       The return value will be cast to boolean if non-boolean was returned.
     */
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Offset to retrieve
     *
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param  mixed $offset <p>
     *                       The offset to retrieve.
     *                       </p>
     * @return TValue Can return all value types.
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * Offset to set
     *
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param  TKey   $offset <p>
     *                        The offset to assign the value to.
     *                        </p>
     * @param  TValue $value  <p>
     *                        The value to set.
     *                        </p>
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Offset to unset
     *
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param  TKey $offset <p>
     *                      The offset to unset.
     *                      </p>
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }
}