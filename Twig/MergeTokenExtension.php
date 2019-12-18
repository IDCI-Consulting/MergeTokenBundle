<?php
namespace IDCI\Bundle\MergeTokenBundle\Twig;

use IDCI\Bundle\MergeTokenBundle\Mergeable\MergeableObjectHandlerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * MergeTokenExtension
 *
 * @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
class MergeTokenExtension extends AbstractExtension
{
    protected $mergeableObjectHandler;

    /**
     * Constructor
     *
     * @param MergeableObjectHandlerInterface $mergeableObjectHandler
     */
    public function __construct(MergeableObjectHandlerInterface $mergeableObjectHandler)
    {
        $this->mergeableObjectHandler = $mergeableObjectHandler;
    }

    /**
     * Get Mergeable Object Handler
     *
     * @return MergeableObjectHandlerInterface
     */
    public function getMergeableObjectHandler()
    {
        return $this->mergeableObjectHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'idci_merge_token_extension';
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new TwigFilter('merge_token', array($this, 'mergeToken')),
        );
    }

    /**
     * Merge token
     *
     * @param  object $object
     * @param  string $propertyName
     *
     * @return string The merge value
     */
    public function mergeToken($object, $propertyName)
    {
        return $this
            ->getMergeableObjectHandler()
            ->mergeToken($object, $propertyName, false)
        ;
    }
}
