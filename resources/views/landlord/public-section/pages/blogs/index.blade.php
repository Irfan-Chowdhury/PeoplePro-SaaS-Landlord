@php
    $generalSetting = DB::table('general_settings')
        ->latest()
        ->first();
@endphp


@extends('landlord.public-section.layouts.master')
@section('public-title', config('app.name').' | '.'Blogs')

@section('public-content')
    <section id="blog">
        <div class="container">
            <div class="row blog-list">
                <div class="col-md-6 offset-md-3 text-center mb-5">
                    <h2 class="regular">{{ __('file.All Blog Posts') }}</h2>
                </div>
                @foreach ($blogs as $blog)
                    <div class="col-md-6 offset-md-3 mb-5">
                        <a href="{{ route('landingPage.blogDetail', $blog->slug) }}">
                            <img src="{{ asset('landlord/images/blog/'.$blog->image) }}"
                                alt="{{ $blog->title }}" />
                            <h2 class="mt-3 text-center">{{ $blog->title }}</h2>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
