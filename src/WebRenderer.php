<?php

namespace Whyounes\FaqException;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\View;
use Whyounes\FaqException\Repositories\FaqRepository;

class WebRenderer extends AbstractRenderer
{
    /**
     * WebRenderer constructor.
     * @param FaqRepository $repository
     */
    function __construct(FaqRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Render the exception
     *
     * @param \Exception $exception
     * @return mixed
     */
    public function render(\Exception $exception)
    {
        try {
            $faq = $this->repository->getFaqFromException($exception);
        } catch (ModelNotFoundException $exception) {
            $faq = null;
        } finally {
            return View::make("faq::faq", compact('exception', 'faq'));
        }
    }
}