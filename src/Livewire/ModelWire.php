<?php

namespace Uzinfocom\LaravelGenerator\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Uzinfocom\LaravelGenerator\Boot\Boot;

class ModelWire extends GeneratorWire {

    public string $tableName;
    public string $convertedName;

    public array $meta = [
        'description' => "Model yaratuvchi",
        'route' => "models.store"
    ];

    public string $prefix = "App\Models\\";
    public string $namespace = "App\Models";

    public function choose(): void {
        if (!isset($this->tableName)) {
            $this->convertedName = "";
            return;
        }

        $string = Str::replace('_', ' ', $this->tableName);
        $string = ucwords($string);
        $string = Str::replace(' ', '', $string);
        $this->convertedName = Str::singular($string);
    }

    public function render(): View {
        $tables = DB::table('migrations')
            ->selectRaw("split_part(split_part(migration, '_create_', 2), '_table', 1) AS name, migration")
            ->get();
        return view(Boot::getView('livewire.model-wire'), compact('tables'));
    }
}
