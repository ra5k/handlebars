<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Context;

// [imports]
use ArrayAccess;

/**
 *
 *
 */
trait Extract
{

    /**
     * @param string $key
     * @param mixed $data
     * @param mixed $result
     * @return bool
     */
    private function extract($key, $data, &$result): bool
    {
        $found = false;
        $result = null;
        //
        if (is_array($data)) {
            if (array_key_exists($key, $data)) {
                $result = $data[$key];
                $found = true;
            }
        } else if (is_object($data)) {
            if (is_callable([$data, $key])) {
                $found = true;
                $result = $data->$key();
            } else if ($data instanceof ArrayAccess) {
                $found = $data->offsetExists($key);
                $result = ($found) ? $data->offsetGet($key) : null;
            } else if (isset($data->$key)) {
                // Note: isset() returns also false if the property exists but is NULL. This is OK
                // since a NULL value is displayed like an empty string anyway.
                $found = true;
                $result = $data->$key;
            }
        }
        return $found;
    }
    
    
}
