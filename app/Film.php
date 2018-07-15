<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'films';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'release_date', 'rating', 'ticket_price', 'country', 'photo', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres(){
        return $this->belongsToMany('App\Genre', 'film_genres', 'film_id', 'genre_id');
    }

    /**
     * Get the comments for the film
     */
    public function comments() {
        return $this->hasMany('App\Comment');
    }
	
}