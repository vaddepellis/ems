<?php

use App\Enum\Status;
use App\Models\User;
use App\Enum\LeaveType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->string('reason');
            $table->text('discription');
            $table->string('from');
            $table->string('to');
            $table->string('updated_by')->nullable();
            $table->enum('leave_type',LeaveType::values())->default(LeaveType::FULL_DAY->value);
            $table->decimal('leave_value',4,2)->default(1.00);
            $table->decimal('leave_available',4,2)->default(0.00);
            $table->decimal('leave_used',4,2)->default(0.00);
            $table->enum('leave_status',Status::values())->default(Status::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
