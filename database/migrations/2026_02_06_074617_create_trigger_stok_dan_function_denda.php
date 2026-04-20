<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 🔥 DROP dulu agar tidak duplicate
        DB::unprepared("DROP TRIGGER IF EXISTS kurangi_stok_alat;");
        DB::unprepared("DROP FUNCTION IF EXISTS hitung_denda;");

        // =========================
        // TRIGGER
        // =========================
        DB::unprepared('
            CREATE TRIGGER kurangi_stok_alat
            AFTER UPDATE ON peminjamans
            FOR EACH ROW
            BEGIN
                IF NEW.status = "disetujui" AND OLD.status = "menunggu" THEN
                    UPDATE alats 
                    SET stok = stok - 1 
                    WHERE id = NEW.alat_id;
                END IF;
            END
        ');

        // =========================
        // FUNCTION
        // =========================
        DB::unprepared('
            CREATE FUNCTION hitung_denda(tgl_rencana DATE, tgl_aktual DATE)
            RETURNS DECIMAL(10,2)
            DETERMINISTIC
            BEGIN
                DECLARE selisih INT;
                DECLARE total_denda DECIMAL(10,2);

                SET selisih = DATEDIFF(tgl_aktual, tgl_rencana);

                IF selisih > 0 THEN
                    SET total_denda = selisih * 5000;
                ELSE
                    SET total_denda = 0;
                END IF;

                RETURN total_denda;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS kurangi_stok_alat;");
        DB::unprepared("DROP FUNCTION IF EXISTS hitung_denda;");
    }
};