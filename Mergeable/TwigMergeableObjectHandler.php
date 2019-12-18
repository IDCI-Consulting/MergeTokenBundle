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

        $this->twig = $container->get('twig');
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function merge($value, MergeableObjectInterface $mergeableObject, $object)
    {
        try {
            return $this->twig->createTemplate($value)
                ->render(array($mergeableObject->getId() => $object))
            ;
        } catch (\Exception $e) {
            return;
        }
    }
}
