<?php

namespace Bws\Core\Criteria;

interface Criteria
{
    /**
     * @param mixed ...$criteria
     *
     * @return $this
     */
    public function withCriteria(...$criteria): self;
}
