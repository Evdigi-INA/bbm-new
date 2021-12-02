<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreUserRequest, UpdateUserRequest};
use App\Models\Salesman;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create user')->only('create');
        $this->middleware('permission:read user')->only('index');
        $this->middleware('permission:edit user')->only('edit');
        $this->middleware('permission:update user')->only('update');
        $this->middleware('permission:delete user')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::with('roles');

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', 'setting.user.data-table.action')
                ->addColumn('role', function ($row) {
                    return ucfirst($row->roles[0]->name);
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? 'Aktif' : 'Nonaktif';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('setting.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setting.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole($request->role);
        $user->givePermissionTo($request->permissions);

        if ($request->salesman) {
            $salesman = Salesman::findOrFail($request->salesman);
            $salesman->update(['user_id' => $user->id]);
        }

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->load('roles', 'permissions');

        return view('setting.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // kalo ada request password berarti user pengen ganti password
        if ($request->password || $request->password_confirmation) {
            $request->validate([
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
                ]
            ]);

            $user->update([
                'password' => bcrypt($request->password)
            ]);
        }

        // kalo admin pertama/satu-satunya gabisa diedit
        if ($user->id == 1) {
            Alert::success('Update Data', 'Berhasil');

            return redirect()->route('user.index');
        }

        $user->syncRoles($request->role);
        $user->syncPermissions($request->permissions);

        $user->update($request->only(['name', 'email', 'status']));

        // kalo ada request salesman.id maka set salesman.user_id
        if ($request->salesman && $request->role == 'salesman') {
            $salesman = Salesman::findOrFail($request->salesman);
            $salesman->update(['user_id' => $user->id]);
        }

        // kalo sebelumnya salesman dan diubah jadi admin, buat null user_id pada tabel salesman
        if ($request->role == 'admin') {
            /**
             * kalo admin otomatis $request->salesman = null
             * udah coba null secara manual ga bisa
             */
            $user->salesman ? $user->salesman->update(['user_id' => $request->salesman]) : null;
        }

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // kalo admin pertama gabisa diedit
        if ($user->id == 1) {
            Alert::error('Tidak bisa hapus admin', 'Gagal');

            return redirect()->route('user.index');
        }

        $user->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }
}
