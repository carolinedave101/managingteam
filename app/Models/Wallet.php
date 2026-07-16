<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id', 'celebrity_id', 'balance',
    ];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function celebrity()
    {
        return $this->belongsTo(Celebrity::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public static function findOrCreateForUser(User $user, Celebrity $celebrity): self
    {
        return static::firstOrCreate([
            'user_id' => $user->id,
            'celebrity_id' => $celebrity->id,
        ], ['balance' => 0]);
    }

    public function credit(float $amount, ?string $description = null, ?string $referenceType = null, ?string $referenceId = null, ?User $createdBy = null, ?Carbon $timestamp = null): WalletTransaction
    {
        $this->increment('balance', $amount);

        $transaction = new WalletTransaction([
            'type' => 'credit',
            'amount' => $amount,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'created_by' => $createdBy?->id,
            'status' => 'completed',
        ]);

        $transaction->wallet()->associate($this);

        if ($timestamp) {
            $transaction->timestamps = false;
            $transaction->created_at = $timestamp;
            $transaction->updated_at = $timestamp;
        }

        $transaction->save();

        return $transaction;
    }

    public function debit(float $amount, ?string $description = null, ?string $referenceType = null, ?string $referenceId = null, ?User $createdBy = null, ?Carbon $timestamp = null): WalletTransaction
    {
        if ($this->balance < $amount) {
            throw new \RuntimeException('Insufficient wallet balance.');
        }
        $this->decrement('balance', $amount);

        $transaction = new WalletTransaction([
            'type' => 'debit',
            'amount' => $amount,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'created_by' => $createdBy?->id,
            'status' => 'completed',
        ]);

        $transaction->wallet()->associate($this);

        if ($timestamp) {
            $transaction->timestamps = false;
            $transaction->created_at = $timestamp;
            $transaction->updated_at = $timestamp;
        }

        $transaction->save();

        return $transaction;
    }
}
