<?php namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Helpers\BaseHelper;
use Illuminate\Support\Facades\Schema;

class CateringRepository
{

    public function createCatering($data)
    {
        $timPic = auth()->user()->tim_pic;

        $tableMapping = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PROD' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'A1' => 'mk_mess_a1',
            'C3' => 'mk_mess_c3',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
        ];

        foreach (range(1, 10) as $i) {
            $tableMapping["B$i"] = "mk_mess_b{$i}";
        }
        if (!array_key_exists($timPic, $tableMapping)) {
            return response()->json(['error' => 'Tabel tidak ditemukan untuk tim_pic ini'], 400);
        }
        $table = $tableMapping[$timPic];

        $tableColumns = Schema::getColumnListing($table);

        $insertData = [
            'created_name' => auth()->user()->id,
            'create_at' => now(),
        ];

        foreach ($tableColumns as $column) {
            if (isset($data[$column . '_add'])) {
                $insertData[$column] = $data[$column . '_add'];
            }
        }
        return DB::table($table)->insert($insertData);
    }

    public function authenticate(array $credentials)
    {

        $mk_coe = DB::table('mk_coe')->where('mk_coename', $credentials['mk_coename'])->first();

        if ($mk_coe && $this->verifyPassword($credentials['password'], $mk_coe->password)) {
            return true;
        }

        return false;
    }

    protected function verifyPassword($password, $hashedPassword)
    {
        $sqlServerHash = hash('sha256', $password);
        return $sqlServerHash === $hashedPassword;
    }

    public function getData()
    {
        $userTeam = auth()->user()->tim_pic;

        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PROD' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'A1' => 'mk_mess_a1',
            'C3' => 'mk_mess_c3',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[$userTeam] ?? 'mk_coe';

        $columns = Schema::getColumnListing($table);

        $excludedColumns = ['id', 'tanggal', 'waktu', 'create_at', 'created_name','status'];

        // Filter hanya kolom yang tidak ada dalam daftar pengecualian
        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        $totalExpression = implode(' + ', array_map(function ($col) {
            return "COALESCE($col, 0)";
        }, $numericColumns));

        return DB::table($table)
            ->select(
                'id',
                'tanggal',
                'created_name',
                'waktu',
                'status',
                DB::raw("($totalExpression) AS total")
            )
            ->orderBy('create_at', 'DESC')
            ->get();
    }

    public function deleteFromTable($tableName, $selectedUserId)
    {
        try {
            DB::table($tableName)->where('id', $selectedUserId)->delete();
            return 'Data berhasil dihapus.';
        } catch (\Exception $e) {
            return 'Gagal menghapus data dari ' . $tableName . ': ' . $e->getMessage();
        }
    }

    public function getById($id)
    {
        $userTeam = auth()->user()->tim_pic;

        $tableMappings = [
            'COE' => 'mk_coe',
            'HCGA' => 'mk_hcga',
            'ENG' => 'mk_eng',
            'SHE' => 'mk_she',
            'FALOG' => 'mk_falog',
            'PROD' => 'mk_prod',
            'PLANT' => 'mk_plant',
            'A1' => 'mk_mess_a1',
            'C3' => 'mk_mess_c3',
            'MESS_MEICU' => 'mk_mess_meicu',
            'MESS_PUTRI' => 'mk_mess_putri',
        ];

        foreach (range(1, 10) as $i) {
            $tableMappings["B$i"] = "mk_mess_b{$i}";
        }

        $table = $tableMappings[$userTeam] ?? 'mk_coe';

        $columns = Schema::getColumnListing($table);

        $excludedColumns = ['id', 'tanggal', 'waktu', 'create_at', 'created_name'];

        $numericColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        $totalExpression = implode(' + ', array_map(function ($col) {
            return "COALESCE($col, 0)";
        }, $numericColumns));

        return DB::table($table)
            ->select(
                'id',
                'tanggal',
                'created_name',
                'waktu',
                DB::raw("($totalExpression) AS total"),
                ...$columns
            )
            ->where('id', $id)
            ->first();
    }


    public function edit($data, $id)
    {
        return DB::table('mk_coe')
            ->where('id', $id)
            ->update([
                'nrp' => $data['nrp'],
                'nama' => $data['nama'],
                'mk_coename' => $data['mk_coename'],
                'email' => $data['email'],
                'dept' => $data['dept'],
                'no_hp' => $data['no_hp'],
                'perusahaan' => $data['perusahaan'],
                'id_role' => $data['id_role'],
            ]);
    }

    public function editProfile($data, $id)
    {
        try {
            DB::table('mk_coe')
                ->where('id', $id)
                ->update([
                    'nrp' => $data['nrp'],
                    'nama' => $data['name'],
                    'mk_coename' => $data['mk_coename'],
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
