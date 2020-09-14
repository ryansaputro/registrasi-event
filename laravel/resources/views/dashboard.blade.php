@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
@if(count($dtEvent) > 0)
<section class="content-header">
  <div class="col-md-6">
    <h4>
      <i class="fa fa-line-chart" aria-hidden="true"></i>
      Event Berlangsung
    </h4>
  </div>
  <div class="col-md-4">
    <form class="cari">
      <div class="form-group has-feedback">
          <div class="col-md-6">
              <select class="selEvent form-control" style="width:300px;" name="events">
              @foreach ($dtEvent AS $k => $v)
                <option value="{{$v->id}}" {{$v->id == $id_event ? 'selected' : ''}}>{{$v->kode_event}}</option>
              @endforeach
              </select>    
          </div>
              <button class="btn btn-block btn-primary" style="display:none;" type="submit">Cari</button>      
      </div>
    </form>
  </div>
  <div class="col-md-2">
      <a style="margin-top: 15px;" class="btn btn-primary btn-block" href="{{URL::to(strtolower(str_replace(" ","_",Session::get('data')['full_name']).'/event/registrasi'))}}"><i class="fa fa-plus" aria-hidden="true"></i> Buat Event</a>
  </div>
</section>
@endif
<!-- Main content -->
<section class="content" style="min-height:0px !important;">
  <!-- Default row -->
  
  <div class="col-md-12" style="margin-top:50px;margin-bottom:10px;background: white;">
    @if(count($dtEvent) > 0)
    <!-- ./col -->
    <div class="col-md-6">
      <label>Event</label>
      <div class="panel panel-default">
        <div class="panel-body">

          <div style="width: 100%;margin: 0 auto;">
              {!! $chart->html() !!}
          </div>

        </div>
        <!-- ./panel-body -->
      </div>
      <!-- ./panel -->
    </div>

    <!-- ./col -->
    <div class="col-md-6">
      <label>Gender</label>
      <div class="panel panel-default">
        <div class="panel-body">

          <div style="width: 100%;margin: 0 auto;">
              {!! $gender->html() !!}
          </div>

        </div>
        <!-- ./panel-body -->
      </div>
      <!-- ./panel -->
    </div>

    <!-- ./col -->
    <div class="col-md-6">
      <label>Pembayaran</label>
      <div class="panel panel-default">
        <div class="panel-body">

          <div style="width: 100%;margin: 0 auto;">
              {!! $bayarChart->html() !!}
          </div>

        </div>
        <!-- ./panel-body -->
      </div>
      <!-- ./panel -->
    </div>

    <!-- ./col -->
    <div class="col-md-6">
      <label>Jersey</label>
      <div class="panel panel-default">
        <div class="panel-body">

          <div style="width: 100%;margin: 0 auto;">
              {!! $jersey->html() !!}
          </div>

        </div>
        <!-- ./panel-body -->
      </div>
      <!-- ./panel -->
    </div>

    <div class="col-md-6">
      <label>Komunitas</label>
      <div class="panel panel-default">
        <div class="panel-body">

          <div style="width: 100%;margin: 0 auto;">
              {!! $komunitas->html() !!}
          </div>

        </div>
        <!-- ./panel-body -->
      </div>
      <!-- ./panel -->
    </div>

    @else
      <div class="col-md-8 col-lg-offset-2">
        <div class="panel panel-default">
          <div class="panel-body" style="background-image:url('https://eo.portalsepeda.com/assets/img/no_event.svg'); height: 45vh;background-position: center;background-size: contain;background-repeat: no-repeat;">
            <h1 class="text-center" style="line-height:430px;">Anda belum memiliki event</h1>
          </div>
          <div class="panel-footer">
              <a class="btn btn-primary btn-block" href="{{URL::to(strtolower(str_replace(" ","_",Session::get('data')['full_name']).'/event/registrasi'))}}">Buat Event Langsung</a>
          </div>
        </div>
      </div>
    @endif
    
    <!-- ./col-md-4 -->
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->
{!! Charts::scripts() !!}
{!! $chart->script() !!}
{!! $gender->script() !!}
{!! $bayarChart->script() !!}
{!! $jersey->script() !!}
{!! $komunitas->script() !!}
@endsection

@push('scripts')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {{-- <script src="https://code.highcharts.com/highcharts.js"></script> --}}
    <script>
      $('.selEvent').on('change', function(){
        $('.cari').trigger('submit');
      });
    </script>
@endpush