<?php
namespace IDCI\Bundle\MergeTokenBundle\Mergeable;

/**
 * MergeableObject
 *
 * @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
class MergeableObject implements MergeableObjectInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var array
     */
    protected $properties;

    /**
     * Constructor
     *
     * @param string $id
     * @param string $className
     * @param array  $properties
     */
    public function __construct($id = null, $className = null, array $properties = array())
    {
        $this->id         = $id;
        $this->className  = $className;
        $this->properties = $properties;
    }

    /**
     * Get Id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Id
     *
     * @param  string $id
     * @return MergeableObject
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get ClassName
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Set ClassName
     *
     * @param  string $className
     * @return MergeableObject
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get Properties
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set Properties
     *
     * @param  array $properties
     * @return MergeableObject
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;

        return $this;
    }
}