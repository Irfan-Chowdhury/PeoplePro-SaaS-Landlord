<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->string('amount', 30);
            $table->string('category', 30);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->mediumText('description')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->unsignedBigInteger('payee_id')->nullable();
            $table->unsignedBigInteger('payer_id')->nullable();
            $table->string('expense_reference', 191)->nullable();
            $table->string('expense_file', 191)->nullable();
            $table->date('expense_date')->nullable();
            $table->string('deposit_reference', 191)->nullable();
            $table->string('deposit_file', 191)->nullable();
            $table->date('deposit_date')->nullable();
            $table->timestamps();

            $table->foreign('account_id', 'finance_transactions_account_id_foreign')->references('id')->on('finance_bank_cashes')->onDelete('set NULL');
            $table->foreign('category_id', 'finance_transactions_category_id_foreign')->references('id')->on('expense_types')->onDelete('set NULL');
            $table->foreign('company_id', 'finance_transactions_company_id_foreign')->references('id')->on('companies')->onDelete('set NULL');
            $table->foreign('payee_id', 'finance_transactions_payee_id_foreign')->references('id')->on('finance_payees')->onDelete('set NULL');
            $table->foreign('payer_id', 'finance_transactions_payer_id_foreign')->references('id')->on('finance_payers')->onDelete('set NULL');
            $table->foreign('payment_method_id', 'finance_transactions_payment_method_id_foreign')->references('id')->on('payment_methods')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_transactions', function (Blueprint $table) {
            $table->dropForeign('finance_transactions_account_id_foreign');
            $table->dropForeign('finance_transactions_category_id_foreign');
            $table->dropForeign('finance_transactions_company_id_foreign');
            $table->dropForeign('finance_transactions_payee_id_foreign');
            $table->dropForeign('finance_transactions_payer_id_foreign');
            $table->dropForeign('finance_transactions_payment_method_id_foreign');
            $table->dropIfExists('finance_transactions');
        });
    }
}
