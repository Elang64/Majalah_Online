<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $users = User::whereIn('role', ['admin'])->get();
        return view('admin.user.index', compact('users'));
    }

    public function register(Request $request){
        //Request $request mengambil, memvalidasi, dan memanipulasi semua data dari HTTP (HyperText Transfer
        // Protocol)client->server yang masuk
        $request->validate([//mengproses lebih lanjut
            'first_name'=>'required|min:3',//agar wajib diisi | min 3
             'last_name'=>'required|min:3',
              'email'=>'required|email:dns',//harus ada @
               'password'=>'required|min:8'
        ],
    [
            'first_name.required' => 'Nama depan harus diisi.',//
            'first_name.min' => 'Nama depan harus terdiri dari minimal 3 karakter.',
            'last_name.required' => 'Nama belakang harus diisi.',
            'last_name.min' => 'Nama belakang harus terdiri dari minimal 3 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.min' => 'Format Email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',

    ]);

    $createData = User::create([//eloquent / ORM
        'name' => $request->first_name.' '.$request->last_name,
        'email'=> $request->email,
        'password'=>Hash::make($request->password),//mengenkripsi data
        'role'=>'user'
    ]);

    if ($createData) {
        return redirect()->route('login')->with('success', 'Berhasil membuat akun', 'Silahkan Login');
    } else {
        return redirect()->route('signup')->with('error', 'Gagal memproses data!', 'Silahkan coba lagi!');
    }
}

    public function authentication(Request $request)//mengambil data dari formulir
    //mengverifikasi user
    {
        $request->validate([// mengproses lebih lanjut si datanya
            'email' => 'required',
            'password' => 'required'
        ],
        [
            'email.required' => 'Email Harus diisi',
            'password.required' => 'Password Harus diisi'
        ]);
        //data yg akan digunakan untuk verfikasi
        $data = $request->only(['email', 'password']);
        //AUTH::attempt()->mencocokan data(email-pw /username-pw)
        if (Auth::attempt($data)) {//mencocokan data
        // dicek lagi terkait rolenya, kalo admin ke dashboard
            if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Berhasil Login!');// redirect() untuk tidak dihalaman itu saja akan diarahkan menuju route()
            }
             else { //selain admin ke home
                return redirect()->route('home')->with('success', 'Berhasil login!');
            }
    } else {
            return redirect()->back()->with('error', 'Gagal! Pastikan email
            dan password benar');
        }
    }
    public function logout()
    {
        //logout() - menghapus sesi login
        Auth::logout();
        return redirect()->route('home')->with('logout', 'Anda telah logout! Silahkan login kembali
        untuk akses lebih lengkap');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required',
        ], [
            'name.required' => 'Nama depan harus diisi.',//
            'name.min' => 'Nama depan harus terdiri dari minimal 3 karakter.',
            'email.required' => 'Email harus diisi.',
            'email_address.email' => 'Format email tidak valid.',
            'password' => 'Password harus diisi'
        ]);

        User::create([
          'name' => $request->name,
            'email' => $request->email,
            'role' => 'admin',
            'password' => Hash::make('adminMag'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Admin berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         $user = User::find($id);
        // dd() => cek data
        // dd($cinema->toArray());
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
           $user = User::findOrFail($id); // ambil user dulu
                $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'
            .$user->id,
        ]);

        $data = $request->only('name', 'email', 'role');

        // kalau password diisi, update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'Data berhasil dihapus');
    }

    public function trash(){
        $userTrash = User::onlyTrashed()->get();
        return view('admin.user.trash', compact('userTrash'));
    }

    public function restore($id) {
        $user = User::onlyTrashed()->find($id);
        $user->restore();
        return redirect()->route('admin.users.index')->with('success', 'Berhasil Mengembalikkan Data');
    }

    public function deletePermanent($id) {
           $user = User::onlyTrashed()->find($id);
        // forceDelete()-> menghapus data secara permanen, data hilang bahkan dari databasenya
        $user->forceDelete();
        return redirect()->back()->with('success', 'Berhasil menghapus seutuhnya!');
    }

    public function export() {
        // nama file yg akan di download
        // ekstensi antara xlsx/csv
        $fileName = "data-user.xlsx";
        // proses download
        return Excel::download(new UserExport, $fileName);
    }
}
