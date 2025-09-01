<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseCategoriesModel extends Model
{
    protected $table = 'expense_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];
}
