@extends('layouts.app')

@section('title', __('admin.News list'))

@section('content')

<div class="container">
        <div class="row">
            {{-- <div class="card-deck"> --}}

                @foreach ($posts as $data)
                {{-- <div class="col"> --}}
                    <div class="card mb-3" style="width:100%">
                        @if($data->img_url)
                            <img class="card-img-top" style="max-height: 300px; object-fit: contain;" src="{{ $data->img_url }}" alt="{{ $data->purified_title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ $data->title }}</h5>
                            <p class="card-text">
                                {!! $data->purified_excerpt !!}
                            </p>
                        </div>
                        <div class="card-footer">
                            <div>Date: {{ $data->created_at->format('d.m.Y/H:m') }}</div>
                            <div>Language: {{ $data->language }}</div>
                            <div>Link: <a href="{{ $data->link }}" target="_blank">{{ $data->link }}</a></div>
                        </div>
                    </div>
                {{-- </div> --}}
                @endforeach

            {{-- </div> --}}
        </div>

        <div class="col-12">
            {{ $posts->links() }}
        </div>
</div>

@endsection