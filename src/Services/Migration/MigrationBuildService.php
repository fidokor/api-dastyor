<?php

namespace Uzinfocom\LaravelGenerator\Services\Migration;

use Uzinfocom\LaravelGenerator\Services\AllGenerator;

class MigrationBuildService extends AllGenerator {

    public function __construct() {
        $this->stab = 'migrations/migration.stub';
        $this->group = "_table.php";
    }

    public function create(array $data): void {
        // Read boilerplate from storage
        $boilerplate = $this->getStub();

        // Model
        $name = $data['name'];
        $namespace = $data['namespace'];

        // Columns
        $columns = $this->getColumns($data['columns']);

        $softDelete = $data['softDelete'] ? '$table->softDeletes();' : null;

        $content = str_replace([
            '{{ tableName }}',
            '{{ columns }}',
            '{{ softDelete }}',
        ], [
            $name,
            $columns,
            $softDelete,
        ], $boilerplate);


        // Make a director if it does not exist
        $location = $this->resolvePath($namespace);

        $fileName = now()->format('Y_m_d_His') . '_create_' . $data['name'];

        // Make ready boilerplate as Service $namespace/$name
        $this->make($location, $fileName, $content);
    }

    private function getColumns($columns): string {
        $columnDefinitions = [];

        foreach ($columns as $column) {
            $columnType = $column['type'];
            $columnName = $column['name'];
            $columnLength = $column['length'];
            $columnDefault = $column['default'];
            $isIndex = $column['index'] ? '->index()' : '';
            $isNullable = $column['nullable'] ? '->nullable()' : '';

            // Build the column definition
            $columnDefinition = "\$table->{$columnType}('{$columnName}'";

            // Append length for string types
            if ($columnType === 'string' && !empty($columnLength)) {
                $columnDefinition .= ", {$columnLength}";
            }

            // Append default value if provided
            if (!empty($columnDefault)) {
                $columnDefinition .= ")->default('{$columnDefault}')";
            } else {
                $columnDefinition .= ")";
            }

            // Add index and nullable options
            $columnDefinition .= $isIndex . $isNullable . ";\n";

            // Collect the column definitions
            $columnDefinitions[] = $columnDefinition;
        }

        // Combine all column definitions into a single string with desired formatting
        return "\r\t\t\t" . implode('', $columnDefinitions);
    }
}