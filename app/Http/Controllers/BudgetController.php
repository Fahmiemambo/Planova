<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $userId  = Auth::id();
        $now     = now();

        $budgets = Budget::where('user_id', $userId)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('budget.index', compact('budgets'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('budget.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'limit_amount' => ['required', 'numeric', 'min:0.01'],
            'period'       => ['required', 'in:monthly,weekly,yearly'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'period_year'  => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'period_month' => ['nullable', 'integer', 'min:1', 'max:12'],
        ]);

        if (empty($data['period_year'])) {
            $data['period_year'] = now()->year;
        }
        if (empty($data['period_month']) && $data['period'] === 'monthly') {
            $data['period_month'] = now()->month;
        }

        Budget::create([...$data, 'user_id' => Auth::id()]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Budget berhasil dibuat!'
            ]);
        }

        return redirect()->route('budget.index')
            ->with('success', 'Budget berhasil dibuat!');
    }

    public function edit(Budget $budget)
    {
        $this->authorizeBudget($budget);
        $categories = Category::where('user_id', Auth::id())->get();
        return view('budget.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        $this->authorizeBudget($budget);

        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'limit_amount' => ['required', 'numeric', 'min:0.01'],
            'period'       => ['required', 'in:monthly,weekly,yearly'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'period_year'  => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'period_month' => ['nullable', 'integer', 'min:1', 'max:12'],
        ]);

        $budget->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Budget berhasil diperbarui!'
            ]);
        }

        return redirect()->route('budget.index')
            ->with('success', 'Budget berhasil diperbarui!');
    }

    public function destroy(Budget $budget)
    {
        $this->authorizeBudget($budget);
        $budget->delete();
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Budget berhasil dihapus.'
            ]);
        }
        
        return redirect()->route('budget.index')
            ->with('success', 'Budget berhasil dihapus.');
    }

    private function authorizeBudget(Budget $budget): void
    {
        abort_if($budget->user_id !== Auth::id(), 403);
    }
}
