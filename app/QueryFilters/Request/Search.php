<?php

namespace App\QueryFilters\Request;

use App\QueryFilters\Filter;

class Search extends Filter
{
    protected function applyFilter($builder)
    {
        $searchTerm = request($this->filterName());
        return $builder->where('status', 'like', "%{$searchTerm}%")
            ->orWhere('full_weight', 'like', "%{$searchTerm}%");
    }
}
