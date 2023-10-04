@if (Session::has('success'))
  <div class="col-md-6 pt-3" style="margin-left: 260px">
    <div class="alert alert-success">
      {{ Session::get('success') }}
    </div>  
  </div> 
@endif

@if ($errors->any())
  <div class="col-md-6 pt-3" style="margin-left: 260px">
    <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $item)
              <li>{{ $item }}</li>
          @endforeach
      </ul>  
    </div>  
  </div> 
@endif