@extends('layouts.app')

@section('title', __('admin.Admin'))

@section('content')

    <div class="container">
        <div class="row">

            {{-- Content --}}
            <div class="col-12">
                <div>
                    <a href="{{ route('admin.news', $app->getLocale()) }}">{{ __('admin.News') }}</a>
                </div>
            </div>

        </div>
    </div>

@endsection