<?php

namespace UIFI\ReportesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use controlid\Bundle\ActivosBundle\Entity\Lista;

class ReportesType extends AbstractType
{

  /**
   * Constructor del Formulario
   *
   * @param $grupos grupos de investigación
  */
  function __construct($grupos)
  {
      $this->choicesGrupos = $grupos;
  }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('grupo',   'filter_entity', array( 'class'=>'UIFIIntegrantesBundle:Grupo', 'choices' => $this->choicesGrupos ) );

        $builder->add('discriminarGrupo','choice' ,
          array( 'expanded' => true,
                 'multiple' => false,
                 'required' => false,
                 'choices' => array( 'fechaGrupo' => 'Fecha y Grupo', 'grupo' => 'Grupo',  'totalFecha' => 'Total por Fecha'))  );

        $builder->add('discriminarIntegrante','choice' ,
          array( 'expanded' => true,
                 'multiple' => false,
                 'required' => false,
                 'choices' => array('fecha' => 'Fecha', 'integrante' => 'Integrante'))  );
        $builder->add('integrantes','filter_entity', array( 'class'=>'UIFIIntegrantesBundle:Integrante' ) );
        $builder->add('fecha', 'filter_date_range', array(
            'left_date_options' => array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'date form-control'),
            ),
            'right_date_options' => array(
               'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'date form-control'),
            ),
        ));
    }

    public function getName()
    {
        return 'uifi_reportes';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering')
        ));
    }
}
