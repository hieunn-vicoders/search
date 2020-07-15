<?php

namespace VCComponent\Laravel\Search\Services;

use VCComponent\Laravel\Search\ValidRule\Operator;

class Search
{
    public $query;

    public function useModel($model)
    {
        $this->model = $model;
        $this->query = app($model);
        return $this;
    }

    public function searchByField($field, $value, $operator, $withMeta = false)
    {
        $this->query = $this->query->where(function ($query) use ($field, $value, $operator, $withMeta) {
            switch ($operator) {
                case Operator::LIKE:
                    $query = $query->where($field, 'LIKE', "{$value}");
                    break;
                case Operator::NOT_LIKE:
                    $query = $query->where($field, 'NOT LIKE', "{$value}");
                    break;
                case Operator::SUBSTRING:
                    $query = $query->where($field, 'LIKE', "%{$value}%");
                    break;
                case Operator::START_WITH:
                    $query = $query->where($field, 'LIKE', "{$value}%");
                    break;
                case Operator::END_WITH:
                    $query = $query->where($field, 'LIKE', "%{$value}");
                    break;
                default:
                    $query = $query->where($field, $operator, $value);
                    break;
            }
            $query = $this->searchWithMeta($query, $value, $withMeta);
        });
        return $this;
    }

    public function orSearchByField($field, $value, $operator, $withMeta = false)
    {
        $this->query = $this->query->orWhere(function ($query) use ($field, $value, $operator, $withMeta) {
            switch ($operator) {
                case Operator::LIKE:
                    $query = $query->orWhere($field, 'LIKE', "{$value}");
                    break;
                case Operator::NOT_LIKE:
                    $query = $query->orWhere($field, 'NOT LIKE', "{$value}");
                    break;
                case Operator::SUBSTRING:
                    $query = $query->orWhere($field, 'LIKE', "%{$value}%");
                    break;
                case Operator::START_WITH:
                    $query = $query->orWhere($field, 'LIKE', "{$value}%");
                    break;
                case Operator::END_WITH:
                    $query = $query->orWhere($field, 'LIKE', "%{$value}");
                    break;
                default:
                    $query = $query->orWhere($field, $operator, $value);
                    break;
            }
            $query = $this->searchWithMeta($query, $value, $withMeta);
        });

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

    public function limit($value)
    {
        return $this->query->limit($value);
    }

    public function orderBy($column, $direction = 'asc')
    {
        return $this->query->orderBy($column, $direction);
    }

    public function OfType($type)
    {
        return $this->query->where('type', $type);
    }

    private function getRelationshipMeta()
    {
        $text      = substr($this->model, strpos($this->model, 'Entities'));
        $relations = strtolower(ltrim(str_replace('Entities', '', $text), "[\]")) . "Metas";
        return $relations;
    }

    private function searchWithMeta($query, $value, $meta)
    {
        if ($meta == true) {
            $relations_meta = $this->getRelationshipMeta();
            $query          = $query->orWhereHas($relations_meta, function ($q) use ($value) {
                $q->Where('value', 'like', "%{$value}%");
            });
        }
        return $query;
    }
}
