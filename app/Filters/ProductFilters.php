<?php  namespace App\Filters;

class ProductFilters extends QueryFilter
{
    public function search($value=null) {
        if ($value)
            return $this->builder->where('name', "LIKE", "%$value%");
    }

    public function sort($value=null) {
        if ($value)
            return $this->builder->orderBy('name',$value);
    }

    public function from($value = null){
    	if ($value)
    		return $this->builder->whereDate('created_at', '>=', $value);
    }

	public function to($value = null){
    	if ($value)
    		return $this->builder->whereDate('created_at', '<=', $value);
    }


} 
