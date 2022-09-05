<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $casts = [
        'active' => 'bool',
    ];

    protected $fillable = [
        'name',
        'mimeType',
        'extension',
        'size',
        'imageable_type',
        'imageable_id',
        'crop',
        'sort',
    ];

    /**
     * Get the parent imageable model.
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
