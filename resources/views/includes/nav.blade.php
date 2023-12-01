<div class="property_dashboard_navbar">
    <div class="dash_user_avater">
        <img src="{{asset('/assets/img/profile/'.Auth::user()->img_profile_id.'.png')}}" class="img-fluid avater" alt="">
        <h6>{{Auth::user()->name}}</h6>
        <span>{{Auth::user()->role}}</span>
            </div>
    <div class="dash_user_menues">
        <ul>
            @if(in_array(Auth::user()->role,['70x7','opd','kec']))
            <li>
                <a href="{{route('admin.training')}}">
                <i class="fas fa-chalkboard-teacher"></i>Pelatihan
                </a>
            </li>
            @endif
            @if(in_array(Auth::user()->role,['70x7','opd','kec']))
            <li>
                <a href="{{route('admin.trainee')}}">
                <i class="fas fa-user-graduate"></i>Peserta
                </a>
            </li>
            @endif
            @if(in_array(Auth::user()->role,['70x7','opd','kec']))
            <li>
                <a href="{{route('admin.business')}}">
                <i class="fas fa-business-time"></i>Bisnis
                </a>
            </li>
            @endif
            @if(in_array(Auth::user()->role,['70x7']))
            <li>
                <a href="{{route('admin.subdistrict')}}">
                <i class="fas fa-map"></i>Kecamatan
                </a>
            </li>
            @endif
            @if(in_array(Auth::user()->role,['70x7']))
            <li>
                <a href="{{route('admin.local-potential')}}">
                <i class="fas fa-seedling"></i>Potensi Lokal
                </a>
            </li>
            @endif
            @if(in_array(Auth::user()->role,['70x7']))
            <li>
                <a href="{{route('admin.page')}}">
                <i class="fas fa-file"></i>Halaman
                </a>
            </li>
            @endif
            @if(in_array(Auth::user()->role,['70x7','opd']))
            <li>
                <a href="{{route('admin.banner')}}">
                <i class="fas fa-image"></i>Banner
                </a>
            </li>
            @endif
            @if(in_array(Auth::user()->role,['70x7','opd']))
            <li>
                <a href="{{route('admin.news')}}">
                <i class="far fa-newspaper"></i>Berita
                </a>
            </li>
            @endif
            @if(in_array(Auth::user()->role,['70x7','opd']))
            <li>
                <a href="{{route('register-list')}}">
                <i class="fas fa-users"></i>Pengguna Web
                </a>
            </li>
            @endif
            @if(in_array(Auth::user()->role,['70x7']))
            <li>
                <a href="{{route('admin.config')}}">
                <i class="fas fa-wrench"></i>Konfigurasi
                </a>
            </li>
            @endif
        </ul>
    </div>
    
    <div class="dash_user_footer">
        <ul>
            <li title="logout?"><a href="{{route('logout')}}"><i class="fa fa-power-off"></i></a></li>
            <li><a href="{{route('profile.edit',Auth::user()->id)}}"><i class="fa fa-cog"></i></a></li>
        </ul>
    </div>
</div>