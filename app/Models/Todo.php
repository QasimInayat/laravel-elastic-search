<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;



class Todo extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $appends = ['attachment_url'];


    protected $fillable = [
        'user_id',
        'title',
        'description',
        'is_done',
        'due_date',
        'priority'
    ];


    protected $casts = [
        'due_date' => 'date',
        'is_done'  => 'boolean',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
         // Thumbnail (crop + sharpen + watermark)
    $this->addMediaConversion('thumb')
        ->fit(Fit::Crop, 200, 200)
        ->sharpen(10)
        ->watermark(
            public_path('watermark.png'), // Path to your watermark image
            width: 40,        // Width of the watermark on the target image
            height: 40,       // Height of the watermark on the target image
            paddingX: 10,     // Padding from the right edge
            paddingY: 10,     // Padding from the bottom edge
        )
        ->nonQueued();

    // Medium (resize max + watermark)
    $this->addMediaConversion('medium')
        ->fit(Fit::Max, 600, 400)
        ->watermark(
            public_path('watermark.png'),
            width: 80,
            height: 80,
            paddingX: 15,
            paddingY: 15,
        )
        ->nonQueued();



          $this->addMediaConversion('watermarked')
            ->width(1200) // Limit the size for web display, but keep it large
            ->watermark(
                public_path('watermark.png'),
                width: 120,
                height: 120,
                paddingX: 20,
                paddingY: 20
            )
            ->nonQueued(); // Or ->queued() if it's a heavy operation






    }



    public function getAttachmentUrlAttribute()
    {
        return $this->getFirstMediaUrl('image');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }




    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
