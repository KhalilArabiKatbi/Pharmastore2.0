<?php

namespace App\Filters;

use Illuminate\Http\Request;

class MedicineFilter
{
    // Allowed query parameters and corresponding operators
    protected $safeParams = [
        'tradename' => ['eq'],
        'sciname' => ['eq'],
        'price' => ['eq', 'lt', 'gt'],
        'qtn' => ['eq', 'lt', 'gt', 'lte', 'gte'],
    ];

    // Mapping of operators
    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];

    /**
     * Transform the request parameters into Eloquent queries.
     *
     * @param Request $request
     * @return array
     */
    public function transform(Request $request): array
    {
        $eloquentQueries = [];

        foreach ($this->safeParams as $param => $operators) {
            $query = $request->query($param);

            if (!isset($query)) {
                continue;
            }

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloquentQueries[] = [$param, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloquentQueries;
    }
}
