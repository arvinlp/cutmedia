<?php
/*
 * @Author: arvinlp 
 * @Date: 2020-01-14 21:05:01 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2020-01-15 17:24:58
 */
namespace App\SearchFilters\Filters;

use Illuminate\Database\Eloquent\Builder;

class OrderByDesc implements Filter{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value){
        if($value != null){
            $values = explode(',',$value);
            $newBuilder = $builder;
            foreach($values as $val){
                $newBuilder = $newBuilder->orderBy($val,'desc');
            }
            return $newBuilder;
        }
        return $builder;
    }
}