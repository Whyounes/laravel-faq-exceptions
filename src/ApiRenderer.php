<?php

namespace Whyounes\FaqException;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Response;
use Whyounes\FaqException\Repositories\FaqRepository;

class ApiRenderer extends AbstractRenderer
{
    /**
     * ApiRenderer constructor.
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
        $data = [
            "error" => true,
            "code" => (string)$exception->getCode(),
            "message" => $exception->getMessage(),
        ];

        try {
            $faq = $this->repository->getFaqFromException($exception);
            $data["faq"] = $faq->url;
        } catch (ModelNotFoundException $exception) {
        } finally {
            /** @var $response \Illuminate\Http\Response */
            $response = Response::make($data);
            $response->header('Content-Type', 'application/json');

            return $response;
        }
    }
}