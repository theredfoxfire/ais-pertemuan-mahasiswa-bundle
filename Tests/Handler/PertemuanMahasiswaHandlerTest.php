<?php

namespace Ais\PertemuanMahasiswaBundle\Tests\Handler;

use Ais\PertemuanMahasiswaBundle\Handler\PertemuanMahasiswaHandler;
use Ais\PertemuanMahasiswaBundle\Model\PertemuanMahasiswaInterface;
use Ais\PertemuanMahasiswaBundle\Entity\PertemuanMahasiswa;

class PertemuanMahasiswaHandlerTest extends \PHPUnit_Framework_TestCase
{
    const DOSEN_CLASS = 'Ais\PertemuanMahasiswaBundle\Tests\Handler\DummyPertemuanMahasiswa';

    /** @var PertemuanMahasiswaHandler */
    protected $pertemuan_mahasiswaHandler;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $om;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }
        
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');

        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($this->repository));
        $this->om->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::DOSEN_CLASS))
            ->will($this->returnValue($class));
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::DOSEN_CLASS));
    }


    public function testGet()
    {
        $id = 1;
        $pertemuan_mahasiswa = $this->getPertemuanMahasiswa();
        $this->repository->expects($this->once())->method('find')
            ->with($this->equalTo($id))
            ->will($this->returnValue($pertemuan_mahasiswa));

        $this->pertemuan_mahasiswaHandler = $this->createPertemuanMahasiswaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $this->pertemuan_mahasiswaHandler->get($id);
    }

    public function testAll()
    {
        $offset = 1;
        $limit = 2;

        $pertemuan_mahasiswas = $this->getPertemuanMahasiswas(2);
        $this->repository->expects($this->once())->method('findBy')
            ->with(array(), null, $limit, $offset)
            ->will($this->returnValue($pertemuan_mahasiswas));

        $this->pertemuan_mahasiswaHandler = $this->createPertemuanMahasiswaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);

        $all = $this->pertemuan_mahasiswaHandler->all($limit, $offset);

        $this->assertEquals($pertemuan_mahasiswas, $all);
    }

    public function testPost()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $pertemuan_mahasiswa = $this->getPertemuanMahasiswa();
        $pertemuan_mahasiswa->setTitle($title);
        $pertemuan_mahasiswa->setBody($body);

        $form = $this->getMock('Ais\PertemuanMahasiswaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($pertemuan_mahasiswa));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pertemuan_mahasiswaHandler = $this->createPertemuanMahasiswaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $pertemuan_mahasiswaObject = $this->pertemuan_mahasiswaHandler->post($parameters);

        $this->assertEquals($pertemuan_mahasiswaObject, $pertemuan_mahasiswa);
    }

    /**
     * @expectedException Ais\PertemuanMahasiswaBundle\Exception\InvalidFormException
     */
    public function testPostShouldRaiseException()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $pertemuan_mahasiswa = $this->getPertemuanMahasiswa();
        $pertemuan_mahasiswa->setTitle($title);
        $pertemuan_mahasiswa->setBody($body);

        $form = $this->getMock('Ais\PertemuanMahasiswaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pertemuan_mahasiswaHandler = $this->createPertemuanMahasiswaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $this->pertemuan_mahasiswaHandler->post($parameters);
    }

    public function testPut()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $pertemuan_mahasiswa = $this->getPertemuanMahasiswa();
        $pertemuan_mahasiswa->setTitle($title);
        $pertemuan_mahasiswa->setBody($body);

        $form = $this->getMock('Ais\PertemuanMahasiswaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($pertemuan_mahasiswa));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pertemuan_mahasiswaHandler = $this->createPertemuanMahasiswaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $pertemuan_mahasiswaObject = $this->pertemuan_mahasiswaHandler->put($pertemuan_mahasiswa, $parameters);

        $this->assertEquals($pertemuan_mahasiswaObject, $pertemuan_mahasiswa);
    }

    public function testPatch()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('body' => $body);

        $pertemuan_mahasiswa = $this->getPertemuanMahasiswa();
        $pertemuan_mahasiswa->setTitle($title);
        $pertemuan_mahasiswa->setBody($body);

        $form = $this->getMock('Ais\PertemuanMahasiswaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($pertemuan_mahasiswa));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->pertemuan_mahasiswaHandler = $this->createPertemuanMahasiswaHandler($this->om, static::DOSEN_CLASS,  $this->formFactory);
        $pertemuan_mahasiswaObject = $this->pertemuan_mahasiswaHandler->patch($pertemuan_mahasiswa, $parameters);

        $this->assertEquals($pertemuan_mahasiswaObject, $pertemuan_mahasiswa);
    }


    protected function createPertemuanMahasiswaHandler($objectManager, $pertemuan_mahasiswaClass, $formFactory)
    {
        return new PertemuanMahasiswaHandler($objectManager, $pertemuan_mahasiswaClass, $formFactory);
    }

    protected function getPertemuanMahasiswa()
    {
        $pertemuan_mahasiswaClass = static::DOSEN_CLASS;

        return new $pertemuan_mahasiswaClass();
    }

    protected function getPertemuanMahasiswas($maxPertemuanMahasiswas = 5)
    {
        $pertemuan_mahasiswas = array();
        for($i = 0; $i < $maxPertemuanMahasiswas; $i++) {
            $pertemuan_mahasiswas[] = $this->getPertemuanMahasiswa();
        }

        return $pertemuan_mahasiswas;
    }
}

class DummyPertemuanMahasiswa extends PertemuanMahasiswa
{
}
