@extends('layouts_app.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header row">
  <div class="col-md-6">
    <h4>
      <i class="fa fa-line-chart" aria-hidden="true"></i>
      Event Berlangsung
    </h4>
  </div>
  <div class="col-md-4">
    <form>
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
      <a style="    margin-top: 15px;" class="btn btn-primary btn-block" href="{{URL::to(strtolower(str_replace(" ","_",Session::get('data')['full_name']).'/event/registrasi'))}}"><i class="fa fa-plus" aria-hidden="true"></i> Buat Event</a>
  </div>
</section>

<!-- Main content -->
<section class="content" style="min-height:0px !important;">
  <!-- Default row -->
  
  <div class="col-md-12" style="margin-top:50px;margin-bottom:10px;">
    
    <!-- ./col -->
    <div class="col-md-6">
      <label>Event</label>
      <div class="panel panel-default">
        <div class="panel-body">

          <div style="width: 80%;margin: 0 auto;">
              {!! $chart->container() !!}
          </div>

        </div>
        <!-- ./panel-body -->
      </div>
      <!-- ./panel -->
    </div>

    <div class="col-md-6">
      <label>Gender</label>
      <div class="panel panel-default">
        <div class="panel-body">

          <div style="width: 80%;margin: 0 auto;">
              {!! $gender->container() !!}
          </div>

        </div>
        <!-- ./panel-body -->
      </div>
      <!-- ./panel -->
    </div>
    
    <div class="col-md-6">
      <label>Pembayaran</label>
      <div class="panel panel-default">
        <div class="panel-body">
          <div style="width: 80%;margin: 0 auto;">
              {!! $bayar->container() !!}
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
          <div style="width: 80%;margin: 0 auto;">
              {!! $komunitas->container() !!}
          </div>

        </div>
        <!-- ./panel-body -->
      </div>
      <!-- ./panel -->
    </div>
    
    <div class="col-md-6">
      <label>Jersey</label>
      <div class="panel panel-default">
        <div class="panel-body">
          <div style="width: 80%;margin: 0 auto;">
              {!! $jersey->container() !!}
          </div>

        </div>
        <!-- ./panel-body -->
      </div>
      <!-- ./panel -->
    </div>
    
    <!-- ./col-md-4 -->
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->
@endsection

@push('scripts')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {{-- <script src="https://code.highcharts.com/highcharts.js"></script> --}}
    {!! $chart->script() !!}
    {!! $gender->script() !!}
    {!! $bayar->script() !!}
    {!! $komunitas->script() !!}
    {!! $jersey->script() !!}
    
    <script type="text/javascript">
    //   $(".selEvent").change(function(){
    //       var event = $(this).val();
    //       //alert(event);
    //   });
      
    //   var original_api_url = {{ $chart->id }}_api_url;
      
    //   $(".event").change(function(){
    //       var year = $(this).val();
          
    //   });
      
      
    //   var original_api_url = {{ $gender->id }}_api_url;
      
    //   $(".selEvent").change(function(){
    //       var event = $(this).val();
          
    //   });
      
    //   var original_api_url_bayar = {{ $bayar->id }}_api_url;
      
    //   $(".selEvent").change(function(){
    //       var event = $(this).val();
          
    //   });
      
    //   var original_api_url_kom = {{ $komunitas->id }}_api_url;
      
    //   $(".selEvent").change(function(){
    //       var event = $(this).val();
          
    //   });
      
    //   var original_api_url_jersey = {{ $jersey->id }}_api_url;
      
    //   $(".selEvent").change(function(){
    //       var event = "{{$id_event}}";
    //       {{ $jersey->id }}_refresh(original_api_url_jersey + "?event="+event);
    //   });
      $(window).on('load',function(){
          var event = "{{$id_event}}";
          var original_api_url = {{ $chart->id }}_api_url;
          var original_api_url_gender = {{ $gender->id }}_api_url;
          var original_api_url_jersey = {{ $jersey->id }}_api_url;
          var original_api_url_kom = {{ $komunitas->id }}_api_url;
          var original_api_url_bayar = {{ $bayar->id }}_api_url;
          console.log(event)
            {{ $jersey->id }}_refresh(original_api_url_jersey + "?event="+event); 
            {{ $chart->id }}_refresh(original_api_url + "?event="+event);
            {{ $gender->id }}_refresh(original_api_url_gender + "?event="+event);
            {{ $bayar->id }}_refresh(original_api_url_bayar + "?event="+event);
            {{ $komunitas->id }}_refresh(original_api_url_kom + "?event="+event);
      });

      $('.selEvent').on('change', function(){
        $('.cari').trigger('click');
      });
    </script>

@endpush