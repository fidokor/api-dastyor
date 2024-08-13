@php use Uzinfocom\LaravelGenerator\Boot\Boot; @endphp
@extends(config('generator.layout'))
@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <small class="text-light fw-medium">Vertical Icons</small>
            <div class="bs-stepper vertical wizard-modern wizard-modern-vertical-icons-example mt-2">
                @include(Boot::getView('layouts.menu'))
                <div class="bs-dark-stepper-content">
                    <div class="content {{ request()->routeIs('generator.*') ? 'active' : '' }}">
                        <div class="row">
                            <div class="col-6 col-lg-6">
                                <livewire:model-wire/>
                            </div>
                            <div class="col-6 col-lg-6">
                                <livewire:controller-wire/>
                            </div>
                            <div class="col-4">
                                <livewire:request-wire/>
                            </div>
                            <div class="col-4">
                                <livewire:service-wire/>
                            </div>
                            <div class="col-4">
                                <livewire:resource-wire/>
                            </div>
                            <div class="col-4">
                                <livewire:method-wire/>
                            </div>
                            <div class="col-4">
                                <livewire:model-relation-wire/>
                            </div>
                            <div class="col-4">
                                <livewire:enum-wire/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
