<?php

namespace Uzinfocom\LaravelGenerator\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\File;
use Uzinfocom\LaravelGenerator\Boot\Boot;
use Uzinfocom\LaravelGenerator\Services\Utils\EntityFinderService;
use Uzinfocom\LaravelGenerator\Services\Migration\MigrationBuildService;


class MigrationWire extends GeneratorWire {

    public array $meta = [
        'description' => "Jadval yaratuvchi",
        'route' => "migrations.store"
    ];

    public string $prefix = "database\migrations\\";

    public string $namespace = "database\migrations";

    #[Validate('required|min:4')]
    public $name = '';

    #[Validate('boolean')]
    public $softDelete = false;

    #[Validate([
        'columns.*.name' => 'required|string',
        'columns.*.type' => 'required|string',
        'columns.*.default' => 'nullable',
        'columns.*.index' => 'required|boolean',
        'columns.*.nullable' => 'required|boolean',
        'columns.*.length' => 'nullable',
        'columns.*.auto' => 'nullable',
    ])]
    public Collection $columns;
    public Collection $types;

    public function __construct() {
        $this->columns = collect();
        $this->types = collect();

        // Types
        $types = File::get(Boot::getDatabase("data-types.json"));
        foreach (json_decode($types) as $type) {
            $this->types->push($type);
        }
    }

    public function boot(EntityFinderService $modelFinder): void { }

    /*** Custom methods ***/
    public function addColumn(): void {
        $this->columns->push([
            "name" => null,
            "type" => null,
            "length" => null,
            "default" => null,
            "nullable" => false,
            "index" => false,
            "unsigned" => false,
            "autoIncrement" => false,
        ]);
    }

    public function save(MigrationBuildService $service): void {
        $this->validate();

        $service->create([
            'name' => $this->name,
            "softDelete" => $this->softDelete,
            'namespace' => $this->namespace,
            'columns' => $this->columns
        ]);
        session()->flash('success', 'Migration created successfully.');
    }

    public function render(): View {
        $columns = $this->columns;
        return view(Boot::getView('livewire.migration'), compact('columns'));
    }
}