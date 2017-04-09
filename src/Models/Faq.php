<?php

namespace Whyounes\FaqException\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Whyounes\FaqException\Repositories\FaqRepository;

/**
 * Class model Faq
 *
 * @package Whyounes\FaqException\Models
 *
 * @property  string|array $codes
 * @property  string $exception
 * @property  string $url
 */
class Faq extends Model
{
    public $timestamps = false;
    protected $table = "whyounes_faq";
    protected $fillable = ["exception", "codes", "url"];

    /**
     * @param \Exception $exception
     * @param $faqUrl
     * @return Faq
     */
    public static function createFromException(\Exception $exception, $faqUrl)
    {
        /** @var FaqRepository $faqRepository */
        $faqRepository = App::make(FaqRepository::class);
        $faq = $faqRepository->findWhereException($exception);

        if (is_null($faq)) {
            $faq = $faqRepository->create([
                'exception' => get_class($exception),
                'codes' => (string)$exception->getCode(),
                'url' => $faqUrl
            ]);
        }

        if (!in_array($exception->getCode(), $faq->codes)) {
            $faq->addCode($exception->getCode());
        }

        $faqRepository->save($faq);

        return $faq;
    }

    /**
     * Append a new code to the codes attribute
     *
     * @param $code
     */
    public function addCode($code)
    {
        $codes = $this->getCodesAttribute();
        $codes[] = (string)$code;

        $this->setCodesAttribute($codes);
    }

    /**
     * @return array
     */
    public function getCodesAttribute()
    {
        if (is_string($this->attributes['codes'])) {
            return explode(',', $this->attributes['codes']);
        }

        return $this->attributes['codes'];
    }

    /**
     * @param string|array $codes
     */
    public function setCodesAttribute($codes)
    {
        if (!is_string($codes) && !is_array($codes)) {
            throw new \InvalidArgumentException;
        }

        if (is_array($codes)) {
            $codes = implode(',', $codes);
        }

        $this->attributes['codes'] = $codes;
    }
}
