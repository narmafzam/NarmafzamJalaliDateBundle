<?php
/**
 * This file is part of cardioclinic
 * Copyrighted by Narmafzam (Farzam Webnegar Sivan Co.), info@narmafzam.com
 * Created by peyman
 * Date: 08/29/2018
 */

namespace Narmafzam\JalaliDateBundle\Form\Type;

use Narmafzam\JalaliDateBundle\Form\DataTransformer\NarmafzamDateTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NarmafzamJalaliGregorianDateType
 * @package Narmafzam\JalaliDateBundle\Form\Type
 */
class NarmafzamJalaliGregorianDateType extends AbstractType
{
    /**
     * @var string
     */
    protected $locale;

    /**
     * NarmafzamJalaliDateType constructor.
     *
     * @param DateConverter $dateConverter
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->locale = $requestStack->getCurrentRequest()->getLocale() == 'fa' ? 'fa' : 'en';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new NarmafzamDateTransformer($this->dateConverter, $options['serverFormat'], $options['locale']);
        $builder->addModelTransformer($transformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'serverFormat' => 'yyyy/MM/dd',
            'locale' => $this->locale,
            'parent_attr' => array(
                'class'   => 'col-sm-6'
            )
        ));

        $resolver->setAllowedTypes('serverFormat', ['string', 'null']);
        $resolver->setAllowedTypes('locale', ['string', 'null']);
        $resolver->setAllowedValues('locale', ['fa', 'en', null]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return TextType::class;
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'narmafzam_jalali_gregorian_date';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}