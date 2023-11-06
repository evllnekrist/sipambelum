<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Baharui akun Anda, disini.") }}
        </p>
    </header>

    <!-- <form id="send-verification" method="post" action="{{ route('verification.send') }}"> -->
        <!-- @csrf -->
    <!-- </form> -->

    <form method="post" action="{{ route('profile.update',$user->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="role" :value="__('Peran')" />
            <select class="form-control block mt-1 w-full" name="role" :value="old('role', $user->role)" required autofocus autocomplete="role">
              <option disabled>------ pilih salah satu ------</option>
              @foreach(@$roles as $role)
                <option value="{{$role->value}}" {{$user->role==$role->value?'selected':''}}>{{$role->label}}</option>
              @endforeach
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            <!-- @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()) -->
                <!-- <div> -->
                    <!-- <p class="text-sm mt-2 text-gray-800 dark:text-gray-200"> -->
                        <!-- {{ __('Email anda belum diverifikasi.') }} -->

                        <!-- <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"> -->
                            <!-- {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }} -->
                        <!-- </button> -->
                    <!-- </p> -->

                    <!-- @if (session('status') === 'verification-link-sent') -->
                        <!-- <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"> -->
                            <!-- {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }} -->
                        <!-- </p> -->
                    <!-- @endif -->
                <!-- </div> -->
            <!-- @endif -->
        <!-- </div> -->
        
        <div class="mt-4">
            <x-input-label for="pp" :value="__('Gambar Profil')" />
            <div class="form-group">
              <table>
                <tbody>
                  @for($i = 1; $i <= sizeof($pp_ids); $i++)
                    @if(($i-1)%4==0 || $i == sizeof($pp_ids)+1)
                    </tr>
                    @endif
                    @if($i == 1 || (($i-1)%4==0))
                    <tr>
                    @endif
                    <td>
                      <div class="custom-control custom-radio">
                        <input id="customRadioPP-{{$i}}"
                          class="custom-control-input custom-control-input-danger" 
                          name="pp" 
                          value="{{$pp_ids[$i-1]}}" 
                          type="radio" 
                          {{$user->img_profile_id==$pp_ids[$i-1]?'checked':''}}>
                        <label for="customRadioPP-{{$i}}" class="custom-control-label">
                          <img src="{{asset('/assets/img/profile/'.strval($pp_ids[$i-1]).'.png')}}" style="width:12vh">
                        </label>
                      </div>
                    </td>
                  @endfor
                </tbody>
              </table>
            </div>
            <x-input-error :messages="$errors->get('pp')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
