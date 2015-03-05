<?php

namespace UsersBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UsersBundle extends Bundle
{
  /**
    * Indicando que el padre de este Bundle es FOSUserBundle
    * para personalizar las opciones de configuración y las plantillas.
   */
   public function getParent()
   {
     return 'FOSUserBundle';
   }
}
