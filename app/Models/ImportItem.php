<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportItem extends Model
{
    use HasFactory;

    protected $table = 'tm_import_items';

    protected $fillable = ['network', 'data', 'data_type', 'is_imported'];
}
