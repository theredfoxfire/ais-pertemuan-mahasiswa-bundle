<?php

namespace Ais\PertemuanMahasiswaBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Ais\PertemuanMahasiswaBundle\Model\PertemuanMahasiswaInterface;
use Ais\PertemuanMahasiswaBundle\Form\PertemuanMahasiswaType;
use Ais\PertemuanMahasiswaBundle\Exception\InvalidFormException;

class PertemuanMahasiswaHandler implements PertemuanMahasiswaHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * Get a PertemuanMahasiswa.
     *
     * @param mixed $id
     *
     * @return PertemuanMahasiswaInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get a list of PertemuanMahasiswas.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy(array(), null, $limit, $offset);
    }

    /**
     * Create a new PertemuanMahasiswa.
     *
     * @param array $parameters
     *
     * @return PertemuanMahasiswaInterface
     */
    public function post(array $parameters)
    {
        $pertemuan_mahasiswa = $this->createPertemuanMahasiswa();

        return $this->processForm($pertemuan_mahasiswa, $parameters, 'POST');
    }

    /**
     * Edit a PertemuanMahasiswa.
     *
     * @param PertemuanMahasiswaInterface $pertemuan_mahasiswa
     * @param array         $parameters
     *
     * @return PertemuanMahasiswaInterface
     */
    public function put(PertemuanMahasiswaInterface $pertemuan_mahasiswa, array $parameters)
    {
        return $this->processForm($pertemuan_mahasiswa, $parameters, 'PUT');
    }

    /**
     * Partially update a PertemuanMahasiswa.
     *
     * @param PertemuanMahasiswaInterface $pertemuan_mahasiswa
     * @param array         $parameters
     *
     * @return PertemuanMahasiswaInterface
     */
    public function patch(PertemuanMahasiswaInterface $pertemuan_mahasiswa, array $parameters)
    {
        return $this->processForm($pertemuan_mahasiswa, $parameters, 'PATCH');
    }

    /**
     * Processes the form.
     *
     * @param PertemuanMahasiswaInterface $pertemuan_mahasiswa
     * @param array         $parameters
     * @param String        $method
     *
     * @return PertemuanMahasiswaInterface
     *
     * @throws \Ais\PertemuanMahasiswaBundle\Exception\InvalidFormException
     */
    private function processForm(PertemuanMahasiswaInterface $pertemuan_mahasiswa, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new PertemuanMahasiswaType(), $pertemuan_mahasiswa, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {

            $pertemuan_mahasiswa = $form->getData();
            $this->om->persist($pertemuan_mahasiswa);
            $this->om->flush($pertemuan_mahasiswa);

            return $pertemuan_mahasiswa;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createPertemuanMahasiswa()
    {
        return new $this->entityClass();
    }

}
