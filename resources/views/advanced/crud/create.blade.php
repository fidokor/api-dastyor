@extends(config('generator.layout'))
@php use Uzinfocom\LaravelGenerator\Boot\Boot; @endphp
@section('content')
    <div class="content {{ request()->routeIs('advanced.*') ? 'active' : '' }}">
        <div class="row">
            <div class="col-12">
                <livewire:advanced-crud-wire/>
            </div>
        </div>
    </div>
@endsection