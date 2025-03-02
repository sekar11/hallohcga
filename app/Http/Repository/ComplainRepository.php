<?php

namespace App\Http\Repository;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\BaseHelper;

use function Ramsey\Uuid\v1;

Class ComplainRepository
{

    public function getAllWithUsername()
    {
        $query = DB::table('complain')
        ->join('users', 'complain.nrp', '=', 'users.nrp')
        ->select('complain.*', 'users.nama as nama', 'users.dept as departemen', 'users.tim_pic')
        ->orderBy('created_on', 'desc');

    $userRole = auth()->user()->id_role;
    $userNrp = auth()->user()->nrp;
    $userNama = auth()->user()->nama;
    $userTimPIC = auth()->user()->tim_pic;

    if ($userRole == 1 || $userRole == 5) {
        $query->where('complain.nrp', $userNrp);
    }

    if ($userRole == 2) {
        $query->where(function ($subQuery) use ($userNama, $userNrp, $userTimPIC) {
            $subQuery->where('complain.crew_pic', '=', $userNama)
                ->orWhere('complain.created_name', '=', $userNrp);

            if (!empty($userTimPIC)) {

                $teamMembers = DB::table('users')
                    ->where('tim_pic', '=', $userTimPIC)
                    ->pluck('nama')
                    ->toArray();

                if (!empty($teamMembers)) {
                    $subQuery->orWhereIn('complain.crew_pic', $teamMembers);
                }
            }
        });
    }

        $data = $query->get();

        foreach ($data as $complain) {
            $submissionDate = !empty($complain->created_on) ? strtotime(date('Y-m-d', strtotime($complain->created_on))) : null;
            $dueDate = !empty($complain->due_date) ? strtotime(date('Y-m-d', strtotime($complain->due_date))) : null;
            $approvalDate = !empty($complain->approval_on) ? strtotime(date('Y-m-d', strtotime($complain->approval_on))) : null;
            $today = strtotime(date('Y-m-d'));

            $endDate = $approvalDate ?? $today;

            $complain->days_worked = $submissionDate ? floor(($endDate - $submissionDate) / (60 * 60 * 24)) + 1 : '-';

            // var_dump($submissionDate, $approvalDate, $dueDate, $endDate);

            if (!$submissionDate) {
                $complain->status = 'unknown';
                $complain->badge_class = 'bg-secondary';
            }

            elseif ($approvalDate && $approvalDate === $submissionDate) {
                $complain->status = 'ontime';
                $complain->badge_class = 'bg-success';
            }
            elseif ($dueDate && $endDate > $dueDate) {
                $complain->status = 'late';
                $complain->badge_class = 'bg-danger';
            }
            else {
                $complain->status = 'ontime';
                $complain->badge_class = 'bg-success';
            }
        }


        return $data;
    }

    public function getUserLevel2()
    {
        return DB::table('users')
        ->whereIn('id_role', [2, 4])
        ->get();
    }

    public function getById($id)
    {
        $data = DB::table('complain')
            ->join('users', 'complain.nrp', '=', 'users.nrp')
            ->where('complain.id', $id)
            ->first(['complain.*', 'users.nama', 'users.dept']);

        return $data;
    }

    public function create($data, $userRole)
    {

        return DB::table('complain')->insert([
            'nrp' => auth()->user()->nrp,
            'tanggal' => $data['tanggal_add'] ?? null,
            'area' => $data['area_add'] ?? null,
            'gedung' => $data['gedung_add'] ?? null,
            'lokasi' => $data['lokasi_add'] ?? null,
            'foto_deviasi' => $data['fotodeviasi_add'] ?? null,
            'permasalahan' => $data['permasalahan_add'] ?? null,
            'kode_status' => 2,
            'created_by' => auth()->user()->id,
            'created_name' => auth()->user()->username,
            'created_on' => now(),
        ]);
    }


    public function edit($data, $id, $userRole)
    {
        $kodeStatus = 2;
        $updateData = [];

        if (!empty($data['tanggal_add'])) {
            $updateData['tanggal'] = $data['tanggal_add'];
        }
        if (!empty($data['area_add'])) {
            $updateData['area'] = $data['area_add'];
        }
        if (!empty($data['gedung_add'])) {
            $updateData['gedung'] = $data['gedung_add'];
        }
        if (!empty($data['lokasi_add'])) {
            $updateData['lokasi'] = $data['lokasi_add'];
        }
        if (!empty($data['permasalahan_add'])) {
            $updateData['permasalahan'] = $data['permasalahan_add'];
        }
        if (!empty($data['foto_deviasi'])) {
            $updateData['foto_deviasi'] = $data['foto_deviasi'];
        }

        $updateData['kode_status'] = 2;
        $updateData['created_on'] = now();

        if (!empty($updateData)) {
            return DB::table('complain')
                ->where('id', $id)
                ->update($updateData);
        }

        return false;
    }

    public function delete($selectedComplainId)
    {
        try {
            DB::table('complain')->where('id', $selectedComplainId)->delete();
            return 'Data Complain Berhasil dihapus.';
        } catch (\Exception $e) {
            return 'Gagal menghapus data complain: ' . $e->getMessage();
        }
    }

    public function send($userId, $userRole, $sendName, $selectedComplainId)
    {

        $complain = DB::table('complain')->where('id', $selectedComplainId)->first();
        if (!$complain) {
            return "Complain not found";
        }

        $currentKodeStatus = $complain->kode_status;
        $newKodeStatus = $currentKodeStatus + 1;

        DB::table('complain')
            ->where('id', $selectedComplainId)
            ->update([
                'send_by' => $userId,
                'send_name' => $sendName,
                'send_on' => now(),
                'kode_status' => $newKodeStatus
            ]);

        return "Status updated successfully";
    }

    public function revisi($revisiName, $userRole, $selectedComplainId, $pesanRevisi, $userId)
    {
        $kodeStatus = 9;

        DB::table('complain')
            ->where('id', $selectedComplainId)
            ->update([
                'revisi_by' => $revisiName,
                'revisi_on' => now(),
                'kode_status' => $kodeStatus,
                'revisi_desc_gagl' => $pesanRevisi
            ]);

        return 'Data Complain berhasil di "Revisi"';
    }

    public function reject($rejectName, $selectedComplainId, $pesanReject, $userId)
    {

        DB::table('complain')
            ->where('id', $selectedComplainId)
            ->update([
                'reject_by' => $rejectName,
                'reject_on' => now(),
                'kode_status' => 8,
                'reject_desc_gagl' => $pesanReject
            ]);

        return 'Data Complain Berhasil di "Reject"';
    }

    public function validasigagl($selectedComplainId, $kategori, $skala, $due_date, $crew_picadd, $userId)
    {
        $userNRP = auth()->user()->nrp;

        DB::table('complain')
            ->where('id', $selectedComplainId)
            ->update([
                'kode_status' => 3,
                'kategori' => $kategori,
                'skala' => $skala,
                'due_date' => $due_date,
                'crew_pic' => $crew_picadd,
                'validasi_gagl_send' => $userNRP
            ]);

        return 'Data Complain Berhasil di "Kirim"';
    }


    public function pendingGaGL($revisiName,$userRole, $selectedComplainId, $ketPending, $userId)
    {
        $kodeStatus = 2;

        DB::table('complain')
            ->where('id', $selectedComplainId)
            ->update([
                'pending_on' => now(),
                'kode_status' => $kodeStatus,
                'pending_gagl' => $ketPending,
                'skala' => 'Pending',
            ]);

        return 'Data Complain berhasil di "Revisi"';
    }

    public function validasicrew($selectedComplainId, $identification,$corrective_action,$foto_perbaikan, $userId)
    {

        DB::table('complain')
            ->where('id', $selectedComplainId)
            ->update([
                'kode_status' => 4,
                'identification' => $identification,
                'corrective_action' => $corrective_action,
                'foto_perbaikan' => $foto_perbaikan,
                'validasi_crew_on' => now()
            ]);

        return 'Data Complain Berhasil di "Kirim"';
    }

    public function rejectcrew($rejectName, $selectedComplainId, $pesanReject, $userId)
    {

        DB::table('complain')
            ->where('id', $selectedComplainId)
            ->update([
                'reject_by_crew' => $rejectName,
                'reject_on_crew' => now(),
                'kode_status' => 6,
                'reject_desc_crew' => $pesanReject
            ]);

        return 'Data Complain Berhasil di "Reject"';
    }

    public function rating($rating, $selectedComplainId, $pesanRating, $userId)
    {

        DB::table('complain')
            ->where('id', $selectedComplainId)
            ->update([
                'rating' => $rating,
                'desc_rating' => $pesanRating
            ]);

        return 'Data Berhasil di "Rating"';
    }

    public function ulangComplain($rating, $selectedComplainId, $pesanRating, $userId)
    {

        DB::table('complain')
            ->where('id', $selectedComplainId)
            ->update([
                'rating' => $rating,
                'kode_status' => 2,
                'created_on' => now(),
                'desc_rating' => $pesanRating
            ]);

        return 'Data Complain diajukan Kembali';
    }

    public function revisicrew($revisiName, $selectedComplainId, $pesanRevisi, $userId)
    {

        DB::table('complain')
            ->where('id', $selectedComplainId)
            ->update([
                'revisi_by_crew' => $revisiName,
                'revisi_on_crew' => now(),
                'kode_status' => 5,
                'revisi_desc_crew' => $pesanRevisi
            ]);

        return 'Data Complain Berhasil di "Revisi"';
    }

    public function approval($approvalName, $selectedComplainId, $approval,$foto_hasil_perbaikan, $userId)
    {

        DB::table('complain')
            ->where('id', $selectedComplainId)
            ->update([
                'approval_by' => $approvalName,
                'approval_on' => now(),
                'kode_status' => 7,
                'approval_desc' => $approval,
                'foto_hasil_perbaikan' => $foto_hasil_perbaikan
            ]);

        return 'Data Complain Berhasil di "Setujui"';
    }

    public function getAllWithDate()
    {
        return DB::table('complain')
            ->join('users', 'complain.nrp', '=', 'users.nrp')
            ->select(
                'complain.*',
                'users.nama as nama',
                'users.dept as departemen',
            )
            ->orderBy('complain.tanggal', 'desc')
            ->where('kode_status', 7);
    }

    public function findByName(string $nama)
    {
        return DB::table('users')->where('nama', $nama)->first();
    }

    public function getMayorCount_()
    {
        return DB::table('complain')->where('skala', 'Mayor')->count();
    }

    public function getMinorCount_()
    {
        return DB::table('complain')->where('skala', 'Minor')->count();
    }

    public function getPrioritasCount_()
    {
        return DB::table('complain')->where('skala', 'Prioritas')->count();
    }

    public function getPendingCount_()
    {
        return DB::table('complain')->where('skala', 'Pending')->count();
    }

    public function getTotalCount_()
    {
        return DB::table('complain')->count();
    }

    public function getDoneCount_()
    {
        return DB::table('complain')->where('kode_status', '7')->count();
    }

    public function getProgresCount_()
    {
        return DB::table('complain')->where('kode_status', '!=', '7')->count();
    }

    public function getMayorCount($tanggalAwal, $tanggalAkhir)
    {
        return DB::table('complain')
            ->where('skala', 'Mayor')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->count();
    }

    public function getMinorCount($tanggalAwal, $tanggalAkhir)
    {
        return DB::table('complain')
            ->where('skala', 'Minor')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->count();
    }

    public function getPrioritasCount($tanggalAwal, $tanggalAkhir)
    {
        return DB::table('complain')
            ->where('skala', 'Prioritas')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->count();
    }

    public function getPendingCount($tanggalAwal, $tanggalAkhir)
    {
        return DB::table('complain')
            ->where('skala', 'Pending')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->count();
    }

    public function getTotalCount($tanggalAwal, $tanggalAkhir)
    {
        return DB::table('complain')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->count();
    }

    public function getDoneCount($tanggalAwal, $tanggalAkhir)
    {
        return DB::table('complain')
            ->where('kode_status', '7')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->count();
    }

    public function getProgresCount($tanggalAwal, $tanggalAkhir)
    {
        return DB::table('complain')
            ->where('kode_status', '!=', '7')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->count();
    }

public function getFilteredComplains($startDate, $endDate, $status, $area = null)
{
    $query = DB::table('complain')
        ->select(
            DB::raw('COALESCE(gedung, "OTHER") as gedung'),
            DB::raw('COALESCE(area, "OTHER") as area'),
            DB::raw('COALESCE(kategori, "Belum Divalidasi GA/GL") as kategori'),
            DB::raw('COUNT(*) as jumlah')
        )
        ->groupBy(DB::raw('COALESCE(gedung, "OTHER")'), DB::raw('COALESCE(area, "OTHER")'), DB::raw('COALESCE(kategori, "Belum Divalidasi GA/GL")'));

    if ($startDate) {
        $query->whereDate('tanggal', '>=', $startDate);
    }

    if ($endDate) {
        $query->whereDate('tanggal', '<=', $endDate);
    }

    if ($status) {
        if ($status == 'done') {
            $query->where('kode_status', '=', '7');
        } elseif ($status == 'on_progress') {
            $query->where('kode_status', '!=', '7');
        }
    }

    if ($area) {
        $query->where('area', '=', $area);
    }

    return $query->get();
}


public function getFilteredComplainsArea($startDate, $endDate, $status)
{
    $query = DB::table('complain')
        ->select(
            DB::raw('COALESCE(kategori, "Belum Divalidasi GA/GL") as kategori'),
            DB::raw('COALESCE(area, "Other") as area'),
            DB::raw('COUNT(*) as jumlah')
        )
        ->groupBy(DB::raw('COALESCE(kategori, "Belum Divalidasi GA/GL")'), DB::raw('COALESCE(area, "Other")'));

    if ($startDate) {
        $query->whereDate('tanggal', '>=', $startDate);
    }

    if ($endDate) {
        $query->whereDate('tanggal', '<=', $endDate);
    }

    if ($status) {
        if ($status == 'done') {
            $query->where('kode_status', '=', '7');
        } elseif ($status == 'on_progress') {
            $query->where('kode_status', '!=', '7');
        }
    }

    return $query->get();
}


public function getFilteredComplainsStatus($startDate, $endDate)
    {
        $query = DB::table('complain')
            ->select('kode_status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('kode_status');

        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        return $query->get();
    }

    public function getFilteredComplainsScale($startDate, $endDate)
    {
        $query = DB::table('complain')
            ->select('skala', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('skala');

        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        return $query->get();
    }


    public function getAllWithUsernameDate()
    {
        $query = DB::table('complain')
            ->join('users', 'complain.nrp', '=', 'users.nrp')
            ->select('complain.*', 'users.nama as nama', 'users.dept as departemen')
            ->where('kode_status', 7)
            ->orderBy('created_on', 'desc');

        if (request('start_date') && request('end_date')) {
            $startDate = date('Y-m-d', strtotime(request('start_date')));
            $endDate = date('Y-m-d', strtotime(request('end_date')));

            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        return $query->get();
    }

    public function findById($id)
    {
        return DB::table('complain')
            ->leftJoin('users', 'complain.nrp', '=', 'users.nrp')
            ->where('complain.id', $id)
            ->select('complain.*', 'users.dept as dept', 'users.no_hp as no_hp', 'users.email as email', 'users.perusahaan as perusahaan', 'users.nama as nama')
            ->first();
    }

    public function findByNoUsers($id)
    {
        return DB::table('complain')
            ->leftJoin('users', 'complain.nrp', '=', 'users.nrp')
            ->where('complain.id', $id)
            ->select('complain.*', 'users.dept as dept', 'users.no_hp as no_hp', 'users.email as email', 'users.perusahaan as perusahaan', 'users.nama as nama')
            ->first();
    }

    public function getOnProgressComplains()
    {
        $userRole = auth()->user()->id_role;
        $userNrp = auth()->user()->nrp;
        $userNama = auth()->user()->nama;
        $userTimPIC = auth()->user()->tim_pic;

        $query = DB::table('complain')
        ->join('users', 'complain.nrp', '=', 'users.nrp')
        ->select('complain.*', 'users.nama as nama', 'users.dept as departemen', 'users.tim_pic')
        ->where('complain.kode_status', '!=', '7') // Hanya mengambil keluhan yang statusnya bukan 7
        ->orderBy('complain.created_on', 'desc');

        if ($userRole == 1 || $userRole == 5) {
            $query->where('complain.nrp', $userNrp);
        }

        if ($userRole == 2) {
            $query->where(function ($subQuery) use ($userNama, $userNrp, $userTimPIC) {
                $subQuery->where('complain.crew_pic', '=', $userNama)
                    ->orWhere('complain.created_name', '=', $userNrp);

                if (!empty($userTimPIC)) {

                    $teamMembers = DB::table('users')
                        ->where('tim_pic', '=', $userTimPIC)
                        ->pluck('nama')
                        ->toArray();

                    if (!empty($teamMembers)) {
                        $subQuery->orWhereIn('complain.crew_pic', $teamMembers);
                    }
                }
            });
        }

            $data = $query->get();

            foreach ($data as $complain) {
                $submissionDate = !empty($complain->created_on) ? strtotime(date('Y-m-d', strtotime($complain->created_on))) : null;
                $dueDate = !empty($complain->due_date) ? strtotime(date('Y-m-d', strtotime($complain->due_date))) : null;
                $approvalDate = !empty($complain->approval_on) ? strtotime(date('Y-m-d', strtotime($complain->approval_on))) : null;
                $today = strtotime(date('Y-m-d'));

                $endDate = $approvalDate ?? $today;

                $complain->days_worked = $submissionDate ? floor(($endDate - $submissionDate) / (60 * 60 * 24)) + 1 : '-';

                if (!$submissionDate) {
                    $complain->status = 'unknown';
                    $complain->badge_class = 'bg-secondary';
                }

                elseif ($approvalDate && $approvalDate === $submissionDate) {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
                elseif ($dueDate && $endDate > $dueDate) {
                    $complain->status = 'late';
                    $complain->badge_class = 'bg-danger';
                }
                else {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
            }


        return $data;
    }

    public function getOnProgressDoneComplains()
    {
        $userRole = auth()->user()->id_role;
        $userNrp = auth()->user()->nrp;
        $userNama = auth()->user()->nama;
        $userTimPIC = auth()->user()->tim_pic;

        $query = DB::table('complain')
        ->join('users', 'complain.nrp', '=', 'users.nrp')
        ->select('complain.*', 'users.nama as nama', 'users.dept as departemen', 'users.tim_pic')
        ->where('complain.kode_status', '=', '7') // Hanya mengambil keluhan yang statusnya bukan 7
        ->orderBy('complain.created_on', 'desc');

        if ($userRole == 1 || $userRole == 5) {
            $query->where('complain.nrp', $userNrp);
        }

        if ($userRole == 2) {
            $query->where(function ($subQuery) use ($userNama, $userNrp, $userTimPIC) {
                $subQuery->where('complain.crew_pic', '=', $userNama)
                    ->orWhere('complain.created_name', '=', $userNrp);

                if (!empty($userTimPIC)) {

                    $teamMembers = DB::table('users')
                        ->where('tim_pic', '=', $userTimPIC)
                        ->pluck('nama')
                        ->toArray();

                    if (!empty($teamMembers)) {
                        $subQuery->orWhereIn('complain.crew_pic', $teamMembers);
                    }
                }
            });
        }

            $data = $query->get();

            foreach ($data as $complain) {
                $submissionDate = !empty($complain->created_on) ? strtotime(date('Y-m-d', strtotime($complain->created_on))) : null;
                $dueDate = !empty($complain->due_date) ? strtotime(date('Y-m-d', strtotime($complain->due_date))) : null;
                $approvalDate = !empty($complain->approval_on) ? strtotime(date('Y-m-d', strtotime($complain->approval_on))) : null;
                $today = strtotime(date('Y-m-d'));

                $endDate = $approvalDate ?? $today;

                $complain->days_worked = $submissionDate ? floor(($endDate - $submissionDate) / (60 * 60 * 24)) + 1 : '-';

                if (!$submissionDate) {
                    $complain->status = 'unknown';
                    $complain->badge_class = 'bg-secondary';
                }

                elseif ($approvalDate && $approvalDate === $submissionDate) {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
                elseif ($dueDate && $endDate > $dueDate) {
                    $complain->status = 'late';
                    $complain->badge_class = 'bg-danger';
                }
                else {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
            }


            return $data;
    }

    public function getOnProgressMayorComplains()
    {
        $userRole = auth()->user()->id_role;
        $userNrp = auth()->user()->nrp;
        $userNama = auth()->user()->nama;
        $userTimPIC = auth()->user()->tim_pic;

        $query = DB::table('complain')
        ->join('users', 'complain.nrp', '=', 'users.nrp')
        ->select('complain.*', 'users.nama as nama', 'users.dept as departemen', 'users.tim_pic')
        ->where('skala', 'Mayor') // Hanya mengambil keluhan yang statusnya bukan 7
        ->orderBy('complain.created_on', 'desc');

        if ($userRole == 1 || $userRole == 5) {
            $query->where('complain.nrp', $userNrp);
        }

        if ($userRole == 2) {
            $query->where(function ($subQuery) use ($userNama, $userNrp, $userTimPIC) {
                $subQuery->where('complain.crew_pic', '=', $userNama)
                    ->orWhere('complain.created_name', '=', $userNrp);

                if (!empty($userTimPIC)) {

                    $teamMembers = DB::table('users')
                        ->where('tim_pic', '=', $userTimPIC)
                        ->pluck('nama')
                        ->toArray();

                    if (!empty($teamMembers)) {
                        $subQuery->orWhereIn('complain.crew_pic', $teamMembers);
                    }
                }
            });
        }

            $data = $query->get();

            foreach ($data as $complain) {
                $submissionDate = !empty($complain->created_on) ? strtotime(date('Y-m-d', strtotime($complain->created_on))) : null;
                $dueDate = !empty($complain->due_date) ? strtotime(date('Y-m-d', strtotime($complain->due_date))) : null;
                $approvalDate = !empty($complain->approval_on) ? strtotime(date('Y-m-d', strtotime($complain->approval_on))) : null;
                $today = strtotime(date('Y-m-d'));

                $endDate = $approvalDate ?? $today;

                $complain->days_worked = $submissionDate ? floor(($endDate - $submissionDate) / (60 * 60 * 24)) + 1 : '-';

                if (!$submissionDate) {
                    $complain->status = 'unknown';
                    $complain->badge_class = 'bg-secondary';
                }

                elseif ($approvalDate && $approvalDate === $submissionDate) {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
                elseif ($dueDate && $endDate > $dueDate) {
                    $complain->status = 'late';
                    $complain->badge_class = 'bg-danger';
                }
                else {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
            }


            return $data;
    }

    public function getOnProgressMinorComplains()
    {
        $userRole = auth()->user()->id_role;
        $userNrp = auth()->user()->nrp;
        $userNama = auth()->user()->nama;
        $userTimPIC = auth()->user()->tim_pic;

        $query = DB::table('complain')
        ->join('users', 'complain.nrp', '=', 'users.nrp')
        ->select('complain.*', 'users.nama as nama', 'users.dept as departemen', 'users.tim_pic')
        ->where('skala', 'Minor') // Hanya mengambil keluhan yang statusnya bukan 7
        ->orderBy('complain.created_on', 'desc');

        if ($userRole == 1 || $userRole == 5) {
            $query->where('complain.nrp', $userNrp);
        }

        if ($userRole == 2) {
            $query->where(function ($subQuery) use ($userNama, $userNrp, $userTimPIC) {
                $subQuery->where('complain.crew_pic', '=', $userNama)
                    ->orWhere('complain.created_name', '=', $userNrp);

                if (!empty($userTimPIC)) {

                    $teamMembers = DB::table('users')
                        ->where('tim_pic', '=', $userTimPIC)
                        ->pluck('nama')
                        ->toArray();

                    if (!empty($teamMembers)) {
                        $subQuery->orWhereIn('complain.crew_pic', $teamMembers);
                    }
                }
            });
        }

            $data = $query->get();

            foreach ($data as $complain) {
                $submissionDate = !empty($complain->created_on) ? strtotime(date('Y-m-d', strtotime($complain->created_on))) : null;
                $dueDate = !empty($complain->due_date) ? strtotime(date('Y-m-d', strtotime($complain->due_date))) : null;
                $approvalDate = !empty($complain->approval_on) ? strtotime(date('Y-m-d', strtotime($complain->approval_on))) : null;
                $today = strtotime(date('Y-m-d'));

                $endDate = $approvalDate ?? $today;

                $complain->days_worked = $submissionDate ? floor(($endDate - $submissionDate) / (60 * 60 * 24)) + 1 : '-';

                if (!$submissionDate) {
                    $complain->status = 'unknown';
                    $complain->badge_class = 'bg-secondary';
                }

                elseif ($approvalDate && $approvalDate === $submissionDate) {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
                elseif ($dueDate && $endDate > $dueDate) {
                    $complain->status = 'late';
                    $complain->badge_class = 'bg-danger';
                }
                else {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
            }


            return $data;
    }

    public function getOnProgressPrioritasComplains()
    {
        $userRole = auth()->user()->id_role;
        $userNrp = auth()->user()->nrp;
        $userNama = auth()->user()->nama;
        $userTimPIC = auth()->user()->tim_pic;

        $query = DB::table('complain')
        ->join('users', 'complain.nrp', '=', 'users.nrp')
        ->select('complain.*', 'users.nama as nama', 'users.dept as departemen', 'users.tim_pic')
        ->where('skala', 'Prioritas')
        ->orderBy('complain.created_on', 'desc');

        if ($userRole == 1 || $userRole == 5) {
            $query->where('complain.nrp', $userNrp);
        }

        if ($userRole == 2) {
            $query->where(function ($subQuery) use ($userNama, $userNrp, $userTimPIC) {
                $subQuery->where('complain.crew_pic', '=', $userNama)
                    ->orWhere('complain.created_name', '=', $userNrp);

                if (!empty($userTimPIC)) {

                    $teamMembers = DB::table('users')
                        ->where('tim_pic', '=', $userTimPIC)
                        ->pluck('nama')
                        ->toArray();

                    if (!empty($teamMembers)) {
                        $subQuery->orWhereIn('complain.crew_pic', $teamMembers);
                    }
                }
            });
        }

            $data = $query->get();

            foreach ($data as $complain) {
                $submissionDate = !empty($complain->created_on) ? strtotime(date('Y-m-d', strtotime($complain->created_on))) : null;
                $dueDate = !empty($complain->due_date) ? strtotime(date('Y-m-d', strtotime($complain->due_date))) : null;
                $approvalDate = !empty($complain->approval_on) ? strtotime(date('Y-m-d', strtotime($complain->approval_on))) : null;
                $today = strtotime(date('Y-m-d'));

                $endDate = $approvalDate ?? $today;

                $complain->days_worked = $submissionDate ? floor(($endDate - $submissionDate) / (60 * 60 * 24)) + 1 : '-';

                if (!$submissionDate) {
                    $complain->status = 'unknown';
                    $complain->badge_class = 'bg-secondary';
                }

                elseif ($approvalDate && $approvalDate === $submissionDate) {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
                elseif ($dueDate && $endDate > $dueDate) {
                    $complain->status = 'late';
                    $complain->badge_class = 'bg-danger';
                }
                else {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
            }


            return $data;
    }

    public function getOnProgressPendingComplains()
    {
        $userRole = auth()->user()->id_role;
        $userNrp = auth()->user()->nrp;
        $userNama = auth()->user()->nama;
        $userTimPIC = auth()->user()->tim_pic;

        $query = DB::table('complain')
        ->join('users', 'complain.nrp', '=', 'users.nrp')
        ->select('complain.*', 'users.nama as nama', 'users.dept as departemen', 'users.tim_pic')
        ->where('skala', 'Pending')
        ->orderBy('complain.created_on', 'desc');

        if ($userRole == 1 || $userRole == 5) {
            $query->where('complain.nrp', $userNrp);
        }

        if ($userRole == 2) {
            $query->where(function ($subQuery) use ($userNama, $userNrp, $userTimPIC) {
                $subQuery->where('complain.crew_pic', '=', $userNama)
                    ->orWhere('complain.created_name', '=', $userNrp);

                if (!empty($userTimPIC)) {

                    $teamMembers = DB::table('users')
                        ->where('tim_pic', '=', $userTimPIC)
                        ->pluck('nama')
                        ->toArray();

                    if (!empty($teamMembers)) {
                        $subQuery->orWhereIn('complain.crew_pic', $teamMembers);
                    }
                }
            });
        }

            $data = $query->get();

            foreach ($data as $complain) {
                $submissionDate = !empty($complain->created_on) ? strtotime(date('Y-m-d', strtotime($complain->created_on))) : null;
                $dueDate = !empty($complain->due_date) ? strtotime(date('Y-m-d', strtotime($complain->due_date))) : null;
                $approvalDate = !empty($complain->approval_on) ? strtotime(date('Y-m-d', strtotime($complain->approval_on))) : null;
                $today = strtotime(date('Y-m-d'));

                $endDate = $approvalDate ?? $today;

                $complain->days_worked = $submissionDate ? floor(($endDate - $submissionDate) / (60 * 60 * 24)) + 1 : '-';

                if (!$submissionDate) {
                    $complain->status = 'unknown';
                    $complain->badge_class = 'bg-secondary';
                }

                elseif ($approvalDate && $approvalDate === $submissionDate) {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
                elseif ($dueDate && $endDate > $dueDate) {
                    $complain->status = 'late';
                    $complain->badge_class = 'bg-danger';
                }
                else {
                    $complain->status = 'ontime';
                    $complain->badge_class = 'bg-success';
                }
            }


            return $data;
    }




}
