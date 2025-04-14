<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->string('status')->default('draft');
            $table->dropColumn(['name', 'total_hours', 'total_amount']);
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn(['client_id', 'date', 'due_date', 'total', 'status']);
            $table->string('name');
            $table->decimal('total_hours', 8, 2);
            $table->decimal('total_amount', 10, 2);
        });
    }
}; 