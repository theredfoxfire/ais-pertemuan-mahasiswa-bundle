<?php

namespace Ais\PertemuanMahasiswaBundle\Handler;

use Ais\PertemuanMahasiswaBundle\Model\PertemuanMahasiswaInterface;

interface PertemuanMahasiswaHandlerInterface
{
    /**
     * Get a PertemuanMahasiswa given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return PertemuanMahasiswaInterface
     */
    public function get($id);

    /**
     * Get a list of PertemuanMahasiswas.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post PertemuanMahasiswa, creates a new PertemuanMahasiswa.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return PertemuanMahasiswaInterface
     */
    public function post(array $parameters);

    /**
     * Edit a PertemuanMahasiswa.
     *
     * @api
     *
     * @param PertemuanMahasiswaInterface   $pertemuan_mahasiswa
     * @param array           $parameters
     *
     * @return PertemuanMahasiswaInterface
     */
    public function put(PertemuanMahasiswaInterface $pertemuan_mahasiswa, array $parameters);

    /**
     * Partially update a PertemuanMahasiswa.
     *
     * @api
     *
     * @param PertemuanMahasiswaInterface   $pertemuan_mahasiswa
     * @param array           $parameters
     *
     * @return PertemuanMahasiswaInterface
     */
    public function patch(PertemuanMahasiswaInterface $pertemuan_mahasiswa, array $parameters);
}
