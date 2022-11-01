<?php  namespace App\Filters;

class OfferFilters extends QueryFilter
{

    public function branch($branch = null) {
        return $this->builder->where('branches', 'LIKE', "%$branch%");
    }

    public function now($current_time = null) {

        $current_time = ($current_time) ? $current_time : now();

        return $this->builder->where([
            ['date_from', '<=', $current_time],
            ['date_to', '>=', $current_time]
        ]);
    }

    public function type($type = null) {

        return $this->builder->where('service_type', $type);
    }

}
