<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Arabic columns the models and controllers use but no earlier migration
 * added. Each column is only added when absent, so this is safe to run on
 * databases that already have them.
 */
return new class extends Migration
{
    private array $columns = [
        'equipes' => [
            'NomAR' => 'string',
            'ProfessionAR' => 'string',
            'DescriptionAR' => 'text',
        ],
        'faqs' => [
            'QuestionAR' => 'text',
            'ReponseAR' => 'text',
        ],
        'horaires' => [
            'Day_Start_AR' => 'string',
        ],
        'row_services' => [
            'TextAR' => 'longText',
        ],
        'services' => [
            'NomAR' => 'string',
            'DescriptionsAR' => 'text',
        ],
    ];

    public function up(): void
    {
        foreach ($this->columns as $tableName => $columns) {
            $toAdd = array_filter(
                $columns,
                fn ($column) => !Schema::hasColumn($tableName, $column),
                ARRAY_FILTER_USE_KEY
            );

            if (!$toAdd) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($toAdd) {
                foreach ($toAdd as $column => $type) {
                    $table->{$type}($column)->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // Intentionally left empty: these columns may pre-date this migration
        // on existing databases, so rolling back must not drop them.
    }
};
