@extends(config('generator.layout'))
@php use Uzinfocom\LaravelGenerator\Boot\Boot; @endphp
@section('title')
    {{ "M" }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <small class="text-light fw-medium">Vertical Icons</small>
            <div class="bs-stepper vertical wizard-modern wizard-modern-vertical-icons-example mt-2">
                @include(Boot::getView('layouts.menu'))
                <div class="bs-dark-stepper-content">
                    <div class="content {{ request()->routeIs('migration.*') ? 'active' : '' }}">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <livewire:migration-wire/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
