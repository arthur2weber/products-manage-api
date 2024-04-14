<?php

namespace App\Enums;

enum CacheKeysEnum: string
{
    case PRODUCTS_ALL = 'product_all';
    /**
     * Product by Id: [{id_product}]
     */
    case PRODUCTS_FIND_ID = 'product_find_%s_id';

    public function valueWith(?array $params = null): ?string
    {
        if (strpos('%', $this->value) && ! $params) {
            return null;
        }

        return $params ? sprintf($this->value, ...$params) : $this->value;
    }
}
