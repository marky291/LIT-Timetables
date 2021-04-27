<?php

namespace App\Interfaces;

interface SearchableInterface
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

    /**
     * @return string
     */
    public function getIconCategoryAttribute();
}
