<?php

namespace Uzinfocom\LaravelGenerator\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Uzinfocom\LaravelGenerator\Boot\Boot;
use Uzinfocom\LaravelGenerator\Models\ColumnType;
use Uzinfocom\LaravelGenerator\Services\Utils\EntityFinderService;
use Uzinfocom\LaravelGenerator\Services\Utils\TableFinderService;

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
    public Collection $tables;

    public Collection $types;

    public function __construct() {
        $this->columns = collect();
        $this->types = collect();
    }

    public function boot(EntityFinderService $modelFinder, TableFinderService $tableFinder = null): void {
        // Tables
        $this->tables = $tableFinder->getMigratedTables();

        // Types
        $this->types = collect();
        $types = Boot::getFromJson(Boot::getDatabase("data-types.json"));

        foreach ($types as $type) {
            $this->types->push(new ColumnType($type));
        }
    }

    public function choose(): void {
        if (!isset($this->tableName)) {
            $this->convertedName = "";
            return;
        }
    }

    public function render(): View {
        $columns = $this->columns;
        $tables = $this->tables;
        return view(Boot::getView('livewire.migration'), compact('columns', 'tables'));
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