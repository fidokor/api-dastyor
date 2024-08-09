<?php

namespace Uzinfocom\LaravelGenerator\Services\Migration;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Uzinfocom\LaravelGenerator\Services\AllGenerator;

class MigrationBuildService extends AllGenerator {

    private readonly AdvancedMigrationCreator $creator;

    public function __construct() {
        $this->stab = 'migrations/migration.stub';
        $this->group = "";

        $this->creator = new AdvancedMigrationCreator(new Filesystem(), '');
    }

    public function create(array $data): void {
        // Read boilerplate from storage
        $boilerplate = $this->getStub();

        // Model
        $name = $data['name'];
        $namespace = $data['namespace'];

        // Columns
        $columns = $this->getColumns($data['columns']);

        $content = str_replace([
            '{{ tableName }}',
            '{{ columns }}'
        ], [
            $name,
            $columns,
            $namespace,
        ], $boilerplate);

        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        // Make ready boilerplate as Service $namespace/$name
        $this->make($location, $this->creator->getExtendedPath($name), $content);
    }

    private function getColumns(array $columns): string {
        $columnsStack = "";
        foreach ($columns as $column) {
            if (Arr::get($column, 'relation')) {
                $this->stab = "migrations/column.related.stub";
            } else {
                $this->stab = "migrations/column.stub";
            }

            $boilerplate = $this->getStub();

            $columnsStack .= str_replace([
                '{{ columnType }}',
                '{{ columnName }}',
                '{{ tableName }}',
            ], [
                $column['type'],
                $column['name'],
                $column['relation'],
            ], $boilerplate);;
        }

        return $columnsStack;
    }
}