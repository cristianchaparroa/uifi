<?php

namespace UsersBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UsuarioAdmin extends Admin
{
    protected $baseRouteName = 'usuarios';
    protected $baseRoutePattern = 'usuarios';
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('email')
            ->add('username')
            ->add('roles','choice',array('choices'=>$this->getConfigurationPool()->getContainer()->getParameter('security.role_hierarchy.roles'),'multiple'=>true ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('username')
            ->add('roles')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('username')
            //Llama al método getRolesAsString en UsersBudle\Entity\Usuario
            ->add('rolesAsString','string', array('label' => 'Role'))
        ;
    }
}
