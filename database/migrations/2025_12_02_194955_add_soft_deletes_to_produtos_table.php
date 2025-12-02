<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToProdutosTable extends Migration
{
	public function up(): void
	{
		Schema::table('produtos', function (Blueprint $table) {
			if (!Schema::hasColumn('produtos', 'deleted_at')) {
				$table->softDeletes(); // cria a coluna deleted_at
			}
		});
	}

	public function down(): void
	{
		Schema::table('produtos', function (Blueprint $table) {
			if (Schema::hasColumn('produtos', 'deleted_at')) {
				$table->dropColumn('deleted_at');
			}
		});
	}
}
