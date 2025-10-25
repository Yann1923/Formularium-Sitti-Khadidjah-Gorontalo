<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->string('therapy_class')->nullable()->after('name');
            $table->string('sub_therapy_class')->nullable()->after('therapy_class');
            $table->string('sediaan')->nullable()->after('dosage_form');
            $table->string('kekuatan')->nullable()->after('strength');
            $table->string('satuan')->nullable()->after('kekuatan');
            $table->integer('peresepan_maksimal')->nullable()->after('satuan');
            $table->text('restriksi_kelas_terapi')->nullable()->after('peresepan_maksimal');
            // other textual fields (already exist or mapping)
            $table->text('indications')->nullable()->change();
            $table->text('contraindications')->nullable()->change();
            $table->text('side_effects')->nullable()->change();
            $table->text('dosage_instructions')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn([
                'therapy_class',
                'sub_therapy_class',
                'sediaan',
                'kekuatan',
                'satuan',
                'peresepan_maksimal',
                'restriksi_kelas_terapi',
            ]);
        });
    }
};