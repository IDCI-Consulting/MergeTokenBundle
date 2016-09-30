<?php
namespace IDCI\Bundle\MergeTokenBundle\Exception;

/**
 * @author: Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 */
class MissingMergeableObjectMethodException extends \Exception
{
    /**
     * The constructor
     *
     * @param object $object
     * @param string $method
     */
    public function __construct($object, $method)
    {
        parent::__construct(sprintf(
            'Missing mergeable object method [%s]: "%s"',
            get_class($object),
            $method
        ));
    }
}