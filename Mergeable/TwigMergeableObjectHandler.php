<?php
namespace IDCI\Bundle\MergeTokenBundle\Mergeable;

use JMS\Serializer\Serializer;

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
     * Constructor
     *
     * @param \Twig_Environment $twig
     * @param Serializer        $serializer
     * @param array             $configuration
     */
    public function __construct(\Twig_Environment $twig, Serializer $serializer, array $configuration)
    {
        parent::__construct($serializer, $configuration);

        $this->twig = $twig;
    }

    /**
     * Get Twig
     *
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
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
