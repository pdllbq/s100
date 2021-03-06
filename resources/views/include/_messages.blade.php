@if($errors->any())
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
        <ul>
          @foreach($errors->all() as $errorTxt)
            <li>{{ $errorTxt }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endif

@if(session('error'))
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
        {{ session()->get('error') }}
      </div>
    </div>
  </div>
</div>
@endif

@if(session('success'))
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
        {{ session()->get('success') }}
      </div>
    </div>
  </div>
</div>
@endif