<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image" style="background-image: url({{ asset('laravel/public/images/eo/'.Session::get('data')['foto']) }});height: 45px;width: 45px;background-size: cover;background-repeat: no-repeat;border-radius: 50px;">
          {{-- <img src="{{ asset('storage/images/eo/'.Session::get('data')['foto']) }}" class="img-circle" alt="Anggota Image"> --}}
        </div>
        <div class="pull-left info">
          <p>{{ Session::get('data')['full_name'] }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> On sebagai {{ Session::get('group_name') }} </a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      @if(Session::get('group_name') == "admin")
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU UTAMA</li>
        <li>
          <a href="/dashboard">
            <i class="fa fa-dashboard"></i><span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-credit-card"></i><span>Simpan Pinjam</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/simpanan"><i class="fa fa-circle-o"></i> Simpanan Sukarela</a></li>
            <li><a href="/pinjaman"><i class="fa fa-circle-o"></i> Pengajuan Pinjaman</a></li>
            <li><a href="/approval_pinjaman"><i class="fa fa-circle-o"></i> Approval Pinjaman</a></li>
            <li><a href="/pembayaran_angsuran"><i class="fa fa-circle-o"></i> Pembayaran Angsuran</a></li>
            <li><a href="/sandangpangan"><i class="fa fa-circle-o"></i> Sandang Pangan</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-money"></i><span>Bendahara</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/anggota"><i class="fa fa-circle-o"></i> Tagihan</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Penerimaan Piutang</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Penerimaan Kas</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Account</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th"></i><span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/anggota"><i class="fa fa-circle-o"></i> Data Anggota</a></li>
            <li><a href="/saldo"><i class="fa fa-circle-o"></i> Data Saldo</a></li>
            <li><a href="/jabatan"><i class="fa fa-circle-o"></i> Data Jabatan</a></li>
            <li><a href="/divisi"><i class="fa fa-circle-o"></i> Data Divisi</a></li>
            <li><a href="/marital"><i class="fa fa-circle-o"></i> Data Status Marital</a></li>
            <li><a href="/jenis_angsuran"><i class="fa fa-circle-o"></i> Data Jenis Angsuran</a></li>
            <li><a href="/jenis_pinjaman"><i class="fa fa-circle-o"></i> Data Jenis Pinjaman</a></li>
          </ul>
        </li>
        <li class="header">Menu Tambahan</li>
        <li><a href="/anggota"><i class="fa fa-circle-o text-red"></i> <span>Construction</span></a></li>
      </ul>

      @elseif(Session::get('group_name') == "anggota")
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU UTAMA</li>
        <li>
          <a href="{{URL::to('/dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-credit-card"></i><span>Event</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL::to(str_replace(" ","_",Session::get('data')['full_name']).'/event/registrasi')}}"><i class="fa fa-circle-o"></i> Registrasi Event</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i><span>Registrasi Peserta</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{URL::to(str_replace(" ","_",Session::get('data')['full_name']).'/registrasi_peserta/daftar_peserta')}}"><i class="fa fa-circle-o"></i> Daftar Peserta</a></li>
            {{-- <li><a href="{{URL::to(str_replace(" ","_",Session::get('data')['full_name']).'/registrasi_peserta/daftar_peserta')}}"><i class="fa fa-circle-o"></i> Cek</a></li> --}}
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i><span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/simpanan"><i class="fa fa-circle-o"></i> Simpanan Sukarela</a></li>
            <li><a href="/pinjaman"><i class="fa fa-circle-o"></i> Pengajuan Pinjaman</a></li>
            <li><a href="/pembayaran_angsuran"><i class="fa fa-circle-o"></i> Pembayaran Angsuran</a></li>
            <li><a href="/sandangpangan"><i class="fa fa-circle-o"></i> Sandang Pangan</a></li>
          </ul>
        </li>

        <li>
          <a href="{{URL::to(str_replace(" ","_",Session::get('data')['full_name']).'/cek_pembayaran')}}">
            <i class="fa fa-usd"></i> <span>Cek Pembayaran</span>
          </a>
        </li>
      </ul>
      @endif
    </section>
    <!-- /.sidebar -->
</aside>