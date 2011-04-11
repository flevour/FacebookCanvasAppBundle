<?php


namespace Caefer\FacebookAppBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;

class FacebookAppFactory extends AbstractFactory
{
    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'caefer_facebookapp';
    }

    protected function getListenerId()
    {
        return 'caefer_facebookapp.security.authentication.listener';
    }

    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        // with user provider
        if (isset($config['provider'])) {
            $authProviderId = 'caefer_facebookapp.auth.'.$id;

            $container
                ->setDefinition($authProviderId, new DefinitionDecorator('caefer_facebookapp.auth'))
                ->addArgument(new Reference($userProviderId))
                ->addArgument(new Reference('security.user_checker'))
            ;

            return $authProviderId;
        }

        // without user provider
        return 'caefer_facebookapp.auth';
    }

    protected function createEntryPoint($container, $id, $config, $defaultEntryPointId)
    {
        $entryPointId = 'caefer_facebookapp.security.authentication.entry_point.'.$id;

        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('caefer_facebookapp.security.authentication.entry_point'))
            ->setArgument(1, $config)
        ;

        // set options to container for use by other classes
        $container->setParameter('caefer_facebookapp.options.'.$id, $config);

        return $entryPointId;
    }
}
