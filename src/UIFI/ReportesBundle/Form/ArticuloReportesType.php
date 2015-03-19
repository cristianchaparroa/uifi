<?php

namespace UIFI\ReportesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use controlid\Bundle\ActivosBundle\Entity\Lista;

class ArticuloReportesType extends AbstractType
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
    //     $builder
    //         ->add('operador', 'filter_entity', array('class'=>'controlidActivosBundle:OperadorActivos', 'choices'=>$this->choicesOperadores))
    //         ->add('categoria', 'filter_entity', array('class'=>'controlidActivosBundle:Categoria', 'choices'=>$this->choicesCategorias))
    //         ->add('activo', 'filter_entity', array('class'=>'controlidActivosBundle:Activo', 'choices'=>$this->choicesActivos))

        $builder->add('grupo',   'filter_entity', array( 'class'=>'UIFIIntegrantesBundle:Grupo', 'choices' => $this->choicesGrupos ) );

        $builder->add('discriminar','choice' ,
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
        return 'uifi_reportes_articulo';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering')
        ));
    }
}
