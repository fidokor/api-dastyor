@extends(config('generator.layout'))
@section('title')
    {{ "M" }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-lg-12">
            <livewire:migration-wire/>
        </div>
    </div>
@endsection
