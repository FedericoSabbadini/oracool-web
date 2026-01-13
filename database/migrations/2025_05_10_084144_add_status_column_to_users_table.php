<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add admin status, admin key, and points columns to the users table.
 *
 * This migration adds three new columns to the existing 'users' table:
 * - `admin`: a boolean indicating if the user is an admin (default is false).
 * - `adminKey`: a nullable string for storing an admin key.
 * - `points`: a decimal field for storing points, with a precision of 6 and scale of 3 (default is 0).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('admin')->default(false);
            $table->string('adminKey')->nullable();
            $table->decimal('points', 6, 3)->default(0)->after('adminKey');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['admin', 'adminKey', 'points']);

        });
    }
};