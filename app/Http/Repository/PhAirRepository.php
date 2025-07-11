<?php namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\BaseHelper;

class PhAirRepository
{

    public function createData(array $data)
    {
    try {
        $nrp = auth()->user()->nrp;
        $tanggal = $data['tanggal'];
        $lokasi = $data['lokasi'];
        $ph = $data['ph'];

        $existingRecord = DB::table('ph_air')->whereDate('tanggal', $tanggal)->first();

        if ($existingRecord) {
            $oldPh = $existingRecord->$lokasi;

            if ($oldPh !== null) {
                $newPh = ($oldPh + $ph) / 2;
            } else {
                $newPh = $ph;
            }

            $update = DB::table('ph_air')
                ->where('id', $existingRecord->id)
                ->update([$lokasi => $newPh]);

            if ($update) {
                return $existingRecord->id;
            } else {
                throw new \Exception("Gagal mengupdate data.");
            }
        } else {
            $newData = [
                'nrp' => $nrp,
                'tanggal' => $tanggal,
                'MESS' => null,
                'WT' => null,
                'WTP' => null,
                'STP' => null,
                'PIT_1' => null,
                'PIT_2' => null,
                'PIT_3' => null,
                'WORKSHOP' => null,
                'WAREHOUSE' => null,
                'OFFICE_PLANT' => null,
                $lokasi => $ph
            ];

            $insertId = DB::table('ph_air')->insertGetId($newData);

            if ($insertId) {
                return $insertId;
            } else {
                throw new \Exception("Gagal menyimpan data.");
            }
        }
    } catch (\Exception $e) {

        return false;
    }
    }

    public function createDataDosing(array $data)
    {
        try {
            $nrp     = auth()->user()->nrp;
            $tanggal = $data['tanggal'];

            $newData = [
                'nrp'           => $nrp,
                'tanggal'       => $tanggal,
                'shift'        => $data['shift'],
                'lokasi'        => $data['lokasi_dosing'],
                'jenis'        => $data['jenis'],
                'meter_awal'    => $data['meter_awal'],
                'meter_akhir'   => $data['meter_akhir'], 
            ];

            $insertId = DB::table('ph_air_dosing')->insertGetId($newData);

            if ($insertId) {
                return $insertId;
            } else {
                throw new \Exception("Gagal menyimpan data.");
            }

        } catch (\Exception $e) {
            return false;
        }
    }

    public function createDataDosingPac(array $data)
    {
       
        try {
            $nrp     = auth()->user()->nrp;
            $tanggal = $data['tanggal_dosing_pac'];

            $newData = [
                'nrp'           => $nrp,
                'tanggal'       => $tanggal,
                'shift'         => $data['shift_pac'],
                'lokasi'        => $data['lokasi_dosing_pac'],
                'pac'          => $data['pac'],
                'kaporit'    => $data['kaporit'],
                'soda_ash'   => $data['soda'], 
            ];

            $insertId = DB::table('ph_air_dosing_pac')->insertGetId($newData);

            if ($insertId) {
                return $insertId;
            } else {
                throw new \Exception("Gagal menyimpan data.");
            }

        } catch (\Exception $e) {
            return false;
        }
    }

    public function getMeterAkhirShiftSiang($tanggal, $lokasi, $jenis)
    {
        return DB::table('ph_air_dosing')
            ->where('tanggal', $tanggal)
            ->where('lokasi', $lokasi)
            ->where('jenis', $jenis)
            ->where('shift', 'Siang')
            ->orderByDesc('id')
            ->first();
    }

    public function getData()
    {
        return DB::table('ph_air')
            ->join('users', 'ph_air.nrp', '=', 'users.nrp')
            ->select(
                'ph_air.*',
                'users.nama'
            )
            ->orderBy('ph_air.tanggal', 'desc')
            ->get();
    }

    public function getDataDosing(string $jenis)
    {
        return DB::table('ph_air_dosing')
            ->join('users', 'ph_air_dosing.nrp', '=', 'users.nrp')
            ->select(
                'ph_air_dosing.*',
                'users.nama'
            )
            ->where('jenis', $jenis)
            ->orderBy('ph_air_dosing.tanggal', 'desc')
            ->get();
    }

    public function getDataDosingPac()
    {
        return DB::table('ph_air_dosing_pac')
            ->join('users', 'ph_air_dosing_pac.nrp', '=', 'users.nrp')
            ->select(
                'ph_air_dosing_pac.*',
                'users.nama'
            )
            ->orderBy('ph_air_dosing_pac.tanggal', 'desc')
            ->get();
    }

    public function delete($phUserId )
    {
        try {
            DB::table('ph_air')->where('id', $phUserId )->delete();
            return 'Data Berhasil dihapus.';
        } catch (\Exception $e) {
            return 'Gagal menghapus data: ' . $e->getMessage();
        }
    }

    public function deleteDosing($dosingId)
    {
        try {
            DB::table('ph_air_dosing')->where('id', $dosingId )->delete();
            return 'Data Berhasil dihapus.';
        } catch (\Exception $e) {
            return 'Gagal menghapus data: ' . $e->getMessage();
        }
    }

    public function deleteDosingPac($dosingId)
    {
        try {
            DB::table('ph_air_dosing_pac')->where('id', $dosingId )->delete();
            return 'Data Berhasil dihapus.';
        } catch (\Exception $e) {
            return 'Gagal menghapus data: ' . $e->getMessage();
        }
    }

    public function getById($id)
    {
        $data = DB::table('ph_air')
            ->join('users', 'ph_air.nrp', '=', 'users.nrp')
                ->select(
                    'ph_air.*',
                    'users.nama'
                )
            ->where('ph_air.id', $id)
            ->first();

        return $data;
    }

     public function getByIdDosing($id)
    {
        $data = DB::table('ph_air_dosing')
            ->join('users', 'ph_air_dosing.nrp', '=', 'users.nrp')
                ->select(
                    'ph_air_dosing.*',
                    'users.nama'
                )
            ->where('ph_air_dosing.id', $id)
            ->first();

        return $data;
    }

    public function getByIdDosingPac($id)
    {
        $data = DB::table('ph_air_dosing_pac')
            ->join('users', 'ph_air_dosing_pac.nrp', '=', 'users.nrp')
                ->select(
                    'ph_air_dosing_pac.*',
                    'users.nama'
                )
            ->where('ph_air_dosing_pac.id', $id)
            ->first();

        return $data;
    }

    public function edit($data, $id)
    {
        try {
            $lokasi = $data['lokasi'];
            $ph = $data['ph'];

            $existingRecord = DB::table('ph_air')->where('id', $id)->first();

            if (!$existingRecord) {
                throw new \Exception("Data tidak ditemukan untuk ID: $id");
            }

            $update = DB::table('ph_air')
                ->where('id', $id)
                ->update([$lokasi => $ph]);

            if ($update) {
                return true;
            } else {
                throw new \Exception("Gagal memperbarui data.");
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function editDosing(array $data, $id)
    {
        try {
            $nrp     = auth()->user()->nrp;
            $tanggal = $data['tanggal_dosing'];

            $newData = [
                'nrp'         => $nrp,
                'tanggal'     => $tanggal,
                'lokasi'      => $data['lokasi_dosing'],
                'meter_awal'  => $data['meter_awal'],
                'meter_akhir' => $data['meter_akhir'],
                'shift'       => $data['shift'],
                'jenis'       => $data['jenis'],
                
            ];

            $update = DB::table('ph_air_dosing')
                ->where('id', $id)
                ->update($newData);

            if ($update) {
                return true;
            } else {
                throw new \Exception("Gagal memperbarui data.");
            }

        } catch (\Exception $e) {
            return false;
        }
    }

    public function editDosingPac(array $data, $id)
    {
        try {
            $nrp     = auth()->user()->nrp;
            $tanggal = $data['tanggal_dosing_pac'];

            $newData = [
                'nrp'         => $nrp,
                'tanggal'     => $tanggal,
                'lokasi'      => $data['lokasi_dosing_pac'],
                'pac'         => $data['pac'],
                'kaporit'     => $data['kaporit'],
                'shift'       => $data['shift_pac'],
                'soda_ash'    => $data['soda'],
                
            ];

            $update = DB::table('ph_air_dosing_pac')
                ->where('id', $id)
                ->update($newData);

            if ($update) {
                return true;
            } else {
                throw new \Exception("Gagal memperbarui data.");
            }

        } catch (\Exception $e) {
            return false;
        }
    }

    public function editProfile($data, $id)
    {
        try {
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'nrp' => $data['nrp'],
                    'nama' => $data['name'],
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'dept' => $data['departemen'],
                    'perusahaan' => $data['perusahaan'],
                    'no_hp' => $data['phone_number'],
                    'baju' => $data['baju'],
                    'celana' => $data['celana'],
                    'rompi' => $data['rompi'],
                    'sepatu' => $data['sepatu'],
                ]);

            return ['status' => 'success'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getPhAirData($tanggalAwal, $tanggalAkhir)
    {
        $data = DB::table('ph_air')
            ->select(
                'tanggal',
                DB::raw('MAX(MESS) as MESS'),
                DB::raw('MAX(WT) as WT'),
                DB::raw('MAX(WTP) as WTP'),
                DB::raw('MAX(STP) as STP'),
                DB::raw('MAX(PIT_1) as PIT_1'),
                DB::raw('MAX(PIT_2) as PIT_2'),
                DB::raw('MAX(PIT_3) as PIT_3'),
                DB::raw('MAX(WORKSHOP) as WORKSHOP'),
                DB::raw('MAX(WAREHOUSE) as WAREHOUSE'),
                DB::raw('MAX(OFFICE_PLANT) as OFFICE_PLANT')
            )
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        return $data->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'lokasi' => [
                    'MESS' => $item->MESS,
                    'WT' => $item->WT,
                    'WTP' => $item->WTP,
                    'STP' => $item->STP,
                    'PIT_1' => $item->PIT_1,
                    'PIT_2' => $item->PIT_2,
                    'PIT_3' => $item->PIT_3,
                    'WORKSHOP' => $item->WORKSHOP,
                    'WAREHOUSE' => $item->WAREHOUSE,
                    'OFFICE_PLANT' => $item->OFFICE_PLANT,
                ]
            ];
        });
    }

//     public function getPhAirDataPer($tanggalAwal, $tanggalAkhir, $lokasi)
// {
//     $data = DB::table('ph_air')
//         ->select('tanggal', DB::raw("MAX($lokasi) as pH"))
//         ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
//         ->groupBy('tanggal')
//         ->orderBy('tanggal', 'asc')
//         ->get();

//     return $data->map(function ($item) {
//         return [
//             'tanggal' => $item->tanggal,
//             'pH' => $item->pH,
//         ];
//     });
// }

public function getPhAirDataPer($tanggalAwal, $tanggalAkhir, $lokasi)
{
    $data = DB::table('ph_air')
        ->select('tanggal', DB::raw("MAX($lokasi) as pH"))
        ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'asc')
        ->get();

    // Hitung rata-rata pH dari semua data yang diambil
    $rataRata = $data->avg('pH');

    return [
        'dataHarian' => $data->map(function ($item) {
            return [
                'tanggal' => $item->tanggal,
                'pH' => $item->pH,
            ];
        }),
        'rataRata' => round($rataRata, 2) // Bulatkan ke 2 desimal
    ];
}





}
