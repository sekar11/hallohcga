<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repository\ComplainRepository;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpParser\Node\Stmt\Return_;
use Barryvdh\DomPDF\Facade as PDFFacade;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use PhpOffice\PhpWord\Writer\PDF as WriterPDF;
use PhpOffice\PhpWord\Writer\PDF\DomPDF;
use PhpOffice\PhpWord\IOFactory;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\Writer\PDF\MPDF as PDFMPDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ComplainController extends Controller
{

    protected $ComplainRepository;

    public function __construct(ComplainRepository $ComplainRepository)
    {
        $this->ComplainRepository = $ComplainRepository;
    }

    // public function index()
    // {
    //     $ComplainData = $this->ComplainRepository->getAllWithUsername();
    //     $nrpOptions = User::select('nrp')->distinct()->get();

    //     return view('/complain/complain', [
    //         'ComplainData' => $ComplainData,
    //         'nrpOptions' => $nrpOptions,
    //     ]);
    // }

    public function index(Request $request)
{
    $status = $request->query('status');

    if ($status == 'on-progress') {
        $ComplainData = $this->ComplainRepository->getOnProgressComplains();
    } else if ($status == 'done') {
        $ComplainData = $this->ComplainRepository->getOnProgressDoneComplains();
    }
    else if ($status == 'mayor') {
        $ComplainData = $this->ComplainRepository->getOnProgressMayorComplains();
    }
    else {
        $ComplainData = $this->ComplainRepository->getAllWithUsername();
    }


    $nrpOptions = User::select('nrp')->distinct()->get();

    return view('/complain/complain', [
        'ComplainData' => $ComplainData,
        'nrpOptions' => $nrpOptions,
    ]);
}


    public function showForm()
    {
        $areas = ['Mess', 'OFFICE', 'CSA 1', 'CSA 2', 'CSA 3', 'CSA FUEL', 'PITSTOP'];

        return view('complain.complain', [
            'areas' => $areas,
        ]);

    }


    public function getTeknisi()
    {
        $teknisi = $this->ComplainRepository->getUserLevel2();
        return response()->json($teknisi);
    }

    public function create(Request $request)
    {
        $userRole = auth()->user()->id_role;
        $data = $request->except('_token');

        $request->validate([
            'fotodeviasi_add' => 'nullable|image|file|mimes:jpeg,png,jpg,gif,heic,heif|max:1024000',
        ]);

        if ($request->hasFile('fotodeviasi_add') && $request->file('fotodeviasi_add')->isValid()) {
            $image = $request->file('fotodeviasi_add');
            $imageInstance = Image::make($image);


            if ($imageInstance->width() > 800) {
                $imageInstance->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $quality = 100;

            $imageInstance->encode('jpg', $quality);
            while (strlen($imageInstance) > 102400) {
                $quality -= 5;
                $imageInstance->encode('jpg', $quality);
            }

            $fileName = uniqid() . '.jpg';
            $filePath = public_path('storage/photos/' . $fileName);
            $imageInstance->save($filePath);

            $data['fotodeviasi_add'] = 'photos/' . $fileName;

        } else {
            $data['fotodeviasi_add'] = null;
        }

        $result = $this->ComplainRepository->create($data, $userRole);

        if ($result) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }


    public function getEdit($id)
    {
        $complain = $this->ComplainRepository->getById($id);

        $complain->foto_deviasi = asset('storage/' . str_replace('\/', '/', $complain->foto_deviasi));
        $complain->foto_perbaikan = asset('storage/' . str_replace('\/', '/', $complain->foto_perbaikan));
        $complain->foto_hasil_perbaikan = asset('storage/' . str_replace('\/', '/', $complain->foto_hasil_perbaikan));

        return response()->json($complain);
    }

    public function edit($id, Request $request)
    {
        $data = $request->all();

        $request->validate([
            'fotodeviasi_add' => 'nullable|image|file|mimes:jpeg,png,jpg,gif,heic,heif|max:102400', // Menambahkan format HEIC/HEIF
        ]);

        if ($request->hasFile('fotodeviasi_add') && $request->file('fotodeviasi_add')->isValid()) {
            $currentData = DB::table('complain')->find($id);
            if ($currentData && $currentData->foto_deviasi) {
                Storage::disk('public')->delete($currentData->foto_deviasi);
            }

            $image = $request->file('fotodeviasi_add');
            $imageInstance = Image::make($image);

            $imageInstance->encode('jpg', 1);

            $fileName = uniqid() . '.jpg';
            $filePath = public_path('storage/photos/' . $fileName);

            $imageInstance->save($filePath);

            $data['foto_deviasi'] = 'photos/' . $fileName;
        }

        $userRole = auth()->user()->id_role;

        $result = $this->ComplainRepository->edit($data, $id, $userRole);

        if ($result) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function delete(Request $request)
    {

        $selectedComplainId = $request->input('complain_id');

        $result = $this->ComplainRepository->delete($selectedComplainId);

        return response()->json(['message' => $result]);
    }

    public function send(Request $request)
    {
        $userId = auth()->user()->id;
        $userRole = auth()->user()->id_role;
        $sendName = auth()->user()->nama;
        $selectedComplainId = $request->input('complain_id');
        //dd($selectedComplainId);
        $result = $this->ComplainRepository->send($userId, $userRole, $sendName, $selectedComplainId);

        return response()->json(['message' => $result]);
    }

    public function revisi(Request $request)
    {

        $userId = auth()->user()->id;
        $userRole = auth()->user()->id_role;
        $revisiName = auth()->user()->nama;
        $selectedComplainId = $request->input('complain_id');
        $pesanRevisi = $request->input('revisi');

        $result = $this->ComplainRepository->revisi($revisiName,$userRole, $selectedComplainId, $pesanRevisi, $userId);
        $complain = $this->ComplainRepository->findById($selectedComplainId);

        if (!$complain || !$complain->no_hp) {
            return response()->json(['error' => 'Nomor HP pelapor tidak tersedia'], 400);
        }

        $messageUser = "STATUS: REVISI\n\n";
        $messageUser .= "Halo {$complain->nama},\n";
        $messageUser .= "Terdapat data yang harus di revisi pada complain yang kamu ajukan.\n\n";
        $messageUser .= "Detail Complain:\n";
        $messageUser .= "- Lokasi: {$complain->lokasi}\n";
        $messageUser .= "- Area: {$complain->area}\n";
        $messageUser .= "- Gedung: {$complain->gedung}\n\n";
        $messageUser .= "Permasalahan:\n";
        $messageUser .= "{$complain->permasalahan}\n\n";
        $messageUser .= "Keterangan Revisi:\n";
        $messageUser .= "{$complain->revisi_desc_gagl}\n\n";
        $messageUser .= "KETERANGAN LEBIH LANJUT\n";
        $messageUser .= "SILAHKAN CEK DI PORTAL:\n";
        $messageUser .= "https://hallohcga.com/";

        $responseUser = $this->sendWhatsAppMessage($complain->no_hp, $messageUser);
        if (!$responseUser) {
            return response()->json(['error' => 'Gagal mengirim pesan WhatsApp ke Pelapor'], 500);
        }
        return response()->json(['message' => $result]);
    }


    public function reject(Request $request)
    {
        $userId = auth()->user()->id;
        $userRole = auth()->user()->id_role;
        $rejectName = auth()->user()->nama;
        $selectedComplainId = $request->input('complain_id');
        $pesanReject = $request->input('reject');

        $result = $this->ComplainRepository->reject($rejectName, $selectedComplainId, $pesanReject, $userId);

        $complain = $this->ComplainRepository->findById($selectedComplainId);

        if (!$complain || !$complain->no_hp) {
            return response()->json(['error' => 'Nomor HP pelapor tidak tersedia'], 400);
        }

        $messageUser = "STATUS: REJECT\n\n";
        $messageUser .= "Halo {$complain->nama},\n";
        $messageUser .= "Complain yang kamu ajukan di tolak.\n\n";
        $messageUser .= "Detail Complain:\n";
        $messageUser .= "- Lokasi: {$complain->lokasi}\n";
        $messageUser .= "- Area: {$complain->area}\n";
        $messageUser .= "- Gedung: {$complain->gedung}\n\n";
        $messageUser .= "Permasalahan:\n";
        $messageUser .= "{$complain->permasalahan}\n\n";
        $messageUser .= "Keterangan Reject:\n";
        $messageUser .= "{$complain->reject_desc_gagl}\n\n";
        $messageUser .= "KETERANGAN LEBIH LANJUT\n";
        $messageUser .= "SILAHKAN CEK DI PORTAL:\n";
        $messageUser .= "https://hallohcga.com/";

        $responseUser = $this->sendWhatsAppMessage($complain->no_hp, $messageUser);
        if (!$responseUser) {
            return response()->json(['error' => 'Gagal mengirim pesan WhatsApp ke Pelapor'], 500);
        }
    return response()->json(['message' => $result]);
    }

    public function validasigagl(Request $request)
    {
        $userId = auth()->user()->id;
        $selectedComplainId = $request->input('complain_id');
        $kategori = $request->input('kategori');
        $skala = $request->input('skala');
        $due_date = $request->input('due_date');
        $crew_picadd = $request->input('crew_picadd');

        $result = $this->ComplainRepository->validasigagl($selectedComplainId, $kategori, $skala, $due_date, $crew_picadd, $userId);

        $crew = $this->ComplainRepository->findByName($crew_picadd);
        if (!$crew) {
            return response()->json(['error' => 'Data crew tidak ditemukan'], 404);
        }

        $complain = $this->ComplainRepository->findById($selectedComplainId);
        if (!$complain) {
            return response()->json(['error' => 'Data complain tidak ditemukan'], 404);
        }

        if (!$crew->no_hp) {
            return response()->json(['error' => 'Nomor HP crew tidak tersedia'], 400);
        }

        $messageCrew = "STATUS: BELUM DI PROSES,\n";
        $messageCrew .= "Halo $crew->nama,\n";
        $messageCrew .= "Terdapat pengajuan complain dengan detail sebagai berikut:\n\n";
        $messageCrew .= "Tanggal Pengajuan: {$complain->tanggal}\n\n";
        $messageCrew .= "Biodata Karyawan yang mengajukan complain:\n";
        $messageCrew .= "- Nama: {$complain->nama}\n";
        $messageCrew .= "- NRP: {$complain->nrp}\n";
        $messageCrew .= "- No HP: {$complain->no_hp}\n";
        $messageCrew .= "- Departemen: {$complain->dept}\n";
        $messageCrew .= "- Perusahaan: {$complain->perusahaan}\n\n";
        $messageCrew .= "Status Complain:\n";
        $messageCrew .= "- Due Date: $due_date\n";
        $messageCrew .= "- Kategori: $kategori\n";
        $messageCrew .= "- Skala: $skala\n\n";
        $messageCrew .= "Lokasi Complain:\n";
        $messageCrew .= "- Lokasi: {$complain->lokasi}\n";
        $messageCrew .= "- Area: {$complain->area}\n";
        $messageCrew .= "- Gedung: {$complain->gedung}\n\n";
        $messageCrew .= "Permasalahan:\n";
        $messageCrew .= "{$complain->permasalahan}\n\n";
        $messageCrew .= "KETERANGAN LEBIH LANJUT\n";
        $messageCrew .= "SILAHKAN CEK DI PORTAL:\n";
        $messageCrew .= "https://hallohcga.com/";
        $responseCrew = $this->sendWhatsAppMessage($crew->no_hp, $messageCrew);

        if (!$responseCrew) {
            return response()->json(['error' => 'Gagal mengirim pesan WhatsApp ke Crew'], 500);
        }

        if (!$complain->no_hp) {
            return response()->json(['error' => 'Nomor HP pelapor tidak tersedia'], 400);
        }

        $messageUser = "Halo {$complain->nama},\n";
        $messageUser .= "Status complain yang kamu ajukan saat ini sedang diproses.\n\n";
        $messageUser .= "Detail Complain:\n";
        $messageUser .= "- Lokasi: {$complain->lokasi}\n";
        $messageUser .= "- Area: {$complain->area}\n";
        $messageUser .= "- Gedung: {$complain->gedung}\n\n";
        $messageUser .= "Permasalahan:\n";
        $messageUser .= "{$complain->permasalahan}\n\n";
        $messageUser .= "- Due Date: {$complain->due_date}\n";
        $messageUser .= "- Crew PIC: {$crew->nama}\n";
        $messageCrew .= "KETERANGAN LEBIH LANJUT\n";
        $messageCrew .= "SILAHKAN CEK DI PORTAL:\n";
        $messageCrew .= "https://hallohcga.com/";

        $responseUser = $this->sendWhatsAppMessage($complain->no_hp, $messageUser);
        if (!$responseUser) {
            return response()->json(['error' => 'Gagal mengirim pesan WhatsApp ke Pelapor'], 500);
        }

        return response()->json(['message' => $result]);
    }


    protected function sendWhatsAppMessage($no_hp, $message)
    {
        $apiKey = env('FONNTE_API_KEY');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $no_hp,
                'message' => $message,
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $apiKey
            ),

        ));

        //curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($curl);
        $error_msg = null;

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if ($error_msg) {
            throw new \Exception("cURL Error: $error_msg");
        }

        return json_decode($response, true);
    }

    public function pendingGagl(Request $request)
    {

        $userId = auth()->user()->id;
        $userRole = auth()->user()->id_role;
        $revisiName = auth()->user()->nama;
        $selectedComplainId = $request->input('complain_id');
        $ketPending = $request->input('pendingGagl');

        $result = $this->ComplainRepository->pendingGagl($revisiName,$userRole, $selectedComplainId, $ketPending, $userId);

        $complain = $this->ComplainRepository->findById($selectedComplainId);

        if (!$complain || !$complain->no_hp) {
            return response()->json(['error' => 'Nomor HP pelapor tidak tersedia'], 400);
        }

        $messageUser = "STATUS: PENDING\n\n";
        $messageUser .= "Halo {$complain->nama},\n";
        $messageUser .= "Complain yang kamu ajukan sedang dalam status pending.\n\n";
        $messageUser .= "Detail Complain:\n";
        $messageUser .= "- Lokasi: {$complain->lokasi}\n";
        $messageUser .= "- Area: {$complain->area}\n";
        $messageUser .= "- Gedung: {$complain->gedung}\n\n";
        $messageUser .= "Permasalahan:\n";
        $messageUser .= "{$complain->permasalahan}\n\n";
        $messageUser .= "Keterangan Pending:\n";
        $messageUser .= "{$complain->pending_gagl}\n\n";
        $messageUser .= "KETERANGAN LEBIH LANJUT\n";
        $messageUser .= "SILAHKAN CEK DI PORTAL:\n";
        $messageUser .= "https://hallohcga.com/";

        $responseUser = $this->sendWhatsAppMessage($complain->no_hp, $messageUser);
        if (!$responseUser) {
            return response()->json(['error' => 'Gagal mengirim pesan WhatsApp ke Pelapor'], 500);
        }
        return response()->json(['message' => $result]);
    }

    public function validasicrew(Request $request)
    {
        $userId = auth()->user()->id;
        $userRole = auth()->user()->id_role;
        $selectedComplainId = $request->input('complain_id');
        $identification = $request->input('identification');
        $corrective_action = $request->input('corrective_action');
        $foto_perbaikan = $request->input('foto_perbaikan');

        $request->validate([
            'foto_perbaikan' => 'nullable|image|file|mimes:jpeg,png,jpg,gif,heic,heif|max:102400', // Menambahkan format HEIC/HEIF
        ]);


        if ($request->hasFile('foto_perbaikan') && $request->file('foto_perbaikan')->isValid()) {
        $image = $request->file('foto_perbaikan');
        $imageInstance = Image::make($image);

        if ($imageInstance->width() > 800) {
            $imageInstance->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $quality = 100;
        $imageInstance->encode('jpg', $quality);
        while (strlen($imageInstance) > 102400) {
            $quality -= 5;
            $imageInstance->encode('jpg', $quality);
        }

        $fileName = uniqid() . '.jpg';
        $filePath = public_path('storage/photos/' . $fileName);
        $imageInstance->save($filePath);

        $foto_perbaikan = 'photos/' . $fileName;
    } else {
        $foto_perbaikan = null;
    }
        $result = $this->ComplainRepository->validasicrew(
            $selectedComplainId,
            $identification,
            $corrective_action,
            $foto_perbaikan,
            $userId
        );

        $complain = $this->ComplainRepository->findById($selectedComplainId);

        if ($complain) {
            $nrp = $complain->validasi_gagl_send;
            $employee = DB::table('users')->where('nrp', $nrp)->first();

            if (!$employee) {
                return response()->json(['error' => 'Karyawan dengan NRP terkait tidak ditemukan'], 404);
            }

            $phoneNumber = $employee->no_hp;
            
            $message = "STATUS: SUDAH DI PROSES,\n";
            $message .= "Halo\n";
            $message .= "Complain Sudah diselesaikan oleh Teknisi/Crew TerkaitT:\n\n";
            $message .= "Tanggal Pengajuan Complain: {$complain->tanggal}\n\n";

            $message .= "Biodata Karyawan yang mengajukan complain:\n";
            $message .= "- Nama: {$complain->nama}\n";
            $message .= "- NRP: {$complain->nrp}\n";
            $message .= "- No HP: {$complain->no_hp}\n";
            $message .= "- Departemen: {$complain->dept}\n";
            $message .= "- Perusahaan: {$complain->perusahaan}\n\n";

            $message .= "Status Complain:\n";
            $message .= "- Due Date: {$complain->due_date}\n";
            $message .= "- Kategori: {$complain->kategori}\n";
            $message .= "- Skala: {$complain->skala}\n\n";

            $message .= "Lokasi Complain:\n";
            $message .= "- Lokasi: {$complain->lokasi}\n";
            $message .= "- Area: {$complain->area}\n";
            $message .= "- Gedung: {$complain->gedung}\n\n";

            $message .= "Permasalahan:\n";
            $message .= "{$complain->permasalahan}\n\n";

            $message .= "Keterangan Pengerjaan:\n";
            $message .= "- Crew PIC: {$complain->crew_pic}\n";
            $message .= "- Identifikasi: {$identification}\n";
            $message .= "- Tindakan Korektif: {$corrective_action}\n\n";

            $message .= "KETERANGAN LEBIH LANJUT\n";
            $message .= "SILAHKAN CEK DI PORTAL:\n";
            $message .= "https://hallohcga.com/";
            $response = $this->sendWhatsAppMessage($phoneNumber, $message);

            if (!$response) {
                return response()->json(['error' => 'Gagal mengirim pesan WhatsApp'], 500);
            }
        } else {
            return response()->json(['error' => 'Data complain tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result,
            'foto_perbaikan' => $foto_perbaikan,
        ]);
    }


    public function rejectcrew(Request $request)
    {
        $userId = auth()->user()->id;
        $userRole = auth()->user()->id_role;
        $rejectName = auth()->user()->nama;
        $selectedComplainId = $request->input('complain_id');
        $pesanReject = $request->input('reject_crew');

        $result = $this->ComplainRepository->rejectcrew($rejectName, $selectedComplainId, $pesanReject, $userId);
        $complain = $this->ComplainRepository->findById($selectedComplainId);

        if (!$complain || !$complain->no_hp) {
            return response()->json(['error' => 'Nomor HP pelapor tidak tersedia'], 400);
        }

        $messageUser = "STATUS: REJECT BY CREW\n\n";
        $messageUser .= "Halo {$complain->nama},\n";
        $messageUser .= "Complain yang kamu ajukan di tolak oleh crew/teknisi terkait.\n\n";
        $messageUser .= "Detail Complain:\n";
        $messageUser .= "- Lokasi: {$complain->lokasi}\n";
        $messageUser .= "- Area: {$complain->area}\n";
        $messageUser .= "- Gedung: {$complain->gedung}\n\n";
        $messageUser .= "Permasalahan:\n";
        $messageUser .= "{$complain->permasalahan}\n\n";
        $messageUser .= "Keterangan Reject:\n";
        $messageUser .= "{$complain->reject_desc_crew}\n\n";
        $messageUser .= "KETERANGAN LEBIH LANJUT\n";
        $messageUser .= "SILAHKAN CEK DI PORTAL:\n";
        $messageUser .= "https://hallohcga.com/";

        $responseUser = $this->sendWhatsAppMessage($complain->no_hp, $messageUser);
        if (!$responseUser) {
            return response()->json(['error' => 'Gagal mengirim pesan WhatsApp ke Pelapor'], 500);
        }
    return response()->json(['message' => $result]);
    }

    //sekar
    public function revisicrew(Request $request)
    {
        $userId = auth()->user()->id;
        $userRole = auth()->user()->id_role;
        $revisiName = auth()->user()->nama;
        $selectedComplainId = $request->input('complain_id');
        $pesanRevisi = $request->input('revisi_crew');

        $result = $this->ComplainRepository->revisicrew($revisiName, $selectedComplainId, $pesanRevisi, $userId);
        $complain = $this->ComplainRepository->findById($selectedComplainId);

        if ($complain) {
            $nama = $complain->crew_pic;

            $employee = DB::table('users')->where('nama', $nama)->first();
            if (!$employee) {
                return response()->json(['error' => 'Karyawan dengan NRP terkait tidak ditemukan'], 404);
            }

            $phoneNumber = $employee->no_hp;

            $message = "STATUS: REVISI\n\n";
            $message .= "Halo {$complain->crew_pic},\n";

            $message .= "Pengerjaan complain yang kamu kerjakan belum sesuai:\n\n";

            $message .= "Tanggal Pengajuan Complain: {$complain->tanggal}\n\n";
            $message .= "Biodata Karyawan yang mengajukan complain:\n";
            $message .= "- Nama: {$complain->nama}\n";
            $message .= "- NRP: {$complain->nrp}\n";
            $message .= "- No HP: {$complain->no_hp}\n";
            $message .= "- Departemen: {$complain->dept}\n\n";

            $message .= "Status Complain:\n";
            $message .= "- Due Date: {$complain->due_date}\n";
            $message .= "- Kategori: {$complain->kategori}\n";
            $message .= "- Skala: {$complain->skala}\n\n";

            $message .= "Lokasi Complain:\n";
            $message .= "- Lokasi: {$complain->lokasi}\n";
            $message .= "- Area: {$complain->area}\n";
            $message .= "- Gedung: {$complain->gedung}\n\n";

            $message .= "Permasalahan:\n";
            $message .= "{$complain->permasalahan}\n\n";

            $message .= "Keterangan Pengerjaan:\n";
            $message .= "- Crew PIC: {$complain->crew_pic}\n";
            $message .= "- Identifikasi: {$complain->identification}\n";
            $message .= "- Tindakan Korektif: {$complain->corrective_action}\n\n";
            $message .= "Keterangan Revisi:\n";
            $message .= "{$complain->revisi_desc_crew}\n\n";
            $message .= "KETERANGAN LEBIH LANJUT\n";
            $message .= "SILAHKAN CEK DI PORTAL:\n";
            $message .= "https://hallohcga.com/";

            $response = $this->sendWhatsAppMessage($phoneNumber, $message);

            if (!$response) {
                return response()->json(['error' => 'Gagal mengirim pesan WhatsApp'], 500);
            }
        } else {
            return response()->json(['error' => 'Data complain tidak ditemukan'], 404);
        }

    return response()->json(['message' => $result]);
    }

    public function approval(Request $request)
    {
        $userId = auth()->user()->id;
        $userRole = auth()->user()->id_role;
        $approvalName = auth()->user()->nama;
        $selectedComplainId = $request->input('complain_id');
        $approval = $request->input('keterangan');
        $foto_hasil_perbaikan = $request->input('foto_hasil_perbaikan');

        $request->validate([
            'foto_hasil_perbaikan' => 'nullable|image|file|mimes:jpeg,png,jpg,gif,heic,heif|max:102400',
        ]);

        if ($request->hasFile('foto_hasil_perbaikan') && $request->file('foto_hasil_perbaikan')->isValid()) {
            $image = $request->file('foto_hasil_perbaikan');
            $imageInstance = Image::make($image);

            if ($imageInstance->width() > 800) {
                $imageInstance->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $quality = 100;

            $imageInstance->encode('jpg', $quality);
            while (strlen($imageInstance) > 102400) {
                $quality -= 5;
                $imageInstance->encode('jpg', $quality);
            }

            $fileName = uniqid() . '.jpg';
            $filePath = public_path('storage/photos/' . $fileName);

            $imageInstance->save($filePath);

            $foto_hasil_perbaikan = 'photos/' . $fileName;
        } else {
            $foto_hasil_perbaikan = null;
        }

        $result = $this->ComplainRepository->approval($approvalName, $selectedComplainId, $approval, $foto_hasil_perbaikan, $userId);
        //sekar
        $complain = $this->ComplainRepository->findById($selectedComplainId);

        if (!$complain || !$complain->no_hp) {
            return response()->json(['error' => 'Nomor HP pelapor tidak tersedia'], 400);
        }

        $messageUser = "STATUS: DONE\n\n";
        $messageUser .= "Halo {$complain->nama},\n";
        $messageUser .= "Complain yang kamu ajukan telah selesai diproses.\n\n";
        $messageUser .= "Detail Complain:\n";
        $messageUser .= "- Lokasi: {$complain->lokasi}\n";
        $messageUser .= "- Area: {$complain->area}\n";
        $messageUser .= "- Gedung: {$complain->gedung}\n\n";
        $messageUser .= "Permasalahan:\n";
        $messageUser .= "{$complain->permasalahan}\n\n";
        $messageUser .= "Keterangan Perbaikan:\n";
        $messageUser .= "{$complain->corrective_action}\n\n";

        $messageUser .= "KETERANGAN LEBIH LANJUT\n";
        $messageUser .= "SILAHKAN CEK DI PORTAL:\n";
        $messageUser .= "https://hallohcga.com/";

        $responseUser = $this->sendWhatsAppMessage($complain->no_hp, $messageUser);
        if (!$responseUser) {
            return response()->json(['error' => 'Gagal mengirim pesan WhatsApp ke Pelapor'], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result,
            'foto_hasil_perbaikan' => $foto_hasil_perbaikan,
        ]);
    }


    public function report(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = $this->ComplainRepository->getAllWithDate();
        if ($startDate && $endDate) {
            $query->whereBetween('complain.tanggal', [$startDate, $endDate]);
        }

        $complainData = $query->get();

        return view('/report/report_complain', [
            'complainData' => $complainData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
