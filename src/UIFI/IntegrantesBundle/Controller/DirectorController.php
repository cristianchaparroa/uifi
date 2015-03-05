<?php

namespace UIFI\IntegrantesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/director")
 */
class DirectorController extends Controller
{
    /**
     * @Route("/home", name="director_home")
     * @Template()
     */
    public function homeAction()
    {
        return array();
    }

}
