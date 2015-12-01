<?php

namespace Ais\PertemuanMahasiswaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ais\PertemuanMahasiswaBundle\Model\PertemuanMahasiswaInterface;

/**
 * PertemuanMahasiswa
 */
class PertemuanMahasiswa implements PertemuanMahasiswaInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $pertemuan_id;

    /**
     * @var integer
     */
    private $mahasiswa_id;

    /**
     * @var integer
     */
    private $kehadiran;

    /**
     * @var string
     */
    private $keterangan;

    /**
     * @var boolean
     */
    private $is_delete;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pertemuanId
     *
     * @param integer $pertemuanId
     *
     * @return PertemuanMahasiswa
     */
    public function setPertemuanId($pertemuanId)
    {
        $this->pertemuan_id = $pertemuanId;

        return $this;
    }

    /**
     * Get pertemuanId
     *
     * @return integer
     */
    public function getPertemuanId()
    {
        return $this->pertemuan_id;
    }

    /**
     * Set mahasiswaId
     *
     * @param integer $mahasiswaId
     *
     * @return PertemuanMahasiswa
     */
    public function setMahasiswaId($mahasiswaId)
    {
        $this->mahasiswa_id = $mahasiswaId;

        return $this;
    }

    /**
     * Get mahasiswaId
     *
     * @return integer
     */
    public function getMahasiswaId()
    {
        return $this->mahasiswa_id;
    }

    /**
     * Set kehadiran
     *
     * @param integer $kehadiran
     *
     * @return PertemuanMahasiswa
     */
    public function setKehadiran($kehadiran)
    {
        $this->kehadiran = $kehadiran;

        return $this;
    }

    /**
     * Get kehadiran
     *
     * @return integer
     */
    public function getKehadiran()
    {
        return $this->kehadiran;
    }

    /**
     * Set keterangan
     *
     * @param string $keterangan
     *
     * @return PertemuanMahasiswa
     */
    public function setKeterangan($keterangan)
    {
        $this->keterangan = $keterangan;

        return $this;
    }

    /**
     * Get keterangan
     *
     * @return string
     */
    public function getKeterangan()
    {
        return $this->keterangan;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return PertemuanMahasiswa
     */
    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete()
    {
        return $this->is_delete;
    }
}

