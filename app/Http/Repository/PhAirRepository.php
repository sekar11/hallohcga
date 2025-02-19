<?php namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\BaseHelper;

class PhAirRepository
{

    public function createData(array $data)
    {
        $data['nrp'] = auth()->user()->nrp;
        $phAir = DB::table('phair')->insertGetId($data);

        return $phAir;
    }

    public function getData()
    {
        return DB::table('phair')
            ->join('users', 'phair.nrp', '=', 'users.nrp')
            ->select(
                'phair.*',
                'users.nama'
            )
            ->orderBy('phair.tanggal', 'desc')
            ->get();
    }
    

    public function delete($phUserId )
    {
        try {
            DB::table('phair')->where('id', $phUserId )->delete();
            return 'Data Berhasil dihapus.';
        } catch (\Exception $e) {
            return 'Gagal menghapus data: ' . $e->getMessage();
        }
    }

    public function getById($id)
    {
        $data = DB::table('phair')
            ->join('users', 'phair.nrp', '=', 'users.nrp')
                ->select(
                    'phair.*',
                    'users.nama'
                )
            ->where('phair.id', $id)
            ->first();

        return $data;
    }

    public function edit($data, $id)
    {
        return DB::table('phair')
            ->where('id', $id)
            ->update([
                'lokasi' => $data['lokasi'],
                'area' => $data['area'] ?? null,
                'ph' => $data['ph'],
            ]);
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

}
