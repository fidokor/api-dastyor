<div class="card mb-4">
    <form action="{{ route($meta['route']) }}" method="post">
        <div class="card-header">
            <h5 class="card-tile mb-0">
                {{ $meta['description'] }}
            </h5>

            <div class="row mt-3">
                <div class="col-4">
                    <div class="form-group">
                        <label for="name" class="form-label">Jadval nomi</label>
                        <input type="text" name="name" id="name"
                               class="form-control" autocomplete="off" required>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="scheme" class="form-label">Sxema nomi</label>
                        <select type="text" name="scheme" id="scheme" class="form-select">
                            <option value="">Sxemani tanlang</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <br>
                    <button type="button" class="btn btn-info" wire:click="addColumn">
                        <i class="ti ti-plus"></i>
                        <span>Qo&#8216;shish</span>
                    </button>
                </div>
            </div>

            <div class="alert alert-primary mt-3" role="alert">
                <span>ID va sanalar kerak emas!</span>
            </div>
        </div>

        <div class="card-body">
            @csrf

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Ustun nomi</th>
                            <th>Ustun turi</th>
                            <th>&nbsp;&nbsp;&nbsp;&nbsp;Uzunligi</th>
                            <th>Boshlang&#8216;ich</th>
                            <th>Indekslangan</th>
                            <th>Bog&#8216;lanish</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="mb-3"></div>
            @foreach($columns as $key => $column)
                @php
                    $name = "columns[$key]";
                @endphp

                <div class="row mb-3">
                    <div class="col-xl">
                        <input type="text" name="{{$name}}[name]" id="{{$name}}[name]"
                               wire:model="columns.{{$key}}.name"
                               placeholder="Nomi"
                               class="form-control" autocomplete="off" required>
                    </div>

                    <div class="col-xl">
                        <select name="{{$name}}[type]" id="{{$name}}[type]"
                                wire:model="columns.{{$key}}.type"
                                class="form-select" required>
                            <option value="">Turi tanlang</option>
                            @foreach($types as $type)
                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-xl">
                        <input type="number" name="{{$name}}[length]" id="{{$name}}[length]"
                               wire:model="columns.{{$key}}.length"
                               placeholder="Uzunligi"
                               class="form-control">
                    </div>

                    <div class="col-xl">
                        <select name="{{$name}}[default]" id="{{$name}}[default]"
                                wire:model="columns.{{$key}}.default"
                                class="form-select">
                            <option value="">Birlamchi</option>
                            <option value="null">Bo&#8216;sh (null)</option>
                            <option value="value">Qiymat</option>
                        </select>
                    </div>

                    <div class="col-xl">
                        <input type="checkbox" name="{{$name}}[index]" id="{{$name}}[index]"
                               wire:model="columns.{{$key}}.index"
                               placeholder="Indeks">
                    </div>

                    <div class="col-xl">
                        <select name="{{$name}}[relation]" id="{{$name}}[relation]"
                                wire:model="columns.{{$key}}.relation"
                                class="form-select">
                            <option value="">Jadvalni tanlang</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->name }}">{{ $table->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach

            @if($this->columns->isEmpty())
                <div class="fw-bold text-center">Ustunlar shu yerda yaratiladi!</div>
            @endif

            <div class="row mt-5">
                <label class="form-label" for="package">Papka (Namespace)</label>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light" id="">{{ $prefix }}</span>
                    <input type="text" name="" id="package" wire:model="package" wire:keyup="change"
                           class="form-control" placeholder="Nomi" aria-describedby="basic">
                </div>
            </div>

            <!-- Namespace -->
            <input type="hidden" name="namespace" value="{{ $namespace }}">

            <button type="submit" class="btn btn-primary">Saqlash</button>
        </div>
    </form>
</div>