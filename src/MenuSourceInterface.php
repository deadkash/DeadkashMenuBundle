<?php

namespace Deadkash\MenuBundle;


interface MenuSourceInterface
{

    /**
     * @return array
     */
    public function getItems();

    /**
     * @param mixed $type
     * @param null $parent
     * @return array
     */
    public function getTree($type, $parent = null);
}