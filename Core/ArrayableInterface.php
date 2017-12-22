<?php

namespace Core;

/**
 * Interface ArrayableInterface
 *
 * @package core
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
interface ArrayableInterface
{
    /**
     *
     * @return array
     */
    public function toArray(): array;
}
