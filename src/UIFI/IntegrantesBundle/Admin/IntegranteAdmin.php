<?php

namespace UIFI\IntegrantesBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class IntegranteAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('documento')
            ->add('nombres')
            ->add('apellidos')
            ->add('codigo')
            ->add('telefono')
            ->add('celular')
            ->add('correoInstitucional')
            ->add('correoPersonal')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('documento')
            ->add('nombres')
            ->add('apellidos')
            ->add('codigo')
            ->add('telefono')
            ->add('celular')
            ->add('correoInstitucional')
            ->add('correoPersonal')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('documento')
            ->add('nombres')
            ->add('apellidos')
            ->add('codigo')
            ->add('telefono')
            ->add('celular')
            ->add('correoInstitucional')
            ->add('correoPersonal')
        ;
    }
}
