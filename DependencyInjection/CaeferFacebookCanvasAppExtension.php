<?php

namespace Caefer\FacebookCanvasAppBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class CaeferFacebookCanvasAppExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        if (isset($config[0]['apps'])) {
            $first = true;
            foreach ($config[0]['apps'] as $name => $app) {

                $definition = new Definition();
                $definition->setClass('Facebook');
                $definition->setFile($config[0]['file']);
                $definition->setArguments(array(array(
                    'appId'  => $app['app_id'],
                    'secret' => $app['secret'],
                    'cookie' => true,
                )));

                $container->setDefinition('caefer_facebook_canvas_app.app.'.$name, $definition);

                $container->setParameter('caefer_facebook_canvas_app.app.'.$name.'.app_id', $app['app_id']);
                $container->setParameter('caefer_facebook_canvas_app.app.'.$name.'.secret', $app['secret']);

                if ($first) {
                    $container->setParameter('caefer_facebook_canvas_app.api.file',   $config[0]['file']);
                    $container->setParameter('caefer_facebook_canvas_app.api.app_id', $app['app_id']);
                    $container->setParameter('caefer_facebook_canvas_app.api.secret', $app['secret']);
                    $first = true;
                }
            }
        } else {

            $container->setParameter('caefer_facebook_canvas_app.api.file',   $config[0]['api']['file']);
            $container->setParameter('caefer_facebook_canvas_app.api.app_id', $config[0]['api']['app_id']);
            $container->setParameter('caefer_facebook_canvas_app.api.secret', $config[0]['api']['secret']);
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('security.xml');
    }

    public function getAlias()
    {
        return 'caefer_facebook_canvas_app';
    }
}
