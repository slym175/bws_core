<?php

namespace Bws\Core\Http\Repositories\Criteria;

interface Criteria
{
    /**
     * @param mixed ...$criteria
     *
     * @return $this
     */
    public function withCriteria(...$criteria): self;
}
