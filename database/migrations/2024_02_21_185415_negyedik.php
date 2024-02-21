<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        //Vegyél fel egy mennyiség (quantity) mezőt a products táblában! (A kosárban most az egyszerűség kedvéért csak egy termék lehet).
        //Ha törölnek egy kosár rekordot, akkor növeld eggyel a quantity értékét triggerrel vagy Observerrel!
        DB::unprepared('CREATE TRIGGER negyedik AFTER DELETE ON baskets FOR EACH ROW
        BEGIN 
        UPDATE products  SET quantity = 1 WHERE item_id = OLD.item_id 
        END');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
