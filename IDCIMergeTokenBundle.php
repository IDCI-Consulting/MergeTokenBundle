<?php
namespace IDCI\Bundle\MergeTokenBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use IDCI\Bundle\MergeTokenBundle\DependencyInjection\Compiler\IDCIMergeTokenTwigEnvironmentPass;

/**
 * Bundle
 *
 * @author: Brahim BOUKOUFALLAH <brahim.boukoufallah@idci-consulting.fr>
 * @license: MIT
 */
class IDCIMergeTokenBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new IDCIMergeTokenTwigEnvironmentPass());
    }
}
