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
        $ph = intval($data['ph']);

        $existingRecord = DB::table('ph_air')->whereDate('tanggal', $tanggal)->first();

        if ($existingRecord) {
            $oldPh = $existingRecord->$lokasi;

            if ($oldPh !== null) {
                $newPh = intval(round(($oldPh + $ph) / 2));
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


    public function delete($phUserId )
    {
        try {
            DB::table('ph_air')->where('id', $phUserId )->delete();
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

    public function edit($data, $id)
    {
        try {
            $lokasi = $data['lokasi'];
            $ph = intval($data['ph']);

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
