<?php

namespace Whyounes\FaqException\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Whyounes\FaqException\Models\Faq;

class FaqRepository
{
    /**
     * Get FAQ instance from exception.
     *
     * @param \Exception $exception
     * @return null|Faq
     * @throws \Exception
     */
    public function getFaqFromException(\Exception $exception)
    {
        /** @var Faq $faq */
        $faq = Faq::where('exception', get_class($exception))->first();

        if (!$faq) {
            throw new ModelNotFoundException;
        }

        return $faq;
    }

    /**
     * Find using an exception
     *
     * @param \Exception $exception
     * @return Faq|null
     */
    public function findWhereException(\Exception $exception)
    {
        $faq = Faq::where('exception', get_class($exception))->first();

        return $faq;
    }

    /**
     * Create a new Faq instance from an array of attributes.
     *
     * @param array $attributes
     * @return Faq
     */
    public function create(array $attributes)
    {
        return new Faq($attributes);
    }

    /**
     * Persist to DB
     *
     * @param Faq $faq
     * @return bool
     */
    public function save(Faq $faq)
    {
        return $faq->save();
    }
}
