<?php
/**
 * Copyright (c) 2016 Open Assessment Technologies, S.A.
 *
 * @author Alexander Zagovorichev, <zagovorichev@1pt.com>
 */

namespace oat\taoRestAPI\model\http\Response;


use oat\taoRestAPI\model\http\Response;

/**
 * Class Filter
 * Filtering by fields
 * 
 * Response
 * GET ?field1=value1&amp;field2=value1,value3
 * 
 * @package oat\taoRestAPI\model\http\Response
 */
class Filter
{

    /**
     * @var array
     */
    private $options = [
        'query' => [],
        'fields' => [],
    ];

    private $filters = [];

    public function __construct(Response &$response, $options = [])
    {
        $this->options = array_merge($this->options, $options);

        $this->setFilters();
    }
    
    public function getFilters()
    {
        return $this->filters;
    }
    
    private function setFilters()
    {
        if (is_array($this->options['query'])) {
            foreach ($this->options['query'] as $field => $filter) {
                if (in_array($field, $this->options['fields'])) {
                    $this->filters[$field] = explode(',', $filter);
                }
            }
        }
    }
}
