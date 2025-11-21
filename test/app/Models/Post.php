<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;
use RyanChandler\Comments\Concerns\HasComments;
class Post extends Model
{
    use HasFactory;
    use Likeable;
    use HasComments;

    protected $fillable = ['user_id', 'content', 'image_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}