<?php

namespace UIFI\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
    /**
     * @Route("/admin/dashboard/", name="admin_dashboard")
     */
    public function indexAction()
    {
        return  $this->render('UIFIAdminBundle:Dashboard:index.html.twig');
    }

}
