<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Bill extends Model
{
    /** @use HasFactory<\Database\Factories\BillFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'amount',
        'due_date',
        'status',
    ];

    // Relação entre contas e usuários
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
