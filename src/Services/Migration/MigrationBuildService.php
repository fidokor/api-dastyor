<?php

namespace Uzinfocom\LaravelGenerator\Services\Migration;

use Uzinfocom\LaravelGenerator\Services\AllGenerator;

class MigrationBuildService extends AllGenerator {

    public function __construct() {
        $this->stab = 'migrations/migration.stub';
        $this->group = "migration.php";
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
        $this->make($location, $name, $content);
    }

    private function getColumns(array $columns): string {
        $columnsStack = "\r\t";
        foreach ($columns as $column) {
            $columnsStack .= "\$table->{$column['type']}('{$column['type']}');\n";
        }

        return $columnsStack;
    }
}