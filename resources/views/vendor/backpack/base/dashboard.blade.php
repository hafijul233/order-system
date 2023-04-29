@extends(backpack_view('blank'))

@php

        $widgets['before_content'][] = [
            'type'        => 'jumbotron',
            'heading'     => trans('backpack::base.welcome'),
            'content'     => trans('backpack::base.use_sidebar'),
            'button_link' => backpack_url('logout'),
            'button_text' => trans('backpack::base.logout'),
        ];

@endphp

@section('header')
    <section class="container-fluid d-flex justify-content-between">
        <h2>
            <span class="text-capitalize">Dashboard</span>
            <small>Dashboard</small>
        </h2>
        @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs'))
    </section>
@endsection

@section('content')

@endsection
