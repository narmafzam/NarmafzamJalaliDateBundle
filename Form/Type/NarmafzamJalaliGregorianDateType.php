<?php
/**
 * This file is part of cardioclinic
 * Copyrighted by Narmafzam (Farzam Webnegar Sivan Co.), info@narmafzam.com
 * Created by peyman
 * Date: 08/29/2018
 */

namespace Narmafzam\JalaliDateBundle\Form\Type;

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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'parent_attr' => array(
                'class'   => 'col-sm-6'
            )
        ));
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
}