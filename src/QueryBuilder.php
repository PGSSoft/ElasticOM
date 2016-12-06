<?php

namespace Pgs\ElasticOM;

use Pgs\ElasticOM\Hydrator\Hydrator;

class QueryBuilder
{
    /** @var Adapter */
    private $adapter;

    /** @var string */
    private $entityName;

    /** @var array */
    private $body = [];

    /** @var Hydrator */
    private $hydrator;

    public function __construct(Adapter $adapter, string $entityName, Hydrator $hydrator)
    {
        $this->adapter = $adapter;
        $this->entityName = $entityName;
        $this->hydrator = $hydrator;
    }

    public function setMatch(string $field, string $value): self
    {
        $this->body['query']['match'][$field] = $value;

        return $this;
    }

    public function setTerm(string $field, string $value): self
    {
        $this->body['query']['term'][$field] = $value;

        return $this;
    }

    public function setRange(string $field, int $minValue, int $maxValue): self
    {
        $this->body['query']['range'][$field] = ['qte' => $minValue, 'lte' => $maxValue];

        return $this;
    }

    public function setMust(string $field, string $value): self
    {
        $this->body['query']['bool']['must'] = $this->setTerms($field, $value);

        return $this;
    }

    public function setFilter(string $field, string $value): self
    {
        $this->body['query']['bool']['filter'] = $this->setTerms($field, $value);

        return $this;
    }

    public function setMustNot(string $field, string $value): self
    {
        $this->body['query']['must_not']['filter'] = $this->setTerms($field, $value);

        return $this;
    }

    public function setShould(string $field, string $value): self
    {
        $this->body['query']['bool']['should'] = $this->setTerms($field, $value);

        return $this;
    }

    public function addOrderBy(string $sort, string $order = null): self
    {
        $this->body['sort'][] = [$sort => $order ?? 'asc'];

        return $this;
    }

    public function addGreaterThan(string $field, int $value): self
    {
        $this->body['query']['bool']['must'][] = ['range' => [$field => ['gt' => $value]]];

        return $this;
    }

    public function addLessThan(string $field, int $value): self
    {
        $this->body['query']['bool']['must'][] = ['range' => [$field => ['lt' => $value]]];

        return $this;
    }

    public function setFirstResult(int $firstResult): self
    {
        $this->body['from'] = $firstResult;

        return $this;
    }

    public function setMaxResults(int $maxResults): self
    {
        $this->body['size'] = $maxResults;

        return $this;
    }

    public function getQuery(): Query
    {
        if (empty($this->body['query'])) {
            $this->body['query']['match_all'] = new \stdClass();
        }

        return new Query($this->adapter, $this->entityName, $this->body, $this->hydrator);
    }

    private function setTerms(string $field, string $value)
    {
        $value = array_map('strtolower', preg_split('/\s+/', $value));
        if (count($value) === 1) {
            $value = reset($value);
        }

        return is_array($value)
            ? ['terms' => [$field => $value]]
            : ['term' => [$field => $value]];
    }
}
