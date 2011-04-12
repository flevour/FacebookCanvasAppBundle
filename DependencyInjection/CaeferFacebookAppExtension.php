<?php

namespace Caefer\FacebookAppBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CaeferFacebookAppExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $container->setParameter('caefer_facebookapp.api.file', $config[0]['api']['file']);
        $container->setParameter('caefer_facebookapp.api.app_id', $config[0]['api']['app_id']);
        $container->setParameter('caefer_facebookapp.api.secret', $config[0]['api']['secret']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('security.xml');
    }

    public function getAlias()
    {
        return 'caefer_facebook_app';
    }
}
