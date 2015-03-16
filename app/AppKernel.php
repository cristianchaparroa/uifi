<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new UsersBundle\UsersBundle(),
	          new Lexik\Bundle\FormFilterBundle\LexikFormFilterBundle(),
	          new JordiLlonch\Bundle\CrudGeneratorBundle\JordiLlonchCrudGeneratorBundle(),
            // //sonata admin bundles
            // new Sonata\CoreBundle\SonataCoreBundle(),
            // new Sonata\BlockBundle\SonataBlockBundle(),
            // new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            // new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            // new Sonata\AdminBundle\SonataAdminBundle(),
            //UIFI Bundles
            new UIFI\IntegrantesBundle\UIFIIntegrantesBundle(),
            new UIFI\GrupLACScraperBundle\UIFIGrupLACScraperBundle(),
            new UIFI\ProductosBundle\UIFIProductosBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new UIFI\AdminBundle\UIFIAdminBundle(),
            //corse bundle
            new Nelmio\CorsBundle\NelmioCorsBundle(),

            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            new UIFI\ReportesBundle\UIFIReportesBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
