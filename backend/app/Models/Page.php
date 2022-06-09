<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        "page_type_id",
        "detail"
    ];
    
    public function page_type()
    {
        return $this->belongsTo(PageType::class, 'page_type_id', 'id');
    }
}
