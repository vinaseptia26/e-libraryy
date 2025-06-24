<?php

namespace App\Models;

use CodeIgniter\Model;

class ScannedCodeModel extends Model
{
    protected $table            = 'scanned_codes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['code_data', 'scanned_at'];
    public $timestamps          = false;
}
