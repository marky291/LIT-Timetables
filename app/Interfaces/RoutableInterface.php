<?php

namespace App\Interfaces;

interface RoutableInterface
{
    /**
     * @return mixed
     */
    public function getRouteKeyName();

    /**
     * @return string
     */
    public function getRouteAttribute();

    /**
     * @return string
     */
    public function getRouteTitleAttribute();
}
