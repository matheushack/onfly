<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

/**
 *
 */
//#[ScopedBy([UserScope::class])]
class Order extends Model
{
    use Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'passenger',
        'destination',
        'departure_at',
        'return_at',
        'status'
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'departure_at' => 'date',
            'return_at' => 'date',
            'status' => OrderStatus::class,
        ];
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param Notification $notification
     * @return array|string
     */
    public function routeNotificationForMail(Notification $notification): array|string
    {
        return $this->user->email;
    }
}
