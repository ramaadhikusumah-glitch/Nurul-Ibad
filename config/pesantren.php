<?php

/*
 * Semua isi web ada di file ini. Teks dan nomor WhatsApp diambil dari web lama
 * (rekaman layar). Foto: taruh di public/images/ sesuai path 'foto' di bawah.
 * Kalau file foto belum ada, web otomatis menampilkan placeholder inisial.
 */

return [
    'nama'    => 'Pondok Pesantren Nurul Ibad',
    'singkat' => 'Nurul Ibad',
    'lokasi'  => 'Jakarta Timur',
    'tahun'   => '2026/2027',
    'kuota'   => '±25 Santri',
    'logo'    => 'images/logo.png',

    // Format internasional, tanpa + dan tanpa 0 di depan
    'wa_panitia' => '6281221978018', // Ust. Rifki (panitia PSB)

    'alamat'     => 'Jl. Gorda No. 44, RT.1/RW. 1, Kelurahan Lubang Buaya, Kecamatan Cipayung, Jakarta Timur, DKI Jakarta 13810',
    'alamat_pendek' => 'Jl. Gorda No. 44, Lubang Buaya, Cipayung, Jakarta Timur',
    'jam_kunjungan' => '08.00 - 17.00 WIB',
    'akses'      => 'Akses mudah via Tol Jagorawi (Exit Taman Mini / Pondok Gede) & Jl. Raya Pondok Gede.',
    'maps_embed' => 'https://www.google.com/maps?q=Jl.+Gorda+No.+44+Lubang+Buaya+Cipayung+Jakarta+Timur&output=embed',
    'maps_link'  => 'https://www.google.com/maps/search/?api=1&query=Jl.+Gorda+No.+44+Lubang+Buaya+Cipayung+Jakarta+Timur',
    'maps_arah'  => 'https://www.google.com/maps/dir/?api=1&destination=Jl.+Gorda+No.+44+Lubang+Buaya+Cipayung+Jakarta+Timur',

    'hero' => [
        'judul'     => 'Membina Akhlak & Kemandirian Santri Putra: Mengaji Kitab Kuning, Mengenal Dasar Komputer.',
        'deskripsi' => 'Pondok Pesantren Nurul Ibad Jakarta Timur menyelenggarakan pendidikan pesantren khusus santri putra berbasis kajian Kitab Kuning dengan daya tampung binaan terbatas (±25 santri). Suasana kekeluargaan yang guyub menjadikan pembinaan adab, ibadah, dan pendampingan belajar santri berlangsung lebih dekat dan terpantau secara intensif.',
        'foto'      => 'images/lingkungan/1.jpg',
        'poin' => [
            'Didirikan oleh Almaghfurlah KH. Muhammad Syakrim, BA',
            'Khusus Santri Putra (lingkungan kondusif)',
            'Binaan Terbatas (±25 Santri) — fokus & guyub',
            'Bimbingan dasar komputer & literasi digital santri',
        ],
        'kartu_komputer' => ['judul' => 'Bimbingan Belajar Komputer', 'isi' => 'Membekali santri keterampilan komputer dasar dan etika digital tanpa meninggalkan fokus ngaji kitab.'],
        'catatan' => '*Lokasi: Jl. Gorda No. 44, Lubang Buaya, Cipayung, Jakarta Timur. Terbuka silaturahmi langsung.',
    ],

    'statistik' => [
        ['label' => 'Santri',     'angka' => 'Khusus Putra'],
        ['label' => 'Kapasitas',  'angka' => '±25 Santri'],
        ['label' => 'Pembinaan',  'angka' => 'Intensif & Adab'],
    ],

    // Foto lingkungan pesantren: tambah/kurangi sesuka hati
    'galeri' => [
        ['foto' => 'images/lingkungan/1.jpg', 'caption' => 'Lingkungan pondok'],
        ['foto' => 'images/lingkungan/2.jpg', 'caption' => 'Asrama santri'],
        ['foto' => 'images/lingkungan/3.jpg', 'caption' => 'Tempat ibadah & ngaji'],
        ['foto' => 'images/lingkungan/4.jpg', 'caption' => 'Ruang belajar komputer'],
        ['foto' => 'images/lingkungan/5.jpg', 'caption' => 'Kegiatan santri'],
        ['foto' => 'images/lingkungan/6.jpg', 'caption' => 'Suasana pondok'],
    ],

    'profil' => [
        'label'  => 'Profil & Sanad Keilmuan',
        'judul'  => 'Skala Binaan Terbatas (±25 Santri Putra) yang Hangat & Terpantau',
        'paragraf' => [
            'Kami sengaja membatasi penerimaan sekitar 25 santri putra agar pembinaan tidak berjarak. Di pondok yang bersahaja ini, setiap santri mendapat perhatian langsung dari para asatidz: mulai dari bangun sebelum Subuh, kedisiplinan shalat berjamaah, kelancaran tahsin Al-Qur’an, pemahaman kitab kuning, hingga etika pergaulan harian.',
            'Di tengah lingkungan kota Jakarta Timur, Nurul Ibad berupaya menjadi rumah kedua yang aman dan menenangkan, di mana santri putra belajar hidup mandiri, rukun dengan saudara sesama santri, serta dibekali pengenalan dasar komputer agar melek teknologi dengan adab yang kokoh.',
        ],
        'kutipan' => 'Pesantren bukan sekadar tempat transfer ilmu, melainkan tempat menempa hati, melatih adab kepada guru dan orang tua, serta menumbuhkan keikhlasan dalam beramal.',
        'sumber'  => 'Nasehat Almaghfurlah KH. Muhammad Syakrim, BA',
        'foto'    => 'images/tokoh/pendiri.jpg',
    ],

    'karakter' => [
        ['judul' => 'Tawassuth (Sikap Moderat)', 'isi' => 'Menghindari ifrath (berlebih-lebihan) dan tafrith (meremehkan), teguh dalam jalan tengah syariat.'],
        ['judul' => 'Tawazun (Keseimbangan)',    'isi' => 'Keseimbangan antara ilmu ukhrawi dan ilmu duniawi, antara ngaji Kitab Kuning dan mengenal komputer.'],
        ['judul' => 'Tasamuh & Ukhuwah',         'isi' => 'Mendidik santri putra saling menghargai, santun, dan kompak dalam persaudaraan di pondok.'],
        ['judul' => 'Al-Muhafadhotu ‘ala Qadimis Shalih', 'isi' => 'Menjaga tradisi pengajian Kitab Kuning yang luhur dan mengambil ilmu baru yang bermanfaat (literasi IT santri).'],
    ],

    'it' => [
        'label'  => 'Program Bimbingan Santri',
        'judul'  => 'Bimbingan Multimedia & Komputer Santri',
        'isi'    => 'Menjawab kebutuhan zaman secara bertahap dan bersahaja. Santri putra dibekali pemahaman dasar komputer, multimedia, dan etika digital, dengan tetap menempatkan pengajian Al-Qur’an dan Kitab Kuning sebagai poros utama pendidikan.',
        'porsi_judul' => 'Porsi Seimbang: Ngaji Tetap Utama',
        'porsi_isi'   => 'Karena pesantren kami berkapasitas sekitar 25 santri, belajar komputer dilakukan dalam kelompok kecil yang hangat dan terbimbing. Kami tidak menjanjikan fasilitas megah bertaraf industri, melainkan sarana belajar komputer yang bersahaja dan fungsional agar santri tidak gagap teknologi.',
        'porsi_poin'  => [
            'Jadwal bergantian teratur dan selalu didampingi asatidz pembina.',
            'Internet terfilter untuk menjaga santri dari dampak buruk dunia maya.',
            'Mengasah nalar berpikir runtut dan ketelitian santri putra.',
        ],
        'poin' => [
            ['judul' => '1. Adab & Literasi Digital Santri',   'isi' => 'Menanamkan etika berinternet, membedakan kabar bohong (tabayyun), serta membentengi diri dari pengaruh negatif game berlebihan, pornografi, dan judi online.', 'ikon' => '🛡️'],
            ['judul' => '2. Pengoperasian Komputer Dasar',     'isi' => 'Membiasakan santri mengoperasikan sistem operasi komputer, pengetikan rapi naskah Arab dan naskah Latin, serta pembuatan dokumen santri sederhana.', 'ikon' => '⌨️'],
            ['judul' => '3. Desain Grafis Sederhana Dakwah',   'isi' => 'Belajar dasar tata visual untuk membuat poster kutipan hadits, kata mutiara ulama, dan jadwal kegiatan pondok untuk melatih kreatifitas santri.', 'ikon' => '🎨'],
            ['judul' => '4. Dasar Logika & Wawasan Web',       'isi' => 'Mengenalkan alur berpikir logika (computational thinking) dan pengenalan dasar struktur halaman web bagi santri yang memiliki minat di bidang teknologi.', 'ikon' => '🌐'],
        ],
    ],

    'dewan' => [
        'judul' => 'Keteladanan, Kepemimpinan & Bimbingan',
        'isi'   => 'Amanah pendidikan berakar dari keteladanan almaghfurlah pendiri, diteruskan oleh kepemimpinan yayasan, serta dibimbing langsung oleh asatidz yang mendampingi keseharian santri putra secara intensif.',
        'pimpinan' => [
            ['nama' => 'KH. Muhammad Syakrim, BA', 'badge' => 'Almaghfurlah / Pendiri', 'peran' => 'Pendiri Pondok Pesantren Nurul Ibad',
             'isi' => 'Ulama kharismatik Jakarta Timur. Peletak pondasi sanad keilmuan, adab kesantrian, dan keteladanan perjuangan dakwah umat di Pondok Pesantren Nurul Ibad.',
             'foto' => 'images/tokoh/pendiri.jpg'],
            ['nama' => 'KH. Ibnu Mulkan Syakrim', 'badge' => 'Ketua Yayasan', 'peran' => 'Ketua Yayasan Nurul Ibad',
             'isi' => 'Memimpin arah pengembangan kelembagaan yayasan, mengawal kesinambungan nilai perjuangan pesantren, dan memfasilitasi pembinaan santri putra.',
             'foto' => 'images/tokoh/ketua-yayasan.jpg'],
        ],
        'asatidz' => [
            ['nama' => 'Ust. Bisrilhafi', 'peran' => 'Kitab Kuning & Tahfidz',
             'isi' => 'Membimbing pengajian Kitab Kuning (Fikih, Nahwu-Sharaf, Tauhid, Akhlak) dengan metode sorogan dan bandongan serta halaqah tahfidz Al-Qur’an santri harian.',
             'foto' => 'images/ustadz/bisrilhafi.jpg'],
            ['nama' => 'Ust. Rifki', 'peran' => 'Multimedia & IT',
             'isi' => 'Mendampingi santri belajar keterampilan komputer, multimedia, pengetikan rapi, serta pemahaman logika dasar teknologi santri harian setelah pengajian Kitab Kuning.',
             'foto' => 'images/ustadz/rifki.jpg'],
        ],
    ],

    'humas' => [
        'judul' => 'Tim Humas & Sekretariat Pondok',
        'isi'   => 'Untuk memudahkan bapak/ibu calon wali santri, silakan menghubungi ustadz pembina sesuai bidang kebutuhan informasi Anda. Kami siap melayani dialog ramah dan bersahaja.',
        'jam'   => 'Setiap Hari: 08.00 - 20.00 WIB',
        'orang' => [
            ['nama' => 'Ust. Mazen Firdaus', 'sapaan' => 'Ust. Zen',    'badge' => 'Humas & Pembinaan',
             'isi'  => 'Melayani konsultasi umum calon wali santri, informasi lingkungan pondok, serta koordinasi penerimaan santri baru.',
             'hp' => '0821-4277-3754', 'wa' => '6282142773754', 'foto' => 'images/ustadz/mazen.jpg',
             'pesan' => 'Assalamu’alaikum Warahmatullahi Wabarakatuh Ust. Zen, saya ingin bertanya terkait informasi pondok dan penerimaan santri baru di Nurul Ibad.'],
            ['nama' => 'Ust. Rifki', 'sapaan' => 'Ust. Rifki', 'badge' => 'Sekretariat & Multimedia IT',
             'isi'  => 'Mengurus administrasi pendaftaran santri baru, konfirmasi sisa kuota (kapasitas ±25 santri), infaq pendaftaran, serta pembimbing multimedia & IT santri.',
             'hp' => '0812-2197-8018', 'wa' => '6281221978018', 'foto' => 'images/ustadz/rifki.jpg',
             'pesan' => 'Assalamu’alaikum Warahmatullahi Wabarakatuh Ust. Rifki, saya ingin bertanya terkait pendaftaran santri baru dan bimbingan multimedia IT di Nurul Ibad.'],
            ['nama' => 'Ust. Taufiq', 'sapaan' => 'Ust. Taufiq', 'badge' => 'Asrama & Kunjungan',
             'isi'  => 'Bertanggung jawab atas ketertiban asrama santri putra, koordinasi survei kamar mukim, dan penerimaan kunjungan silaturahmi langsung wali santri.',
             'hp' => '0812-8398-5450', 'wa' => '6281283985450', 'foto' => 'images/ustadz/taufiq.jpg',
             'pesan' => 'Assalamu’alaikum Warahmatullahi Wabarakatuh Ust. Taufiq, saya ingin mengatur kunjungan silaturahmi dan survei asrama di Nurul Ibad.'],
        ],
    ],

    'infaq' => [
        'label' => 'Informasi Infaq & Pendaftaran',
        'judul' => 'Biaya Transparan & Penuh Semangat Kekeluargaan',
        'isi'   => 'Mengingat Pondok Pesantren Nurul Ibad berfokus pada pembinaan santri binaan terbatas (±25 santri), segala rincian infaq awal dan syahriah bulanan disampaikan secara transparan melalui musyawarah langsung dengan pihak sekretariat.',
        'kartu' => [
            [
                'judul' => 'Konsultasi Rincian Infaq & Syahriah', 'sub' => 'Langsung Terhubung dengan Sekretariat Pondok',
                'isi'   => 'Untuk mendapatkan rincian infaq perlengkapan, asrama, dan syahriah bulanan santri secara rinci, bapak/ibu calon wali santri dapat langsung menghubungi sekretariat via WhatsApp.',
                'poin'  => ['Rincian infaq transparan tanpa biaya tersembunyi', 'Penjelasan kebutuhan kitab dan seragam santri', 'Konfirmasi ketersediaan sisa kuota (±25 santri)'],
                'tombol'=> 'Tanya Rincian Biaya via WhatsApp',
                'pesan' => 'Assalamu’alaikum Warahmatullahi Wabarakatuh Ust. Rifki, mohon informasi rincian infaq dan syahriah santri di Nurul Ibad.',
                'ikon'  => '📄',
            ],
            [
                'judul' => 'Silaturahmi & Dialog Terbuka', 'sub' => 'Kunjungan Langsung ke Pondok Pesantren',
                'isi'   => 'Kami sangat mengapresiasi orang tua atau calon wali santri untuk datang bersilaturahmi langsung. Dengan melihat langsung suasana asrama yang tenang dan berdialog dengan pengasuh, orang tua dapat merasa lebih mantap menitipkan putranya.',
                'poin'  => ['Melihat langsung asrama santri dan sarana ngaji', 'Dialog ramah tamah bersama dewan asatidz', 'Pelayanan kunjungan setiap hari 08.00 - 17.00 WIB'],
                'tombol'=> 'Atur Jadwal Kunjungan ke Pondok',
                'pesan' => 'Assalamu’alaikum Warahmatullahi Wabarakatuh Ust. Rifki, saya ingin mengatur jadwal kunjungan silaturahmi ke Nurul Ibad.',
                'ikon'  => '🤝',
            ],
        ],
    ],

    'psb' => [
        'label' => 'Penerimaan Santri Baru (PSB)',
        'judul' => 'Alur Pendaftaran Santri Baru',
        'isi'   => 'Untuk menjaga mutu bimbingan adab dan pengawasan asrama yang dekat, kami hanya menerima sekitar 25 santri putra. Silakan mengisi data awal berikut atau langsung menghubungi panitia melalui WhatsApp.',
        'langkah' => [
            ['judul' => 'Konsultasi / Isi Form',       'isi' => 'Isi data awal santri atau chat panitia via WhatsApp untuk cek kuota.'],
            ['judul' => 'Silaturahmi ke Pondok',       'isi' => 'Wali santri dan calon santri datang langsung melihat suasana pondok.'],
            ['judul' => 'Wawancara & Pemetaan',        'isi' => 'Melihat bacaan Al-Qur’an dan kesiapan santri tinggal di asrama.'],
            ['judul' => 'Daftar Ulang & Mukim',        'isi' => 'Penetapan kamar asrama, pembagian kitab, dan santri mulai menetap.'],
        ],
        'tingkat' => ['Usia SD/MI', 'Usia SMP/MTs', 'Usia SMA/MA', 'Lulusan SMA/MA', 'Lainnya'],
    ],

    'kunjungan' => [
        'judul' => 'Silaturahmi & Kunjungan Langsung',
        'isi'   => 'Kami menyambut hangat kedatangan bapak/ibu calon wali santri untuk melihat langsung kehidupan asrama, sarana ibadah, dan lingkungan belajar di Pondok Pesantren Nurul Ibad.',
    ],
];