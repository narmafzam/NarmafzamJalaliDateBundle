<?php
/**
 * This file is part of JalaliDateBundle
 * Copyrighted by Narmafzam (Farzam Webnegar Sivan Co.), info@narmafzam.com
 * Created by peyman
 * Date: 8/21/18
 */

namespace Narmafzam\JalaliDateBundle\Form\Type;

use Narmafzam\JalaliDateBundle\Form\DataTransformer\NarmafzamDateTransformer;
use Narmafzam\JalaliDateBundle\Model\Converter\DateConverter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NarmafzamJalaliDateType
 * @package Narmafzam\JalaliDateBundle\Form\Type
 */
class NarmafzamJalaliDateType extends AbstractType
{
    /**
     * @var DateConverter
     */
    private $dateConverter;

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
    public function __construct(DateConverter $dateConverter, RequestStack $requestStack)
    {
        $this->dateConverter = $dateConverter;
        $this->locale = $requestStack->getCurrentRequest()->getLocale() == 'fa' ? 'fa' : 'en';
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new NarmafzamDateTransformer($this->dateConverter, $options['serverFormat'], $this->getLocale());
        $builder->addModelTransformer($transformer);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['pickerOptions'] = $options['pickerOptions'];
        $view->vars['locale'] = $options['locale'];
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => $this->locale == 'fa' ? 'تاریخ وارد شده اشتباه است' : 'Selected date is invalid.',
            'serverFormat' => 'yyyy/MM/dd',
            'locale' => $this->locale,
            'pickerOptions' => [],
            'parent_attr' => array(
                'class'   => 'col-sm-6'
            ),
        ));

        $resolver->setAllowedTypes('serverFormat', ['string', 'null']);
        $resolver->setAllowedTypes('locale', ['string', 'null']);
        $resolver->setAllowedValues('locale', ['fa', 'en', null]);
        $resolver->setAllowedTypes('pickerOptions', ['array', 'null']);
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
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'jSDate';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
} 