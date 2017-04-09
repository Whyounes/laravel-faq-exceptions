<?php

namespace Whyounes\FaqException;

use Whyounes\FaqException\Repositories\FaqRepository;

abstract class AbstractRenderer
{

    /**
     * @var FaqRepository
     */
    protected $repository;

    function __construct(FaqRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Render the exception
     *
     * @param \Exception $exception
     * @return mixed
     */
    abstract public function render(\Exception $exception);
}