@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('summernote.post') }}">

    {{ csrf_field() }}

	<div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Details:</strong>

            <textarea class="form-control summernote" name="detail"></textarea>

        </div>

     </div>

     <div class="col-xs-12 col-sm-12 col-md-12 text-center">

        <button type="submit" class="btn btn-primary">Submit</button>

    </div>

</form>

<script type="text/javascript">

    $(document).ready(function() {

     $('.summernote').summernote({

           height: 300,

      });

   });

</script>

@endsection	