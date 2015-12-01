<?php

namespace Ais\PertemuanMahasiswaBundle\Model;

Interface PertemuanMahasiswaInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set pertemuanId
     *
     * @param integer $pertemuanId
     *
     * @return PertemuanMahasiswa
     */
    public function setPertemuanId($pertemuanId);

    /**
     * Get pertemuanId
     *
     * @return integer
     */
    public function getPertemuanId();

    /**
     * Set mahasiswaId
     *
     * @param integer $mahasiswaId
     *
     * @return PertemuanMahasiswa
     */
    public function setMahasiswaId($mahasiswaId);

    /**
     * Get mahasiswaId
     *
     * @return integer
     */
    public function getMahasiswaId();

    /**
     * Set kehadiran
     *
     * @param integer $kehadiran
     *
     * @return PertemuanMahasiswa
     */
    public function setKehadiran($kehadiran);

    /**
     * Get kehadiran
     *
     * @return integer
     */
    public function getKehadiran();

    /**
     * Set keterangan
     *
     * @param string $keterangan
     *
     * @return PertemuanMahasiswa
     */
    public function setKeterangan($keterangan);

    /**
     * Get keterangan
     *
     * @return string
     */
    public function getKeterangan();

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return PertemuanMahasiswa
     */
    public function setIsDelete($isDelete);

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete();
}
