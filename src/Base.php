<?php

namespace pithyone\zhihu\crawler;


abstract class Base
{
    /**
     * @var Query
     */
    protected $query;

    /**
     * @var Http
     */
    protected $http;

    /**
     * Base constructor.
     *
     * @param Query $query
     * @param Http  $http
     */
    public function __construct(Query $query, Http $http)
    {
        $this->query = $query;
        $this->http = $http;
    }

    /**
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return Http
     */
    public function getHttp()
    {
        return $this->http;
    }
}