<?php
/**
 * This file is part of JalaliDateBundle
 * Copyrighted by Narmafzam (Farzam Webnegar Sivan Co.), info@narmafzam.com
 * Created by peyman
 * Date: 8/21/18
 */

namespace Narmafzam\JalaliDateBundle\Twig;

use Narmafzam\JalaliDateBundle\Model\Converter\DateConverter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class NarmafzamDateExtension
 * @package Narmafzam\JalaliDateBundle\Twig
 */
class NarmafzamDateExtension extends AbstractExtension
{
    /**
     * @var DateConverter
     */
    private $dateConverter;

    /**
     * NarmafzamDateExtension constructor.
     *
     * @param DateConverter $dateConverter
     */
    public function __construct(DateConverter $dateConverter)
    {
        $this->dateConverter = $dateConverter;
    }

    /**
     * @return array|\TwigFilter[]
     */
    public function getFilters()
    {
        return array(
            new TwigFilter('gpDate', array($this, 'georgianToPersian')),
            new TwigFilter('pgDate', array($this, 'persianToGeorgian')),
            new TwigFilter('glDate', array($this, 'georgianToLocale')),
        );
    }

    /**
     * @param \DateTime $gDate
     * @param string $format
     * @param string $locale (e.g. fa, fa_IR, en, en_US, en_UK, ...)
     * @param string $calendar (e.g. gregorian, persian, islamic, ...)
     * @param bool $latinizeDigit
     * @return string
     */
    public function georgianToPersian($gDate = null, $format = 'yyyy/MM/dd', $locale = 'fa', $calendar = 'persian', $latinizeDigit = false)
    {
        return $this->dateConverter->georgianToPersian($gDate, $format, $locale, $calendar, $latinizeDigit);
    }

    /**
     * @param string $pDate
     * @param string $format
     * @param string $locale (e.g. fa, fa_IR, en, en_US, en_UK, ...)
     * @param string $calendar (e.g. gregorian, persian, islamic, ...)
     * @return \DateTime
     */
    public function persianToGeorgian($pDate, $format = 'yyyy/MM/dd', $locale = 'fa', $calendar = 'persian')
    {
        return $this->dateConverter->persianToGeorgian($pDate, $format, $locale, $calendar);
    }

    /**
     * @param \DateTime $gDate
     * @param string $format
     * @param string $locale (e.g. fa, fa_IR, en, en_US, en_UK, ...)
     * @param string $calendar (e.g. gregorian, persian, islamic, ...)
     * @param bool $latinizeDigit
     * @return string
     */
    public function georgianToLocale($gDate = null, $format = 'yyyy/MM/dd', $locale = null, $calendar = null, $latinizeDigit = false)
    {
        return $this->dateConverter->georgianToLocale($gDate, $format, $locale, $calendar, $latinizeDigit);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'narmafzam.date_extension';
    }
}
