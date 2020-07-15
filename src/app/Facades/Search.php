<?php

namespace VCComponent\Laravel\Search\Facades;

use Illuminate\Support\Facades\Facade;

class Search extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'search';
    }
}
