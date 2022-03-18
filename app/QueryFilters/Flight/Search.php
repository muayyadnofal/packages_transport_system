<?php

namespace App\QueryFilters\Flight;

use App\QueryFilters\Filter;

class Search extends Filter
{
    protected function applyFilter($builder)
    {
        $searchTerm = request($this->filterName());
        return $builder->where('landing_city', 'like', "%{$searchTerm}%")
            ->orWhere('launch_city', 'like', "%{$searchTerm}%");
    }
}
