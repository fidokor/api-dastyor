<?php

namespace Uzinfocom\LaravelGenerator\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Uzinfocom\LaravelGenerator\Services\Utils\ModelFinderService;

class GenerateModel extends AllGenerator {

    public $belongsToStub;
    public $hasManyStub;
    public string $useRelations = '';

    public function __construct() {
        $this->stab = 'model.stub';
        $this->belongsToStub = 'relation.belongsTo.stub';
        $this->hasManyStub = 'relation.hasMany.stub';
        $this->group = ".php";
    }

    public function generate(array $table, string $name, string $namespace): void {
        //relations
        $belongsTo = $this->belongsToRelations($table['name']);
        $hasMany = $this->hasManyRelations($table['name']);

        $columns = $this->getTableColumns($table['name']);
        // Annotated properties
        $properties = $this->getProperties($columns);
        // Fillable fields
        $attributes = $this->getAttributes($columns);

        // Read boilerplate from storage
        $stub = $this->getStub();
        $content = str_replace([
            '{{ model }}',
            '{{ namespace }}',
            '{{ properties }}',
            '{{ attributes }}',
            '{{ belongsTo }}',
            '{{ hasMany }}',
            '{{ useRelations }}',
        ], [
            $name,
            $namespace,
            $properties,
            $attributes,
            $belongsTo,
            $hasMany,
            $this->useRelations
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

    protected function getProperties($columns): string {
        $annotations = [];
        foreach ($columns as $column => $type) {
            $annotations[] = " * @property \${$column}";
        }
        return implode("\n", $annotations);
    }

    protected function getAttributes($columns): string {
        $fillable = array_keys($columns);
        $fillable = array_diff($fillable, ['id', 'created_at', 'updated_at', 'deleted_at']);
        return "['" . implode("', '", $fillable) . "']";
    }

    protected function belongsToRelations($tableName): string {
        $foreignKeys = DB::table('information_schema.table_constraints as tc')
            ->join('information_schema.key_column_usage as kcu', function($join) {
                $join->on('tc.constraint_name', '=', 'kcu.constraint_name')
                    ->on('tc.table_name', '=', 'kcu.table_name');
            })
            ->join('information_schema.constraint_column_usage as ccu', 'ccu.constraint_name', '=', 'tc.constraint_name')
            ->where('tc.constraint_type', 'FOREIGN KEY')
            ->where('tc.table_name', $tableName)
            ->select('kcu.column_name', 'ccu.table_name as referenced_table_name', 'ccu.column_name as referenced_column_name')
            ->get();

        $stub = $this->getRelationStub($this->belongsToStub);
        $modelFinder = new ModelFinderService();
        $models = $modelFinder->getModels(app_path());

        $content = [];
        foreach ($foreignKeys as $foreignKey) {
            $model = collect($models)->first(function($model) use ($foreignKey) {
                return app()->make($model)->getTable() === $foreignKey->referenced_table_name;
            });
            $model = '\\' . ($model ?? ('App\Models\\' . Str::studly(Str::singular($foreignKey->referenced_table_name))));
            $methodName = Str::camel($foreignKey->referenced_table_name);

            $content[] = str_replace([
                '{{ relationName }}',
                '{{ relatedModel }}',
                '{{ foreignKey }}',
                '{{ ownKey }}',
            ], [
                $methodName,
                $model,
                $foreignKey->column_name,
                $foreignKey->referenced_column_name
            ], $stub);
        }

        $this->useRelations .= (count($content) > 0) ? (($this->useRelations ? "\n" : '') . "use Illuminate\Database\Eloquent\Relations\BelongsTo;") : '';

        return implode($content);
    }

    protected function hasManyRelations($tableName): string {
        $childTables = DB::table('information_schema.table_constraints as tc')
            ->join('information_schema.key_column_usage as kcu', function($join) {
                $join->on('tc.constraint_name', '=', 'kcu.constraint_name')
                    ->on('tc.table_name', '=', 'kcu.table_name');
            })
            ->join('information_schema.constraint_column_usage as ccu', 'ccu.constraint_name', '=', 'tc.constraint_name')
            ->where('tc.constraint_type', 'FOREIGN KEY')
            ->where('ccu.table_name', $tableName)  // The table you want to check for references
            ->select('tc.table_name as child_table', 'kcu.column_name as child_column', 'ccu.column_name as parent_column')
            ->get();

        $stub = $this->getRelationStub($this->hasManyStub);
        $modelFinder = new ModelFinderService();
        $models = $modelFinder->getModels(app_path());

        $content = [];
        foreach ($childTables as $foreignKey) {
            $model = collect($models)->first(function($model) use ($foreignKey) {
                return app()->make($model)->getTable() === $foreignKey->child_table;
            });
            $model = '\\' . ($model ?? ('App\Models\\' . Str::studly(Str::singular($foreignKey->child_table))));
            $methodName = Str::camel($foreignKey->child_table);

            $content[] = str_replace([
                '{{ relationName }}',
                '{{ relatedModel }}',
                '{{ foreignKey }}',
                '{{ ownKey }}',
            ], [
                $methodName,
                $model,
                $foreignKey->child_column,
                $foreignKey->parent_column
            ], $stub);
        }

        $this->useRelations .= (count($content) > 0) ? (($this->useRelations ? "\n" : '') . "use Illuminate\Database\Eloquent\Relations\HasMany;") : '';

        return implode($content);
    }
}
