<?php
namespace IDCI\Bundle\MergeTokenBundle\Mergeable;

/**
 * MergeableObjectInterface
 *
 * @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
interface MergeableObjectInterface
{
    /**
     * Get Id
     *
     * @return string
     */
    public function getId();

    /**
     * Set Id
     *
     * @param  string $id
     * @return MergeableObjectInterface
     */
    public function setId($id);

    /**
     * Get ClassName
     *
     * @return string
     */
    public function getClassName();

    /**
     * Set ClassName
     *
     * @param  string $className
     * @return MergeableObjectInterface
     */
    public function setClassName($className);

    /**
     * Get Properties
     *
     * @return array
     */
    public function getProperties();

    /**
     * Set Properties
     *
     * @param  array $properties
     * @return MergeableObjectInterface
     */
    public function setProperties($properties);
}