<?php
namespace IDCI\Bundle\MergeTokenBundle\Mergeable;

use JMS\Serializer\Serializer;
use Symfony\Component\DependencyInjection\Container;

/**
 * TwigMergeableObjectHandler
 *
 * @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
class TwigMergeableObjectHandler extends AbstractMergeableObjectHandler
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var Container
     */
    protected $container;

    /**
     * Constructor
     *
     * @param Container         $container
     * @param array             $configuration
     */
    public function __construct(Container $container, array $configuration)
    {
        parent::__construct($container, $configuration);

        $this->container = $container;
    }

    /**
     * Get Twig
     *
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->container->get('idci_merge_token.twig');
    }

    /**
     * {@inheritdoc}
     */
    public function merge($value, MergeableObjectInterface $mergeableObject, $object)
    {
        return $this->getTwig()->render(
            $value,
            array($mergeableObject->getId() => $object)
        );
    }
}
