<?php

namespace Uzinfocom\LaravelGenerator\Services\Utils;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TableFinderService {

    public function getMigratedTables(): Collection {
        return DB::table('migrations')
            ->selectRaw("split_part(split_part(migration, '_create_', 2), '_table', 1) AS name, migration")
            ->get();
    }
}