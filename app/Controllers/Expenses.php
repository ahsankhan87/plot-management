<?php

namespace App\Controllers;

use App\Models\ExpenseModel;
use App\Models\ExpenseCategoriesModel;


class Expenses extends BaseController
{
    protected $expenseModel;

    public function __construct()
    {
        $this->expenseModel = new ExpenseModel();
        $this->expenseCategoriesModel = new ExpenseCategoriesModel();
        $this->validation = \Config\Services::validation();
        helper('auth');
        helper('audit');
    }

    public function index()
    {
        if (!auth()->user()->can('expenses_view')) {
            return view('errors/no_access');
        }

        // Get all expenses (filtered if needed)
        $filters = ['category_id' => $_GET['category_id'] ?? null, 'date_from' => $_GET['date_from'] ?? null, 'date_to' => $_GET['date_to'] ?? null]; // Define filters as empty array or set your filter criteria here
        $expenses = $this->expenseModel->getFilteredExpenses($filters);

        // Category totals
        $category_totals = [];
        foreach ($expenses as $expense) {
            $cat = $expense['category_name'];
            $category_totals[$cat] = ($category_totals[$cat] ?? 0) + $expense['amount'];
        }

        // Month totals
        $month_totals = [];
        foreach ($expenses as $expense) {
            $month = date('Y-m', strtotime($expense['date']));
            $month_totals[$month] = ($month_totals[$month] ?? 0) + $expense['amount'];
        }

        // Pass these to the view
        return view('expenses/index', [
            'title' => 'Expenses',
            'expenses' => $this->expenseModel->select('expenses.*, expense_categories.name as category_name')
                ->join('expense_categories', 'expense_categories.id = expenses.category_id')
                ->findAll(),
            'categories' => $this->expenseCategoriesModel->findAll(),
            'today_expenses' => $this->expenseModel->getTodayExpenses(),
            'month_expenses' => $this->expenseModel->getMonthlyExpenses(date('m')),
            'top_category' => $this->expenseModel->getTopExpenseCategory(),
            'category_totals' => $category_totals,
            'month_totals' => $month_totals,
        ]);
    }

    public function create()
    {
        if (!auth()->user()->can('expenses_create')) {
            return view('errors/no_access');
        }
        $data['categories'] = $this->expenseCategoriesModel->findAll();
        return view('expenses/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        // Validate the incoming request
        if (! $this->validateData($data, [
            'date' => 'required',
            'amount' => 'required|decimal',
            'category_id' => 'required',
            'description' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $this->expenseModel->save([
            'date' => $data['date'],
            'amount' => $data['amount'],
            'category_id' => $data['category_id'],
            'description' => $data['description'],
        ]);
        logAudit('CREATE', 'Expenses', $this->expenseModel->insertID(), [], $this->request->getPost());
        return redirect()->to('/expenses')->with('success', 'Expense created successfully.');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('expenses_edit')) {
            return view('errors/no_access');
        }
        $data['expense'] = $this->expenseModel->find($id);
        $data['categories'] = $this->expenseCategoriesModel->findAll();

        return view('expenses/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        if (! $this->validateData($data, [
            'date' => 'required',
            'amount' => 'required|decimal',
            'category_id' => 'required',
            'description' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $this->expenseModel->update($id, [
            'date' => $data['date'],
            'amount' => $data['amount'],
            'category_id' => $data['category_id'],
            'description' => $data['description'],
        ]);
        logAudit('UPDATE', 'Expenses', $id, $this->expenseModel->find($id), $this->request->getPost());
        return redirect()->to('/expenses')->with('success', 'Expense updated successfully.');
    }

    public function delete($id)
    {
        if (!auth()->user()->can('expenses_delete')) {
            return view('errors/no_access');
        }
        logAudit('DELETE', 'Expenses', $id, $this->expenseModel->find($id), []);
        $this->expenseModel->delete($id);
        return redirect()->to('/expenses')->with('success', 'Expense deleted successfully.');
    }
}
