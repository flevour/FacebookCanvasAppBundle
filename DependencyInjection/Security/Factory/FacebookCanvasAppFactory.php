<?php


namespace Caefer\FacebookCanvasAppBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;

class FacebookCanvasAppFactory extends AbstractFactory
{
    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'caefer_facebook_canvas_app';
    }

    protected function getListenerId()
    {
        return 'caefer_facebook_canvas_app.security.authentication.listener';
    }

    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        // with user provider
        if (isset($config['provider'])) {
            $authProviderId = 'caefer_facebook_canvas_app.auth.'.$id;

            $container
                ->setDefinition($authProviderId, new DefinitionDecorator('caefer_facebook_canvas_app.auth'))
                ->addArgument(new Reference($userProviderId))
                ->addArgument(new Reference('security.user_checker'))
            ;

            return $authProviderId;
        }

        // without user provider
        return 'caefer_facebook_canvas_app.auth';
    }

    protected function createEntryPoint($container, $id, $config, $defaultEntryPointId)
    {
        $entryPointId = 'caefer_facebook_canvas_app.security.authentication.entry_point.'.$id;

        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('caefer_facebook_canvas_app.security.authentication.entry_point'))
            ->setArgument(1, $config)
        ;

        // set options to container for use by other classes
        $container->setParameter('caefer_facebook_canvas_app.options.'.$id, $config);

        return $entryPointId;
    }
}
