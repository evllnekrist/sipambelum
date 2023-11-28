<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Role -->
        <div>
            <x-input-label for="role" :value="__('Peran')" />
            <select class="form-control block mt-1 w-full" name="role" :value="old('role')" required autofocus autocomplete="role">
              <option disabled>------ pilih salah satu ------</option>
              @foreach(@$roles as $role)
                <option value="{{$role->value}}">{{$role->label}}</option>
              @endforeach
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        @section('addition_script')
        <script>
          $(function(){
            $('[name="role"]').on('change', function() {
              let role = $(this).find(":selected").val();
              console.log('role..',role)
              $('#select-opd-wrap').hide();
              $('#select-kec-wrap').hide();
              if(role == 'opd'){
                $('#select-opd-wrap').show();
              }else if(role == 'kec'){
                $('#select-kec-wrap').show();
              }
            });
          });
        </script>
        @endsection
        <br>
        <div style="display: none" id="select-opd-wrap">
          <x-input-label for="official" :value="__('OPD')" />
          <select class="form-control block mt-1 w-full" name="official" :value="old('official')">
            <option disabled>------ pilih salah satu ------</option>
            @foreach(@$officials as $official)
              <option value="{{$official->value}}">{{$official->label}}</option>
            @endforeach
          </select>
          <x-input-error :messages="$errors->get('official')" class="mt-2" />
        </div>

        <div style="display: none" id="select-kec-wrap">
          <x-input-label for="subdistrict" :value="__('Kecamatan')" />
          <select class="form-control block mt-1 w-full" name="subdistrict" :value="old('subdistrict')">
            <option disabled>------ pilih salah satu ------</option>
            @foreach(@$subdistricts as $subdistrict)
              <option value="{{$subdistrict->id}}">{{$subdistrict->name}}</option>
            @endforeach
          </select>
          <x-input-error :messages="$errors->get('subdistrict')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- PP -->
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
                          {{$i == 1?'checked':''}}>
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

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Sudah terdaftar?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
