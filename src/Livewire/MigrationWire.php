<?php

namespace Uzinfocom\LaravelGenerator\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Uzinfocom\LaravelGenerator\Boot\Boot;
use Uzinfocom\LaravelGenerator\Services\Utils\ModelFinderService;

class MigrationWire extends GeneratorWire {

    public string $tableName;
    public string $convertedName;

    public array $meta = [
        'description' => "Jadval quruvchi",
        'route' => "migrations.store"
    ];

    public string $prefix = "database\migrations\\";
    public string $namespace = "database\migrations";

    public Collection $columns;

    public Collection $types;

    public function __construct() {
        $this->columns = collect();
        $this->types = collect();

        // Types
        $types = File::get(Boot::getDatabase("postgres.types.json"));
        foreach (json_decode($types) as $type) {
            $this->types->push($type);
        }
    }

    public function boot(ModelFinderService $modelFinder): void { }

    public function choose(): void {
        if (!isset($this->tableName)) {
            $this->convertedName = "";
            return;
        }
    }

    public function render(): View {
        $columns = $this->columns;
        return view(Boot::getView('livewire.migration'), compact('columns'));
    }

    /*** Custom methods ***/
    public function addColumn(): void {
        $this->columns->push([
            "name" => "",
            "type" => "",
            "length" => "",
            "autoIncrement" => false,
            "unsigned" => false,
            "default" => 0
        ]);
    }
}
