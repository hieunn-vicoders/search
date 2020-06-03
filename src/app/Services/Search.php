<?php

namespace VCComponent\Laravel\Search\Services;

use VCComponent\Laravel\Search\ValidRule\Operator;

class Search
{
    public $query;

    public function useModel($model)
    {
        $this->query = app($model);
        return $this;
    }

    public function searchByField($field, $value, $operator)
    {
        switch ($operator) {
            case Operator::LIKE:
                $this->query = $this->query->where($field, 'LIKE', "{$value}");
                break;
            case Operator::NOT_LIKE:
                $this->query = $this->query->where($field, 'NOT LIKE', "{$value}");
                break;
            case Operator::SUBSTRING:
                $this->query = $this->query->where($field, 'LIKE', "%{$value}%");
                break;
            case Operator::START_WITH:
                $this->query = $this->query->where($field, 'LIKE', "{$value}%");
                break;
            case Operator::END_WITH:
                $this->query = $this->query->where($field, 'LIKE', "%{$value}");
                break;
            default:
                $this->query = $this->query->where($field, $operator, $value);
                break;
        }
        return $this;
    }

    public function orSearchByField($field, $value, $operator)
    {
        switch ($operator) {
            case Operator::LIKE:
                $this->query = $this->query->orWhere($field, 'LIKE', "{$value}");
                break;
            case Operator::NOT_LIKE:
                $this->query = $this->query->orWhere($field, 'NOT LIKE', "{$value}");
                break;
            case Operator::SUBSTRING:
                $this->query = $this->query->orWhere($field, 'LIKE', "%{$value}%");
                break;
            case Operator::START_WITH:
                $this->query = $this->query->orWhere($field, 'LIKE', "{$value}%");
                break;
            case Operator::END_WITH:
                $this->query = $this->query->orWhere($field, 'LIKE', "%{$value}");
                break;
            default:
                $this->query = $this->query->orWhere($field, $operator, $value);
                break;
        }
        return $this;
    }

    public function searchByBetween($field, $firstnumber, $secondnumber)
    {
        $this->query = $this->query->whereBetween($field, [$firstnumber, $secondnumber]);
        return $this;
    }

    public function orSearchByBetween($field, $firstnumber, $secondnumber)
    {
        $this->query = $this->query->orWhereBetween($field, [$firstnumber, $secondnumber]);
        return $this;
    }

    public function toSql()
    {
        return $this->query->toSql();
    }

    public function get($results = null)
    {
        return $this->query->get();
    }

    public function paginate($perPage)
    {
        return $this->query->paginate($perPage);
    }
}
