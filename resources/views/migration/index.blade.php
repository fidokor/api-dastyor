@extends(config('generator.layout'))
@section('title')
    {{ "M" }}
@endsection
@section('content')
    <div class="content {{ request()->routeIs('migration.*') ? 'active' : '' }}">
        <livewire:migration-wire/>
    </div>
    <div class="row h-100"></div>
@endsection
