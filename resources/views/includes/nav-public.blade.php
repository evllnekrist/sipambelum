<div class="header header-light">
    <div class="container">
        <nav id="navigation" class="navigation navigation-landscape">
            <div class="nav-header">
                <a class="nav-brand" >
                    <img src="{{ asset('assets/img/logo-light.png') }}" class="logonav" alt="" />
                </a>
                <div class="nav-toggle"></div>
                <!-- <div class="mobile_nav">
                    <ul>
                        <li><a href="#" data-toggle="modal" data-target="#login"><i class="fas fa-user-circle fa-lg"></i></a></li>
                    </ul>
                </div> -->
            </div>
            <div class="nav-menus-wrapper" style="transition-property: none;">
                <ul class="nav-menu">
                    <li class="active"><a href="/">Beranda<span class="submenu-indicator"></span></a>
                    </li>
                    <li><a>Pelatihan<span class="submenu-indicator"></span></a>
                        <ul class="nav-dropdown nav-submenu">
                            <li><a href="{{route('user.training')}}">Daftar Pelatihan<span class="submenu-indicator"></span></a>
                            </li>

                            <li><a href="{{route('user.trainee')}}">Cari Peserta<span class="submenu-indicator"></span></a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{route('user.news')}}">Berita<span class="submenu-indicator"></span></a>
                    <li><a>Tentang Kami<span class="submenu-indicator"></span></a>
                        <ul class="nav-dropdown nav-submenu">
                            <li><a href="{{route('user.page','sop')}}">SOP Pengolahan Sipambelum<span class="submenu-indicator"></span></a>
                            </li>

                            <li><a href="{{route('user.page','struktur-org')}}">Struktur Organisasi<span class="submenu-indicator"></span></a>
                            </li>

                            <li><a href="{{route('user.page','visi-misi')}}">Visi Misi<span class="submenu-indicator"></span></a>
                            </li>

                            <li><a href="{{route('user.page','hubungi-kami')}}">Hubungi Kami<span class="submenu-indicator"></span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
                
                <ul class="nav-menu nav-menu-social align-to-right">
                  @auth
                    <li>
                      <a href="{{route('admin.dashboard')}}" target="_blank">
                        <span class="dn-lg text-warning"><i class="fa fa-cogs mr-2"></i>Dashboard Admin</span><br>
                      </a>
                    </li>
                  @else
                    <li>                       
                      <a href="/login" class="alio_green">
                        <i class="fas fa-sign-in-alt me-1"></i><span class="dn-lg ml-3">Masuk</span>
                      </a>
                    </li>
                  @endauth
                </ul>
            </div>
        </nav>
    </div>
</div>