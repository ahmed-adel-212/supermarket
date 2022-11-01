<?php  namespace App\Filters;

class CategoryFilter extends QueryFilter
{
    public function search($value=null) {
        if ($value)
            return $this->builder->where('name', "LIKE", "%$value%");
    }

    public function sort($value=null) {
        if ($value)
            return $this->builder->all()->orderBy('name','ASC');
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
