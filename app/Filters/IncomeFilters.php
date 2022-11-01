<?php  namespace App\Filters;

class IncomeFilters extends QueryFilter
{

    public function branch($branch = null) {
        if ($branch != null and $branch !='all')
	        return $this->builder->where('branch_id', $branch);
    }

    public function from($value = null){
    	if ($value)
    		return $this->builder->whereDate('created_at', '>=', $value);
    }

	public function to($value = null){
    	if ($value)
    		return $this->builder->whereDate('created_at', '<=', $value);
    }
    
    public function order_from($value = null){
    	if ($value)
    		return $this->builder->where('order_from', $value);
    }

}
