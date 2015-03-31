<?php

namespace UIFI\GrupLACScraperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GruplacType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('nombre')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UIFI\GrupLACScraperBundle\Entity\Gruplac'
        ));
    }

    public function getName()
    {
        return 'uifi_gruplacscraperbundle_gruplac';
    }
}
