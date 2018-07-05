<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
class ArticleCategory extends Model
{
    protected $guarded = [];
    use NodeTrait;
}
