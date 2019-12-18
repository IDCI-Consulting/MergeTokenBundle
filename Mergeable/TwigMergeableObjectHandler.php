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
     * @param \Twig_Environment $twig
     * @param Container         $container
     * @param array             $configuration
     */
    public function __construct( \Twig_Environment $twig, Container $container, array $configuration)
    {
        parent::__construct($container, $configuration);

        $this->twig = $twig;
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function merge($value, MergeableObjectInterface $mergeableObject, $object)
    {
        return $this->twig->createTemplate($value)
            ->render(array($mergeableObject->getId() => $object))
        ;
    }
}
