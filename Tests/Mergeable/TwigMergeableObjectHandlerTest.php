<?php

namespace IDCI\Bundle\MergeTokenBundle\Tests\Mergeable;

use IDCI\Bundle\MergeTokenBundle\Exception\MissingMergeableObjectMethodException;
use IDCI\Bundle\MergeTokenBundle\Mergeable\TwigMergeableObjectHandler;
use IDCI\Bundle\MergeTokenBundle\Tests\Model\Author;
use IDCI\Bundle\MergeTokenBundle\Tests\Model\Comment;
use JMS\Serializer\Serializer;
use Metadata\MetadataFactoryInterface;

class TwigMergeableObjectHandlerTest extends \PHPUnit_Framework_TestCase
{
    private $mergeableObjectHandler;
    private $metadataFactory;
    private $serializerMock;
    private $comment;
    private $author;

    public function setUp()
    {
        $twigStringLoader = new \Twig_Loader_String();
        $twigEnvironment  = new \Twig_Environment($twigStringLoader, array());

        $this->metadataFactoryMock = $this
            ->getMockBuilder(MetadataFactoryInterface::class)
            ->setMethods(array('getMetadataForClass'))
            ->getMock()
        ;

        $this->serializerMock = $this
            ->getMockBuilder(Serializer::class)
            ->disableOriginalConstructor()
            ->setMethods(array('getMetadataFactory'))
            ->setConstructorArgs(array($this->metadataFactory))
            ->getMock()
        ;

        $this->author  = new Author();
        $this->author
            ->setName('Brahim')
            ->setAge(26)
            ->setSkills(array('php', 'symfony', 'unit_test'))
        ;

        $this->comment = new Comment();
        $this->comment
            ->setDate(new \DateTime('09/29/2016'))
            ->setAuthor($this->author)
        ;

        $configuration = array(
            'comment' => array(
                'class' => 'IDCI\Bundle\MergeTokenBundle\Tests\Model\Comment',
                'properties' => array('content' => null, 'author' => null)
            ),
            'author' => array(
                'class' => 'IDCI\Bundle\MergeTokenBundle\Tests\Model\Author',
                'properties' => array('name' => null, 'age' => null, 'skills' => null)
            )
        );

        $this->mergeableObjectHandler = new TwigMergeableObjectHandler($twigEnvironment, $this->serializerMock, $configuration);
    }

    public function testMergeToken()
    {
        $this->metadataFactoryMock
            ->expects($this->any())
            ->method('getMetadataForClass')
            ->willReturn(get_class($this->comment))
        ;

        $this->serializerMock
            ->expects($this->any())
            ->method('getMetadataFactory')
            ->willReturn($this->metadataFactoryMock)
        ;

        $this->comment->setContent('The comment was made {{ comment.date|date("m/d/Y") }}');
        $this->mergeableObjectHandler->mergeToken($this->comment, 'content', true);
        $this->assertEquals('The comment was made 09/29/2016', $this->comment->getContent());

        $this->comment->setContent('The author name is {{ comment.author.name }}');
        $this->mergeableObjectHandler->mergeToken($this->comment, 'content', true);
        $this->assertEquals('The author name is Brahim', $this->comment->getContent());

        $this->comment->setContent('The author name is {% for skill in comment.author.skills %}{{ skill }}{% if false == loop.last %} {% endif %}{% endfor %}');
        $this->mergeableObjectHandler->mergeToken($this->comment, 'content', true);
        $this->assertEquals('The author name is php symfony unit_test', $this->comment->getContent());

        $this->comment->setContent('The author age is {{ comment.author.age }}');
        $this->mergeableObjectHandler->mergeToken($this->comment, 'content', true);
        $this->assertEquals('The author age is 26', $this->comment->getContent());

        $this->comment->setContent('The author age is {{ comment.author.age }}');
        $this->mergeableObjectHandler->mergeToken($this->comment, 'content', false);
        $this->assertEquals('The author age is {{ comment.author.age }}', $this->comment->getContent());
    }
}