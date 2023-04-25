<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected  $guarded = [];

    public function articleComments()
    {
        return $this->hasMany(ArticleComments::class, 'article_id');
    }

    public function articleTags()
    {
        return $this->belongsTo(ArticleTags::class, 'article_tag_id');
    }

    public function articleLike()
    {
        return $this->hasMany(ArticleLike::class, 'article_id');
    }
    
    public function articleView()
    {
        return $this->hasMany(ArticleView::class, 'article_id');
    }

}
