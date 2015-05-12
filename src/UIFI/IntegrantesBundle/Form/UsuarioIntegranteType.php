<?php

namespace UIFI\IntegrantesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use UIFI\IntegrantesBundle\Entity\Integrante;

class UsuarioIntegranteType extends AbstractType
{
    function __construct($integrantes)
    {
      $this->integrantes = $integrantes;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('integrante','entity',
              array(
                'class'=> 'UIFIIntegrantesBundle:Integrante',
                'choices' => $this->integrantes
              ))
            ->add('email', null)
            ->add('estado', null);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UsersBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'usersbundle_usuario';
    }
}
