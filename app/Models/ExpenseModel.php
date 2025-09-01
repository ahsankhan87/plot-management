<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseModel extends Model
{
    protected $table = 'expenses';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date', 'amount', 'category_id', 'description'];

    public function getExpensesWithCategory()
    {
        return $this->select('expenses.*, expense_categories.name as category_name')
            ->join('expense_categories', 'expense_categories.id = expenses.category_id')
            ->findAll();
    }

    public function getMonthlyExpenses($month)
    {
        return $this->where('MONTH(date)', $month)->selectSum('amount')->first();
    }
    public function getTodayExpenses()
    {
        return $this->where('DATE(date)', date('Y-m-d'))->selectSum('amount')->first();
    }
    public function getTopExpenseCategory()
    {
        return $this->select('expense_categories.name, SUM(expenses.amount) as total_amount')
            ->join('expense_categories', 'expense_categories.id = expenses.category_id')
            ->groupBy('expense_categories.id')
            ->orderBy('total_amount', 'DESC')
            ->first();
    }
    public function totalExpenses()
    {
        return $this->selectSum('amount')->first();
    }
    public function getFilteredExpenses($filters = [])
    {
        $builder = $this->select('expenses.*, expense_categories.name as category_name')
            ->join('expense_categories', 'expense_categories.id = expenses.category_id');

        if (!empty($filters['category_id'])) {
            $builder->where('expenses.category_id', $filters['category_id']);
        }
        if (!empty($filters['date_from'])) {
            $builder->where('expenses.date >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $builder->where('expenses.date <=', $filters['date_to']);
        }
        return $builder->findAll();
    }
}
