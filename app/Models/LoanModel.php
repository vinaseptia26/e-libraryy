<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'loans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'book_id',
        'quantity',
        'member_id',
        'uid',
        'loan_date',
        'due_date',
        'return_date',
        'qr_code',
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Custom function to join books and members for view/export/print
    public function getLoanList()
    {
        return $this->select('
                loans.*, 
                members.first_name, 
                members.last_name, 
                books.title, 
                books.year, 
                books.author, 
                books.slug
            ')
            ->join('members', 'members.id = loans.member_id', 'left')
            ->join('books', 'books.id = loans.book_id', 'left')
            ->orderBy('loans.loan_date', 'DESC')
            ->findAll();
    }
}