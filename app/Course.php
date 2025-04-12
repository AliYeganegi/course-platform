<?php

namespace App;

use App\Examination;
use App\Scopes\CourseScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Course extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    public $table = 'courses';

    protected $appends = [
        'photo',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'price',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'institution_id',
        'course_file',
        'course_link',
        'learning_outcomes',
        'target_audience',
        'instructor_id',
        'course_duration',
        'course_topics',
        'prerequisites',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CourseScope);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id', 'id');
    }

    public function enrollment()
    {
        return $this->hasOne(Enrollment::class)->where('user_id', auth()->id());
    }


    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();

        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }

    public function getPrice()
    {
        return $this->price ? '$' . number_format($this->price, 2) : 'FREE';
    }

    public function scopeSearchResults($query)
    {
        $query->when(request('discipline'), function ($query) {
            $query->whereHas('disciplines', function ($query) {
                $query->whereId(request('discipline'));
            });
        })
            ->when(request('institution'), function ($query) {
                $query->whereHas('institution', function ($query) {
                    $query->whereId(request('institution'));
                });
            });
    }
}
