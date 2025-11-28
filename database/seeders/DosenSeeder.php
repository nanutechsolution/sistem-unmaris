<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        // DATA ASLI DARI EXCEL
        $data_dosens = [
            ['812069101','6944769670130360','ADELBERTUS UMBU JANGA','S1 Teknik Informatika','L','Madidi Pala Medu, 12 June 1991','Katolik'],
            ['1520089801','4152776677230110','AGNESTIA MEDELIN RAMBU ATA RATU','S1 Pendidikan Teknologi Informasi','P','Tatunggu, 20 August 1998','Kristen'],
            ['1520088601','6152764665230310','AGUSTINA PURNAMI SETIAWI','S1 Teknik Lingkungan','P','Denpasar, 20 August 1986','Katolik'],
            ['802046404','734742643130122','ALEXANDER ADIS','D3 Manajemen Informatika','L','HOELEA, 2 April 1964','Katolik'],
            ['803048301','4735761662130280','ALEXANDER TALO POPO','S1 Teknik Lingkungan','L','Waikabubak, 3 April 1983','Katolik'],
            ['1525058801','857766667137072','ALOYSIUS GREGORIUS BORA','S1 Bisnis Digital','L','Weetabula, 25 May 1988','Katolik'],
            [null,'1836770671230390','ANASTASIA YASHINTA THEEDENS','S1 Keselamatan dan Kesehatan Kerja','P','weetabula, 4 May 1992','Katolik'],
            ['1519019201','6451770671130290','ANDERIAS DENDO','S1 Teknik Lingkungan','L','Waikabubak, 19 January 1992','Kristen'],
            ['803068301','9935761662130220','ANDREAS ARIYANTO RANGGA','S1 Teknik Informatika','L','Maumere, 3 June 1983','Katolik'],
            ['1523019501','2455773674130220','ANDRY ANANDA PUTRA TANGGU MARA','S1 Pendidikan Teknologi Informasi','L','Wangga, 23 January 1995','Kristen'],
            ['828028702',null,'ANJELA GREZARIA DJOENG','S1 Teknik Informatika','P','kupang, 28 February 1987','Katolik'],
            ['1504068901','9936767668130340','ANTAR MARAMBA JAWA','D3 Manajemen Informatika','L','LAWONDA, 4 June 1989','Kristen'],
            ['1518129102','6550769670130270','ANTONIUS MBAY NDAPAMURI','S1 Pendidikan Teknologi Informasi','L','Mauliru, 18 December 1991','Katolik'],
            ['1519018601','2451764665130200','ARDIYANTO DAPADEDA','S1 Teknik Informatika','L','Waikabubak, 19 January 1986','Katolik'],
            ['9990627482','6153770671130290','BENEDIKTUS DALUPE','S1 Bisnis Digital','L','Waikabubak, 21 August 1992','Katolik'],
            ['1508089401','8140772673130340','BEWA DANGU WOLE','S1 Administrasi Rumah Sakit','L','Tarung, 8 August 1994','Kristen'],
            ['811028401','9543762663231050','CECILIA DAI PAYON BINTI GABRIEL','S1 Teknik Informatika','P','LAHAD DATU, 11 February 1984','Katolik'],
            ['9908420006',null,'DANIEL DIMA KAKA','S1 Teknik Informatika','L','Bukambero, 8 October 1985','Kristen'],
            ['811058902',null,'DAVID KADI','S1 Teknik Informatika','L','Radamata, 11 May 1989','Katolik'],
            ['1514129301','6546771672230270','DESI ERNAWATI LENDE','S1 Keselamatan dan Kesehatan Kerja','P','Kalebu Uta Podu, 14 December 1993','Kristen'],
            ['1512129401','544772673230393','DETRIANA IMERIET NENOBAIS','S1 Administrasi Rumah Sakit','P','Kie, 12 December 1994','Kristen'],
            ['1529109301','7361771672230230','DIAN FRANSISKA LEDI','S1 Pendidikan Teknologi Informasi','P','wanukaka, 29 October 1993','Kristen'],
            ['1511059501','4843773674230270','DIANA REBY SABAWALY','S1 Teknik Lingkungan','P','TAMA AU, 11 May 1995','Kristen'],
            ['9990320234','2449758659130150','DIDIK HADI SANTOSO','S1 Administrasi Rumah Sakit','L','Blitar, 17 January 1980','Kristen'],
            ['802068402',null,'EDO VICTORIO KOSASI','S1 Teknik Informatika','L','Surabaya, 2 June 1984','Katolik'],
            ['1516039401','7648772673230260','ELFIRA UMAR','D3 Manajemen Informatika','P','Metinumba, 16 March 1994','Islam'],
            ['819118701',null,'ELISABETH AGNES LISYE','D3 Manajemen Informatika','P','Jakarta, 19 November 1987','Katolik'],
            ['1511089001','2143768669230310','EMIRENSIANA DAPPA EGE','D3 Manajemen Informatika','P','Mareda Wuni, 11 August 1990','Katolik'],
            ['831077901','3063757658220000','FELYSITAS EMA OSE SANGA','D3 Manajemen Informatika','P','Waingapu, 31 July 1979','Katolik'],
            ['1511118001',null,'FERIANTO BANI','D3 Manajemen Informatika','L','Sumba Barat, 11 November 1980','Kristen'],
            ['1523029601','5555774675230200','FERNINCE INA POTE','S1 Teknik Lingkungan','P','Wulla, 23 February 1996','Kristen'],
            ['830117901','1462757658130130','FRIDEN ELEFRI NENO','S1 Teknik Informatika','L','Kretan, 30 November 1979','Kristen'],
            ['809128001','5541758659130170','GERGORIUS KOPONG PATI','S1 Teknik Informatika','L','LAMAWOLO, 9 December 1980','Katolik'],
            ['1520039101','9652769670130320','HERMAN HUKI RATU','S1 Teknik Informatika','L','Weetobula, 20 March 1991','Kristen'],
            ['1522129601','9554774675230170','I GUSTI AGUNG KD DESY PURNAMA DEWI','S1 Keselamatan dan Kesehatan Kerja','P','Waingapu, 22 December 1996','Hindu'],
            ['819128904','4551767668130310','KAROLUS WULLA RATO','S1 Bisnis Digital','L','Kalembu Weri, 19 December 1989','Katolik'],
            ['1506069201','6938770671230400','KATARINA YUNITA RITI','S1 Bisnis Digital','P','PABONDO DIMU, 6 June 1992','Katolik'],
            [null,'6659763664230280','KATHARINA FRANSISKA FERNANDEZ','S1 Keselamatan dan Kesehatan Kerja','P','Kupang, 27 March 1985','Katolik'],
            ['9908420032','1536766667230260','KHAIRUNISAH FEBRIANY','S1 Teknik Informatika','P','Waikabubak, 4 February 1988','Islam'],
            ['803088801','2142766667130440','LEO TRISNO MIA TAKE','S1 Teknik Lingkungan','L','Pledo, 10 August 1988','Katolik'],
            ['1523049401','5755772673230260','LIDIA LALI MOMO','D3 Manajemen Informatika','P','Wolla Baku, 23 April 1994','Kristen'],
            ['1518099801','250776677230123','MARIA KATARINA UMITI PEUUMA','S1 Teknik Lingkungan','P','Kupang, 18 September 1998','Katolik'],
            ['1527059501','7859773674230250','MARIA WILDA MALO','S1 Bisnis Digital','P','Waikabubak, 27 May 1995','Katolik'],
            [null,'6238773674230260','MARLINA ATA KUPANG','S1 Administrasi Rumah Sakit','P','Kadumbul, 6 September 1995','Katolik'],
            ['823038101',null,'MARTINUS MALO NGONGO','D3 Manajemen Informatika','L','Weekadota, 23 March 1981','Katolik'],
            [null,'6841773674230350','MERIANA LENDE','S1 Teknik Informatika','P','WEE PATANDO, 9 May 1995','Kristen'],
            ['823127301',null,'MERY RINANDES CHRISTIMAS MESAH','S1 Teknik Informatika','P','Kupang, 23 December 1973','Kristen'],
            ['801119402','4433772673230270','MITRA PERMATA AYU','S1 Pendidikan Teknologi Informasi','P','Waikabubak, 1 November 1994','Islam'],
            [null,'4835777678230130','MONIKA BELA ZAGHU','S1 Keselamatan dan Kesehatan Kerja','P','Tambolaka, 3 May 1999','Katolik'],
            ['827048804','9759766667131100','NOLDY F. J. BLEGUR','S1 Teknik Lingkungan','L','TIMOR-TIMUR, 27 April 1988','Kristen'],
            ['816069201','8948770671230380','NOVIA SARI WATI STORY','D3 Manajemen Informatika','P','Pero, 16 June 1992','Islam'],
            [null,'4447776677230160','NOVIANA MARTHA DIMU','S1 Bisnis Digital','P','RATE PEKA, 15 November 1998','Kristen'],
            ['1528109001','3360768669230290','OLVIANA TAMO INA','S1 Pendidikan Teknologi Informasi','P','Omba Rade, 28 October 1990','Kristen'],
            ['825089002',null,'PARWIRA AGUSFIA','S1 Teknik Informatika','L','Padang, 25 August 1990','Islam'],
            ['812038402','5644762663137000','PAULUS MIKKU ATE','S1 Pendidikan Teknologi Informasi','L','Marokota, 12 March 1984','Katolik'],
            ['802019101','6434769670237000','RAMBU RIRINSIA HARRA HAU','S1 Teknik Lingkungan','P','MAUMERE, 2 January 1991','Kristen'],
            ['1501059301','2833771672230360','ROSWITA SARI KAKA','S1 Bisnis Digital','P','Weekombaka, 1 May 1993','Katolik'],
            ['1518039001','1650768669130300','SAMUEL BORA LERO','S1 Administrasi Rumah Sakit','L','Kalembutadei, 18 March 1990','Kristen'],
            ['1502019501','6434773674130270','SIHANG GREGORIUS BALIMEMA','S1 Administrasi Rumah Sakit','L','Waingapu, 2 January 1995','Katolik'],
            [null,'3137770671130340','SOLEMAN RENDA BILI','S1 Keselamatan dan Kesehatan Kerja','L','Puu Timu, 5 August 1992','Katolik'],
            ['1508099601','3240774675130210','STEFANUS DWI ISTIAVAN MAU','S1 Teknik Informatika','L','Salatiga, 8 September 1996','Katolik'],
            ['1516088901',null,'STEFANUS HIDE AMUNTODA','S1 Keselamatan dan Kesehatan Kerja','L','Kupang, 16 August 1989','Katolik'],
            ['1509039701','6641775676130140','TITUS KURRA','S1 Pendidikan Teknologi Informasi','L','Puu Niu, 9 March 1997','Katolik'],
            ['824079301','4056771672130250','TRISNO','S1 Teknik Informatika','L','Pemana, 24 July 1993','Islam'],
            ['1530049201','3762770671130270','VINSENSIUS APRILA KORE DIMA','S1 Pendidikan Teknologi Informasi','L','Kalumbang, 30 April 1992','Katolik'],
            ['9908420039',null,'WALTERIUS ARFAN LAKA.S.S','D3 Manajemen Informatika','L','Ende, 29 April 1983','Katolik'],
            [null,'2942770671130450','YOSITHO RATO KAMEO','S1 Administrasi Rumah Sakit','L','Waikabubak, 10 June 1992','Kristen'],
            ['1523068201','4955760661130200','YULIUS NAHAK TETIK','S1 Teknik Informatika','L','Weoe, 23 June 1982','Katolik'],
        ];

        // 1. Load Semua ID Prodi ke dalam Array supaya proses cepat (Caching)
        // Kita ubah formatnya jadi: ['nama_prodi' => id]
        // Contoh: ['Teknik Informatika' => 1, 'Bisnis Digital' => 7]
        $mapProdi = DB::table('program_studis')->pluck('id', 'nama_prodi')->toArray();

        foreach ($data_dosens as $row) {
            // 2. Bersihkan Nama Prodi dari Excel agar cocok dengan Database
            // Di Excel: "S1 Teknik Informatika" -> Kita mau: "Teknik Informatika"
            $namaProdiExcel = $row[3];
            
            // Hapus prefix "S1 " atau "D3 " atau "-- " jika ada
            $namaProdiBersih = preg_replace('/^(S1|D3|--)\s+/', '', $namaProdiExcel);
            $namaProdiBersih = trim($namaProdiBersih);

            // 3. Ambil ID dari Map yang sudah kita buat
            $prodi_id = $mapProdi[$namaProdiBersih] ?? null;

            // Jika masih null (misal ada typo di excel), set ke null biar gak error
            // Atau bisa dibuat fallback manual jika perlu

            // 4. Parsing Tanggal Lahir (Sama seperti sebelumnya)
            $ttl_raw = explode(',', $row[5]);
            $tempat_lahir = trim($ttl_raw[0]); 
            $tanggal_lahir_str = isset($ttl_raw[1]) ? trim($ttl_raw[1]) : null;
            $tanggal_lahir = null;

            if ($tanggal_lahir_str) {
                try {
                    $tanggal_lahir = Carbon::createFromFormat('j F Y', $tanggal_lahir_str)->format('Y-m-d');
                } catch (\Exception $e) {
                    $tanggal_lahir = null;
                }
            }

            // 5. Simpan data
            DB::table('dosens')->updateOrInsert(
                ['nama_lengkap' => $row[2]], 
                [
                    'nidn' => $row[0], 
                    'nuptk' => $row[1],
                    'program_studi_id' => $prodi_id, // Ini sekarang pakai ID asli dari tabel program_studis
                    'jenis_kelamin' => $row[4],
                    'tempat_lahir' => $tempat_lahir,
                    'tanggal_lahir' => $tanggal_lahir,
                    'agama' => $row[6],
                    'status_kepegawaian' => 'Aktif',
                    'email' => null, 
                    'no_hp' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}