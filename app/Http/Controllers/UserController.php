<?php

namespace App\Http\Controllers;
use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    protected $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function showLoginForm()
    {
        return view('/administration/login');
    }

    public function index()
    {
        $userData = $this->UserRepository->getData();

        return view('/administration/user', [
            'userData' => $userData,
        ]);
    }

    public function profile()
    {
        $userData = $this->UserRepository->getData();

        return view('/administration/profile', [
            'userData' => $userData,
        ]);
    }


    public function loginku(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $hashedPassword = sha1($password);
        $user = $this->UserRepository->findUserByCredentials($username, $hashedPassword);

        if (!$user) {
            return back()->withErrors(['password' => 'Username atau password salah.']);
        }

        Auth::loginUsingId($user->id);

        if (!$user->baju || !$user->celana || !$user->rompi || !$user->sepatu) {
            session()->flash('alert', 'Silakan lengkapi data karyawan sebelum menggunakan aplikasi.');
            session()->flash('hide_menu', true);

            return redirect('/profile');
        }

        session()->forget('hide_menu');
        // return ($user->id_role == 1 || $user->id_role == 2 || $user->id_role == 5 || $user->id_role == 6 || $user->id_role == 7) ? redirect('/complain') : redirect('/dashboard');
        if ($user->id_role == 6) {
            return redirect('/catering');
        } elseif (in_array($user->id_role, [1, 2, 5])) {
            return redirect('/complain');
        } elseif (in_array($user->id_role, [7])) {
            return redirect('/lapcatering');
        } else {
            return redirect('/dashboard');
        }

    }


    public function showRegistrationForm()
    {
        return view('administration/register');
    }

    public function register(Request $request)
    {
        $data = $request->except('_token');
        //$data = $request->all();
        //dd($data);
        $result = $this->UserRepository->createUser($data);

        $data = $request->all();

        if ($result) {
            return Response::json(['status' => 'success']);
        } else {
            return Response::json(['status' => 'error']);
        }

    }

    public function delete(Request $request)
    {

        $selectedUserId = $request->input('user_id');

        $result = $this->UserRepository->delete($selectedUserId);

        return response()->json(['message' => $result]);
    }

    public function getEdit($id)
    {
        $user = $this->UserRepository->getById($id);

        return response()->json($user);
    }

    public function edit($id, Request $request)
    {
        $data = $request->all();

        $result = $this->UserRepository->edit($data, $id);

        if ($result) {
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function editProfile($id, Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'baju' => 'required|string|max:100',
            'sepatu' => 'nullable|string|max:100',
            'celana' => 'nullable|string|max:100',
            'rompi' => 'nullable|string|max:100',
        ]);

        $result = $this->UserRepository->editProfile($request, $id);
        $user = Auth::user();

        if ($result) {
            return response()->json([
                'status' => 'success',
                'id_role' => $user->id_role,
            ]);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function changePassword(Request $request)
    {
        // Validasi data
        // $request->validate([
        //     'password' => 'required|min:6',
        //     'newpassword' => 'required|min:6|confirmed',
        // ]);

        $userId = $request->input('user_id');
        $currentPassword = $request->input('password');
        $newPassword = $request->input('newpassword');

        // Verifikasi password saat ini menggunakan SHA-1
        $currentUserPassword = $this->UserRepository->getCurrentUserPassword($userId);
        if (sha1($currentPassword) === $currentUserPassword) {
            // Verifikasi bahwa password baru sesuai dengan konfirmasi password
            if ($newPassword === $request->input('newpassword_confirmation')) {
                // Password baru sesuai, lanjutkan dengan perubahan password
                $newHashedPassword = sha1($newPassword);
                $result = $this->UserRepository->changePassword($userId, $newHashedPassword);

                if ($result) {
                    return response()->json(['status' => 'success']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to change password']);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'New password confirmation does not match']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Current password is incorrect']);
        }
    }
}
