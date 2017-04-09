<?php


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Illuminate\View\ViewFinderInterface;
use Mockery as m;
use Whyounes\FaqException\Models\Faq;
use Whyounes\FaqException\Repositories\FaqRepository;
use Whyounes\FaqException\WebRenderer;

class WebRendererTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->addViewsLocation();
    }

    /**
     * @test
     */
    public function test_can_render_exception()
    {
        $exception = new ModelNotFoundException;
        $faqModel = new Faq([
            'exception' => get_class($exception),
            'codes' => '404',
            'url' => 'app.url/faq/model-not-found'
        ]);
        $stubRepository = m::mock(FaqRepository::class);
        $stubRepository->shouldReceive('getFaqFromException')
            ->once()
            ->andReturn($faqModel);

        /** @var View $response */
        $webRenderer = new WebRenderer($stubRepository);
        $response = $webRenderer->render($exception);

        $this->assertInstanceOf(Illuminate\Contracts\View\View::class, $response);

        $viewData = $response->getData();
        $this->assertEquals([
            'exception' => $exception,
            'faq' => $faqModel
        ], $viewData);
    }

    private function addViewsLocation()
    {
        $this->app['view']->addNamespace('faq', __DIR__ . '/../resources/views');
    }
}