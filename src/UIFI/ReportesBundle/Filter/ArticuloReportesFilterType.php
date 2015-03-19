<?php

namespace UIFI\ReportesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use controlid\Bundle\ActivosBundle\Entity\Lista;

class ArticuloReportesFilterType extends AbstractType
{

  /**
   * Constructor del friltro
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
    //         ->add('fecha', 'filter_date_range', array(
    //             'left_date_options' => array(
    //                 'widget' => 'single_text',
    //                 'format' => 'dd-MM-yyyy',
    //                 'attr' => array('class' => 'date form-box'),
    //             ),
    //             'right_date_options' => array(
    //                'widget' => 'single_text',
    //                 'format' => 'dd-MM-yyyy',
    //                 'attr' => array('class' => 'date form-box'),
    //             ),
    //         ));
        $builder->add('grupo',   'filter_entity', array( 'class'=>'UIFIIntegrantesBundle:Grupo', 'choices' => $this->choicesGrupos ) );

    }

    public function getName()
    {
        return 'uifi_reportes_articulo_filer';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering')
        ));
    }
}
