<?php
namespace IDCI\Bundle\MergeTokenBundle\Twig;

use IDCI\Bundle\MergeTokenBundle\Mergeable\MergeableObjectHandler;

/**
 * MergeTokenExtension
 *
 * @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
class MergeTokenExtension extends \Twig_Extension
{
    protected $mergeableObjectHandler;

    /**
     * Constructor
     *
     * @param MergeableObjectHandler $mergeableObjectHandler
     */
    public function __construct(MergeableObjectHandler $mergeableObjectHandler)
    {
        $this->mergeableObjectHandler = $mergeableObjectHandler;
    }

    /**
     * Get Mergeable Object Handler
     *
     * @return MergeableObjectHandler
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
            new \Twig_SimpleFilter('merge_token', array($this, 'mergeToken')),
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