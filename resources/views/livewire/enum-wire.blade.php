<div class="card mb-4" id="enum">
    <div class="card-header">
        <h5 class="card-tile mb-0">{{ $meta['description'] }}</h5>
    </div>

    <div class="card-body">
        <form action="{{ route($meta['route']) }}" method="post">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Nomi</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="form-group">
                <label for="type" class="form-label">Turi</label>
                <select class="form-select" name="type" id="type">
                    <option value="int">int</option>
                    <option value="string">string</option>
                </select>
            </div>

            <div class="d-flex gap-3 mt-3">
                <div class="form-group flex-grow-1">
                    <input type="text" class="form-control" name="variables[0][key]" id="variables[0][key]">
                </div>
                <div class="form-group flex-grow-1">
                    <input type="text" class="form-control" name="variables[0][value]" id="variables[0][value]">
                </div>
                <button class="btn btn-primary btn-sm" id="addInput" type="button">
                    <i class="ti ti-plus"></i>
                </button>
            </div>

            <div id="newInput"></div>

            <div class="form-group">
                <label class="form-label" for="package">Papka (Namespace)</label>
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light" id="">App\Enums\</span>
                    <input type="text" name="package" id="package" wire:model="package" wire:keyup="change"
                           class="form-control" placeholder="Nomi" aria-describedby="basic">
                </div>

                <!-- Namespace -->
                <input type="hidden" name="namespace" value="{{ $namespace }}">

                <button class="btn btn-primary">Saqlash</button>
            </div>
        </form>
    </div>
</div>
@push('js')
    <script type="text/javascript">
        let i = 1;
        $("#addInput").click(function () {
            const newRowAdd = `
            <div class="row">
                <div class="d-flex gap-3 mt-3">
                    <div class="form-group flex-grow-1">
                        <input type="text" class="form-control" name="variables[${i}][key]" id="variables[${i}][key]">
                    </div>
                    <div class="form-group flex-grow-1">
                        <input type="text" class="form-control" name="variables[${i}][value]" id="variables[${i}][value]">
                    </div>
                    <button class="btn btn-danger btn-sm" id="deleteInput" type="button">
                        <i class="ti ti-http-delete"></i>
                    </button>
                </div>
            </div>`;

            $('#newInput').append(newRowAdd);
            i++;
        });
        $("body").on("click", "#deleteInput", function () {
            $(this).parents(".d-flex").remove();
        })
    </script>
@endpush
