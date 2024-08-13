@extends(config('generator.layout'))
@section('content')
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
@endsection
