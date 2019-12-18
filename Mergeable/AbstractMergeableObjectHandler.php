<?php
namespace IDCI\Bundle\MergeTokenBundle\Mergeable;

use Doctrine\Common\Util\ClassUtils;
use IDCI\Bundle\MergeTokenBundle\Exception\MissingMergeableObjectMethodException;
use IDCI\Bundle\MergeTokenBundle\Exception\UndefinedMergeableObjectException;
use JMS\Serializer\Serializer;
use Symfony\Component\DependencyInjection\Container;

/**
 * AbstractMergeableObjectHandler
 *
 * @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
abstract class AbstractMergeableObjectHandler implements  MergeableObjectHandlerInterface
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var MergeableObjectInterface[]
     */
    protected $mergeableObjects;

    /**
     * Constructor
     *
     * @param Container         $container
     * @param array             $configuration
     */
    public function __construct(Container $container, array $configuration)
    {
        $this->serializer = $container->get('jms_serializer');

        foreach ($configuration as $id => $mergeableObjectRaw) {
            $this->setMergeableObject($id, new MergeableObject(
                $id,
                $mergeableObjectRaw['class'],
                $mergeableObjectRaw['properties']
            ));
        }
    }

    /**
     * SetMergeableObject
     *
     * @param string                   $id
     * @param MergeableObjectInterface $object
     */
    public function setMergeableObject($id, MergeableObjectInterface $object)
    {
        $this->mergeableObjects[$id] = $object;
    }

    /**
     * GetMergeableObjects
     *
     * @return MergeableObjectInterface[]
     */
    public function getMergeableObjects()
    {
        return $this->mergeableObjects;
    }

    /**
     * GetMergeableObject
     *
     * @param  string $id
     *
     * @return MergeableObjectInterface
     * @throws UndefinedMergeableObjectException
     */
    public function getMergeableObject($id)
    {
        if (!isset($this->mergeableObjects[$id])) {
            throw new UndefinedMergeableObjectException('id', $id);
        }
        return $this->mergeableObjects[$id];
    }

    /**
     * GuessMergeableObject
     *
     * @param  object $object
     *
     * @return MergeableObjectInterface
     * @throws UndefinedMergeableObjectException
     */
    public function guessMergeableObject($object)
    {
        $className = ClassUtils::getClass($object);
        foreach($this->getMergeableObjects() as $mergeableObject) {
            if ($mergeableObject->getClassName() == $className) {
                return $mergeableObject;
            }
        }
        throw new UndefinedMergeableObjectException('className', $className);
    }

    /**
     * Merge a value
     *
     * @param string                   $value
     * @param MergeableObjectInterface $mergeableObject
     * @param object                   $object
     *
     * @return string
     */
    abstract public function merge($value, MergeableObjectInterface $mergeableObject, $object);

    /**
     * Merge token
     *
     * @param  object  $object
     * @param  string  $propertyName
     * @param  boolean $replace
     *
     * @return string  The merge value
     * @throws MissingMergeableObjectMethodException
     */
    public function mergeToken($object, $propertyName, $replace = true)
    {
        $rc = new \ReflectionClass($object);
        $getter = sprintf('get%s', self::camelize($propertyName));
        $setter = sprintf('set%s', self::camelize($propertyName));

        if (!$rc->hasMethod($getter)) {
            throw new MissingMergeableObjectMethodException($object, $getter);
        }

        if (!$rc->hasMethod($setter)) {
            throw new MissingMergeableObjectMethodException($object, $setter);
        }

        $value = $object->$getter();

        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }

        $mergeableObject = $this->guessMergeableObject($object);
        $mergedValue = $this->merge($value, $mergeableObject, $object);

        try {
            $type = $this
                ->serializer
                ->getMetadataFactory()
                ->getMetadataForClass(get_class($object))
                ->propertyMetadata[$propertyName]
                ->type['name']
            ;

            if ('array' === $type) {
                $decoded = json_decode($mergedValue, true);

                if (null === $decoded) {
                    $decoded = array();
                }

                $mergedValue = $decoded;
            }
        } catch (\Exception $e) {
        }

        if ($replace) {
            $object->$setter($mergedValue);
        }

        return $mergedValue;
    }

    /**
     * Returns given word as CamelCased
     *
     * Converts a word like "send_email" to "SendEmail". It
     * will remove non alphanumeric character from the word, so
     * "who's online" will be converted to "WhoSOnline"
     *
     * @param  string $word
     *
     * @return string UpperCamelCasedWord
     */
    public static function camelize($word)
    {
        return str_replace(' ', '' , ucwords(
            preg_replace('/[^A-Z^a-z^0-9]+/', ' ', $word)
        ));
    }
}
