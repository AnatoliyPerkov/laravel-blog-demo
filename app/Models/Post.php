<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;


class Post extends Model
{
    use HasFactory;

    /**
     * @property int $id
     * @property int $user_id
     * @property int $category_id
     * @property string $title
     * @property string $content
     * @property string $status
     * @property string $reject_reason
     * @property Carbon $created_at
     * @property Carbon $updated_at
     * @property Carbon $published_at
     *
     * @property User $user
     * @property Category $category
     */

    public const STATUS_DRAFT = 'draft';
    public const STATUS_MODERATION = 'moderation';
    public const STATUS_ACTIVE = 'active';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'reject_reason',
        'photo_name',
        'photo_path',
        'category_id',
        'user_id',
        'published_at',
    ];

    public static function statusesList(): array
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_MODERATION => 'On Moderation',
            self::STATUS_ACTIVE => 'Active',

        ];
    }

    public function sendToModeration(): void
    {
        if (!$this->isDraft()) {
            throw new \DomainException('Post is not draft.');
        }

        $this->update([
            'status' => self::STATUS_MODERATION,
        ]);
    }


    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isOnModeration(): bool
    {
        return $this->status === self::STATUS_MODERATION;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }


    public function moderate(Carbon $date): void
    {
        if ($this->status !== self::STATUS_MODERATION) {
            throw new \DomainException('Post is not sent to moderation.');
        }
        $this->update([
            'published_at' => $date,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function reject($reason): void
    {
        $this->update([
            'status' => self::STATUS_DRAFT,
            'reject_reason' => $reason,
        ]);
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->id);
    }
    public function latestPost()
    {
        return $this->hasOne(Post::class)->latest();
    }
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

}
