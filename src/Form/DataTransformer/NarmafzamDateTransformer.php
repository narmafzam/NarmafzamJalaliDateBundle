<?php
/**
 * This file is part of JalaliDateBundle
 * Copyrighted by Narmafzam (Farzam Webnegar Sivan Co.), info@narmafzam.com
 * Created by peyman
 * Date: 8/21/18
 */

namespace Narmafzam\JalaliDateBundle\Form\DataTransformer;

use Narmafzam\JalaliDateBundle\Model\Converter\DateConverter;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class NarmafzamDateTransformer implements DataTransformerInterface
{
    /**
     * @var DateConverter
     */
    protected $dateConverter;

    /**
     * @var string
     */
    protected $serverFormat;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $calendar;

    /**
     * @param DateConverter $dateConverter
     * @param string $serverFormat
     * @param string $locale
     */
    public function __construct(DateConverter $dateConverter, $serverFormat, $locale)
    {
        $this->dateConverter = $dateConverter;
        $this->serverFormat = $serverFormat;
        $this->locale = $locale;
        $this->calendar = $locale == 'fa' ? 'persian' : 'gregorian';
    }

    /**
     * @param \DateTime $gDate
     * @return string
     */
    public function transform($gDate)
    {
        if($gDate === null) {
            return null;
        }

        if (!$gDate instanceof \DateTime) {
            throw new UnexpectedTypeException($gDate, 'DateTime');
        }

        $result = $this->dateConverter->georgianToPersian($gDate, $this->serverFormat, $this->locale, $this->calendar, false);

        if(!$result) {
            throw new TransformationFailedException(intl_get_error_message(), intl_get_error_code());
        }

        return $result;
    }

    /**
     * @param string $jDate
     * @return \DateTime
     */
    public function reverseTransform($jDate)
    {
        if($jDate === null || $jDate === '') {
            return null;
        }

        if (!is_string($jDate)) {
            throw new UnexpectedTypeException($jDate, 'string');
        }

        $result = $this->dateConverter->persianToGeorgian($jDate, $this->serverFormat, $this->locale, $this->calendar);

        if(!$result) {
            throw new TransformationFailedException(intl_get_error_message(), intl_get_error_code());
        }

        return $result;
    }
} 