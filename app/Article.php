<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'published_at'];


    protected $dates = ['published_at'];

    public function scopePublished($query)
    {
        $query->where('published_at','<=', Carbon::now());
    }

    public function scopeUnpublished($query)
    {
        $query->where('published_at','>', Carbon::now());
    }
    /**
     * @param $date
     */
    public function setPublishedAtAttribute($date)
    {
       $this->attributes['published_at'] = Carbon::createFromFormat('m/d/Y', $date);
    }

    public function getPublishedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    /**
     * Get a list of tag ids associated with the current article
     * @return mixed
     */
    public function getTagListAttribute()
    {
        return $this->tags->lists('id')->all();
    }
}
