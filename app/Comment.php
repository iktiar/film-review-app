<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'comment', 'film_id', 'user_id'];

    /**
     * Get the Film that the comments are associated with
     */
    public function film() {
        return $this->belongsTo('App\Film');
    }

    /**
     * Get the User that owns the comments.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
}






