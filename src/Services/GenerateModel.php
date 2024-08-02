<?php

namespace Ijodkor\LaravelGenerator\Services;

use Illuminate\Support\Facades\Schema;

class GenerateModel extends AllGenerator {

    public function __construct() {
        $this->stab = 'model.stub';
        $this->group = "Model.php";
    }

    public function generate(array $table, string $name, string $namespace): void {
        $columns = $this->getTableColumns($table['name']);
        $properties = $this->generatePropertyAnnotations($columns);
        $attributes = $this->generateFillableProperties($columns);

        // Read boilerplate from storage
        $stub = $this->getStub();
        $content = str_replace([
            '{{ model }}',
            '{{ namespace }}',
            '{{ properties }}',
            '{{ attributes }}',
        ], [
            $name,
            $namespace,
            $properties,
            $attributes,
        ], $stub);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$name
        $this->make($location, $name, $content);
    }

    protected function getTableColumns($table): array {
        $columns = Schema::getColumnListing($table);
        $columnDetails = [];

        foreach ($columns as $column) {
            $columnDetails[$column] = Schema::getColumnType($table, $column);
        }

        return $columnDetails;
    }

    protected function generatePropertyAnnotations($columns): string {
        $annotations = [];
        foreach ($columns as $column => $type) {
            $annotations[] = " * @property \${$column}";
        }
        return implode("\n", $annotations);
    }

    protected function generateFillableProperties($columns): string {
        $fillable = array_keys($columns);
        $fillable = array_diff($fillable, ['id', 'created_at', 'updated_at', 'deleted_at']);
        return "['" . implode("', '", $fillable) . "']";
    }
}
