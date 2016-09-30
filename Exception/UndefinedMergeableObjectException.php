<?php
namespace IDCI\Bundle\MergeTokenBundle\Exception;

/**
 * @author: Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
class UndefinedMergeableObjectException extends \Exception
{
    /**
     * The constructor
     *
     * @param string $property
     * @param string $value
     */
    public function __construct($property, $value)
    {
        parent::__construct(sprintf(
            'No mergeable object define with "%s": %s',
            $property,
            $value
        ));
    }
}