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
     * @return array
     */
    public function getTree($type);
}