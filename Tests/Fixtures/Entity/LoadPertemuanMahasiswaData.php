<?php

namespace Ais\PertemuanMahasiswaBundle\Tests\Fixtures\Entity;

use Ais\PertemuanMahasiswaBundle\Entity\PertemuanMahasiswa;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadPertemuanMahasiswaData implements FixtureInterface
{
    static public $pertemuan_mahasiswas = array();

    public function load(ObjectManager $manager)
    {
        $pertemuan_mahasiswa = new PertemuanMahasiswa();
        $pertemuan_mahasiswa->setTitle('title');
        $pertemuan_mahasiswa->setBody('body');

        $manager->persist($pertemuan_mahasiswa);
        $manager->flush();

        self::$pertemuan_mahasiswas[] = $pertemuan_mahasiswa;
    }
}
