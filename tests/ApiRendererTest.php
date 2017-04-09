<?php


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Whyounes\FaqException\ApiRenderer;
use Whyounes\FaqException\Models\Faq;
use Whyounes\FaqException\Repositories\FaqRepository;
use Mockery as m;

class ApiRendererTest extends TestCase
{
    /**
     * @test
     */
    public function test_can_render_exception()
    {
        $exception = new ModelNotFoundException("Test", 404);
        $expectedResponse = [
            "error" => true,
            "code" => (string)$exception->getCode(),
            "message" => $exception->getMessage(),
            "faq" => 'app.url/faq/model-not-found'
        ];

        $stubRepository = m::mock(FaqRepository::class);
        $stubRepository->shouldReceive('getFaqFromException')
            ->once()
            ->andReturn(new Faq([
                'exception' => get_class($exception),
                'codes' => (string)$exception->getCode(),
                'url' => 'app.url/faq/model-not-found'
            ]));

        $webRenderer = new ApiRenderer($stubRepository);
        /** @var Response $response */
        $response = $webRenderer->render($exception);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedResponse, $response->original);
    }
}