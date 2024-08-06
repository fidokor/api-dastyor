@extends(config('generator.layout'))
@section('content')
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
    </div>
@endsection
