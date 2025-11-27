<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedByToAcessosExternosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('acessos_externos', function (Blueprint $table) {
			$table->unsignedBigInteger('updated_by')->nullable()->after('observacao');
			$table->unsignedBigInteger('created_by')->nullable()->after('updated_by');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('acessos_externos', function (Blueprint $table) {
			$table->dropColumn(['updated_by', 'created_by']);
		});
	}
}
