<?php
namespace IDCI\Bundle\MergeTokenBundle\Event\Subscriber;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\EventDispatcher\Events;
use IDCI\Bundle\MergeTokenBundle\Mergeable\MergeableObjectHandlerInterface;
use IDCI\Bundle\MergeTokenBundle\Exception\UndefinedMergeableObjectException;

/**
 * SerializerSubscriber
 *
 * @author Gabriel Bondaz <gabriel.bondaz@idci-consulting.fr>
 * @author Brahim Boukoufallah <brahim.boukoufallah@idci-consulting.fr>
 */
class SerializerSubscriber implements EventSubscriberInterface
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
    public static function getSubscribedEvents()
    {
        return array(
            array(
                'event'     => Events::PRE_SERIALIZE,
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'method'    => 'onPreSerialize',
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function onPreSerialize(ObjectEvent $event)
    {
        $object = $event->getObject();
        try {
            $mergeableObject = $this
                ->getMergeableObjectHandler()
                ->guessMergeableObject($object)
            ;
            foreach ($mergeableObject->getProperties() as $propertyName => $propertyParameters) {
                $this
                    ->getMergeableObjectHandler()
                    ->mergeToken($object, $propertyName)
                ;
            }
        } catch (UndefinedMergeableObjectException $e) {
            return;
        }
    }
}
