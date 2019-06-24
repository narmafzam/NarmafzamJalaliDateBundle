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
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getCalendar()
    {
        return $this->calendar;
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

        $result = $this->dateConverter->georgianToPersian($gDate, $this->serverFormat, $this->getLocale(), $this->getCalendar(), false);

        if(!$result) {
            throw new TransformationFailedException(intl_get_error_message(), intl_get_error_code());
        }

        return $result;
    }

    /**
     * @param $jDate
     * @return \DateTime|null
     *
     * @throws \Exception
     */
    public function reverseTransform($jDate)
    {
        if($jDate === null || $jDate === '') {
            return null;
        }

        if (!is_string($jDate)) {
            throw new UnexpectedTypeException($jDate, 'string');
        }
        if (self::isGeorgianDate($jDate)) {

            $result = new \DateTime($jDate);
        } else {

            $result = $this->dateConverter->persianToGeorgian($jDate, $this->serverFormat, 'en', $this->getCalendar());
        }

        if(!$result) {
            throw new TransformationFailedException(intl_get_error_message(), intl_get_error_code());
        }

        return $result;
    }

    /**
     * @param string $date
     *
     * @return bool
     */
    public static function isGeorgianDate(string $date): bool
    {
        if (!$date) {
            return false;
        }
        try {
            new \DateTime($date);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
} 
