<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Option;
use App\Models\Subdistrict;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function index()
    {
      return view('auth.register-index');
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $data['roles'] = Option::where('type', 'ROLE')->orderBy('id','DESC')->get();
        $data['officials'] = Option::where('type', 'OFFICIAL')->orderBy('id','DESC')->get();
        $data['subdistricts'] = Subdistrict::orderBy('id','DESC')->get();
        $data['pp_ids'] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        return view('auth.register', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'role' => $request->role,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'img_profile_id' => $request->pp,
        ];
        switch ($request->role) {
            case 'opd':
                $data['official'] = @$request->official;
                break;
            case 'kec':
                $data['subdistrict'] = @$request->subdistrict;
                break;
        }
        $user = User::create($data);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    // -------------------------------------- CALLED BY AJAX ---------------------------- start
        public function get_listfull(Request $request)
        {
            try {
            $data = User::orderBy('created_at', 'DESC')->get();
            return json_encode(array('status'=>true, 'message'=>'Berhasil mengambil data', 'data'=>$data));
            } catch (Exception $e) {
            return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
            }
        }
        public function post_delete($id)
        {
            try {
                $output = User::where('id', $id)->delete();
                return json_encode(array('status'=>true, 'message'=>'Berhasil menghapus data', 'data'=>$output));
            } catch (Exception $e) {
                return json_encode(array('status'=>false, 'message'=>$e->getMessage(), 'data'=>null));
            }
        }
    // -------------------------------------- CALLED BY AJAX ---------------------------- end
}
