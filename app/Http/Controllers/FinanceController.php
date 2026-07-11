<?php

namespace App\Http\Controllers;

use App\Models\FinanceRecord;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $userId     = Auth::id();
        $type       = $request->get('type');
        $categoryId = $request->get('category_id');
        $month = $request->get('month', now()->format('Y-m'));

        // Ensure month is always in Y-m format before splitting
        if (!preg_match('/^\d{4}-\d{1,2}$/', $month)) {
            $month = now()->format('Y-m');
        }
        [$year, $mon] = explode('-', $month);

        $query = FinanceRecord::forUser($userId)
            ->with('category')
            ->orderBy('date', 'desc');

        if ($type)       $query->where('type', $type);
        if ($categoryId) $query->where('category_id', $categoryId);
        if ($month)      $query->whereYear('date', $year)->whereMonth('date', $mon);

        $records    = $query->paginate(20)->withQueryString();
        $categories = Category::where('user_id', $userId)->get();

        $totalIncome  = FinanceRecord::forUser($userId)->income()->whereYear('date', $year)->whereMonth('date', $mon)->sum('amount');
        $totalExpense = FinanceRecord::forUser($userId)->expense()->whereYear('date', $year)->whereMonth('date', $mon)->sum('amount');

        return view('finance.index', compact(
            'records', 'categories', 'type', 'categoryId', 'month',
            'totalIncome', 'totalExpense'
        ));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('finance.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'        => ['required', 'in:income,expense'],
            'amount'      => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
            'date'        => ['required', 'date'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'notes'       => ['nullable', 'string'],
        ]);

        FinanceRecord::create([...$data, 'user_id' => Auth::id()]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil ditambahkan!'
            ]);
        }

        return redirect()->route('finance.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit(FinanceRecord $finance)
    {
        $this->authorizeRecord($finance);
        $categories = Category::where('user_id', Auth::id())->get();
        return view('finance.edit', compact('finance', 'categories'));
    }

    public function update(Request $request, FinanceRecord $finance)
    {
        $this->authorizeRecord($finance);

        $data = $request->validate([
            'type'        => ['required', 'in:income,expense'],
            'amount'      => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
            'date'        => ['required', 'date'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'notes'       => ['nullable', 'string'],
        ]);

        $finance->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diperbarui!'
            ]);
        }

        return redirect()->route('finance.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(FinanceRecord $finance)
    {
        $this->authorizeRecord($finance);
        $finance->delete();
        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus.'
            ]);
        }
        
        return redirect()->route('finance.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    private function authorizeRecord(FinanceRecord $record): void
    {
        abort_if($record->user_id !== Auth::id(), 403);
    }
}
