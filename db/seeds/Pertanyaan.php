<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Pertanyaan extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
//            1
            [
                'indikator_id' => 1,
                'pertanyaan' => 'Bagaimana pendapat Anda tentang kejelasan materi yang disampaikan dosen?'
            ],
            [
                'indikator_id' => 1,
                'pertanyaan' => 'Bagaimana kualitas interaksi antara dosen dan mahasiswa selama proses pembelajaran?'
            ],
            [
                'indikator_id' => 1,
                'pertanyaan' => 'Bagaimana penilaian Anda terhadap keterlibatan mahasiswa dalam diskusi kelas?'
            ],
            [
                'indikator_id' => 1,
                'pertanyaan' => 'Bagaimana pendapat Anda tentang penggunaan media pembelajaran oleh dosen?'
            ],
            [
                'indikator_id' => 1,
                'pertanyaan' => 'Bagaimana evaluasi Anda terhadap ketersediaan materi tambahan dan sumber belajar?'
            ],
            [
                'indikator_id' => 1,
                'pertanyaan' => 'Bagaimana Anda menilai kemampuan dosen dalam menjelaskan konsep yang sulit?'
            ],
//            2
            [
                'indikator_id' => 2,
                'pertanyaan' => 'Bagaimana penilaian Anda terhadap proses registrasi mata kuliah?'
            ],
            [
                'indikator_id' => 2,
                'pertanyaan' => 'Bagaimana pendapat Anda tentang aksesibilitas dan ketersediaan informasi akademik?'
            ],
            [
                'indikator_id' => 2,
                'pertanyaan' => 'Bagaimana evaluasi Anda terhadap kecepatan pelayanan administrasi akademik?'
            ],
            [
                'indikator_id' => 2,
                'pertanyaan' => 'Bagaimana Anda menilai responsivitas staf akademik terhadap pertanyaan dan masalah mahasiswa?'
            ],
            [
                'indikator_id' => 2,
                'pertanyaan' => 'Bagaimana kepuasan Anda terhadap sistem informasi akademik online yang digunakan?'
            ],
            [
                'indikator_id' => 2,
                'pertanyaan' => 'Bagaimana pendapat Anda tentang transparansi penilaian dan evaluasi akademik?'
            ],
//            3
            [
                'indikator_id' => 3,
                'pertanyaan' => 'Bagaimana pendapat Anda tentang bimbingan dan konseling yang disediakan?'
            ],
            [
                'indikator_id' => 3,
                'pertanyaan' => 'Bagaimana Anda menilai dukungan untuk kegiatan ekstrakurikuler mahasiswa?'
            ],
            [
                'indikator_id' => 3,
                'pertanyaan' => 'Bagaimana penilaian Anda terhadap kegiatan orientasi dan pengenalan kampus bagi mahasiswa baru?'
            ],
            [
                'indikator_id' => 3,
                'pertanyaan' => 'Bagaimana kepuasan Anda terhadap program beasiswa dan bantuan keuangan?'
            ],
            [
                'indikator_id' => 3,
                'pertanyaan' => 'Bagaimana Anda menilai upaya kampus dalam mendukung kesejahteraan dan keseimbangan hidup mahasiswa?'
            ],
            [
                'indikator_id' => 3,
                'pertanyaan' => 'Bagaimana penilaian Anda terhadap layanan administrasi kemahasiswaan?'
            ],
//            4
            [
                'indikator_id' => 4,
                'pertanyaan' => 'Bagaimana penilaian Anda terhadap kelengkapan fasilitas laboratorium?'
            ],
            [
                'indikator_id' => 4,
                'pertanyaan' => 'Bagaimana Anda menilai kebersihan dan kenyamanan ruang kelas?'
            ],
            [
                'indikator_id' => 4,
                'pertanyaan' => 'Bagaimana kepuasan Anda terhadap akses internet dan teknologi informasi di kampus?'
            ],
            [
                'indikator_id' => 4,
                'pertanyaan' => 'Bagaimana penilaian Anda terhadap ketersediaan dan kondisi peralatan belajar di kelas?'
            ],
            [
                'indikator_id' => 4,
                'pertanyaan' => 'Bagaimana Anda menilai aksesibilitas dan kemudahan penggunaan fasilitas perpustakaan?'
            ],
            [
                'indikator_id' => 4,
                'pertanyaan' => 'Bagaimana pendapat Anda tentang ketersediaan ruang belajar dan diskusi di kampus?'
            ]
        ];

        $this->table('pertanyaan')->insert($data)->save();
    }
}
