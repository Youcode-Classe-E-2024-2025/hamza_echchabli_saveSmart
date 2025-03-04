<?php
namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashController extends Controller
{
    // Show Dashboard
    public function index(Request $request, $id)
    {
        // Store the selected profile ID in the session
        session(['profile_id' => $id]);
        $proId=$id ;
    
        // Get the authenticated user ID
        $userId = Auth::id();
        $U = User::where('id', $userId)->first();
        $bala=$U->monthly_income;
     
    
        // Ensure the selected profile belongs to the user
        $profile = Profile::where('id', $id)->where('user_id', $userId)->first();
        if (!$profile) {
            return redirect()->route('dashboard', ['id' => session('profile_id')])
                ->withErrors(['profile' => 'Invalid profile selected.']);
        }
    
        // Get all profile IDs that belong to this user
        $profileIds = Profile::where('user_id', $userId)->pluck('id');
    
        // Fetch categories for this user
        $categories = Categorie::where('user_id', $userId)->get();
    
        // Fetch transactions
        $transactions = Transaction::whereIn('profile_id', $profileIds)
            ->with('profile', 'categorie')
            ->orderBy('created_at', 'desc')
            ->get();
    
        // **Calculate Total Balance, Income, and Expenses**
        $totalIncome = $bala + $transactions->where('type', 'revenue')->sum('amount');
        $totalExpenses = $transactions->where('type', 'expense')->sum('amount');
        $totalBalance = $totalIncome - $totalExpenses;

    
        return view('Userdashboard.dashboard', compact('categories', 'transactions', 'totalBalance', 'totalIncome', 'totalExpenses', 'proId', 'bala'));
    }


    public function stat()
{

   dd(app('cache'));

    $user = Auth::id();
    $proId = session('profile_id');

    $profiles = Profile::where('user_id', $user)->get();

    $expensesData = [];
    $incomesData = [];

    foreach ($profiles as $profile) {

        $expensesData[$profile->name] = Transaction::where('profile_id', $profile->id)
            ->where('type', 'expense')
            ->sum('amount');

        $incomesData[$profile->name] = Transaction::where('profile_id', $profile->id)
            ->where('type', 'revenue')
            ->sum('amount');

       

    }

    return view('Userdashboard.stats', [
        'profiles' => $profiles,
        'expensesData' => $expensesData,
        'incomesData' => $incomesData,
        'proId' => $proId,
    ]);
}

    // Store a new category
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        
        Categorie::create([
            'title' => $validated['title'],
            'user_id' => Auth::id(),
        ]);
        $profileId = session('profile_id');
        
        return redirect('dashboard/'.$profileId)->with('success', 'Category added successfully!');
    }

    // Delete a category
    public function DeleteCategory($id)
    {
        $userId = Auth::id();
        $category = Categorie::where('id', $id)->where('user_id', $userId)->first();

        if (!$category) {
            return redirect()->route('dashboard')
                ->withErrors(['category' => 'Category not found or does not belong to you.']);
        }

        if ($category->expenses()->count() > 0) {
            return redirect()->route('dashboard')
                ->withErrors(['category' => 'Cannot delete category. It has associated expenses.']);
        }

        $category->delete();

        return redirect()->route('dashboard')->with('success', 'Category deleted successfully!');
    }

    // Store a new expense
    public function storeTransaction(Request $request)
    {

        
        $profileId = session('profile_id');
        // Validate the request
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'type' => 'required|in:revenue,expense', // Ensure type is either revenue or expense
        ]);
    
        // Get the authenticated user
        $user = Auth::user();
    
        if (!$user) {
            
            return redirect('dashboard/'.$profileId)->withErrors(['user' => 'User not found.']);
        }
    
       
       
        if ($validated['type'] === 'expense') {
        //    return 444;
            if ($user->balance < $validated['amount']) {
               
                return redirect('dashboard/'.$profileId)->withErrors(['balance' => 'Insufficient balance.']);
            }
    
            $user->balance -= $validated['amount']; 
        } else {
            $user->balance += $validated['amount']; 
        }
    
        $user->save();
    
        $profileId = session('profile_id');
    
       
        // Create the transaction
         Transaction::create([
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'categorie_id' => $validated['categorie_id'],
            'profile_id' => $profileId,
            'type' => $validated['type'],
        ]);
    
        return redirect('dashboard/'.$profileId)->with('success', 'Transaction added successfully!');
    }



    public function manage()
{
    $userId = Auth::id();
    $proId = session('profile_id');
    
    // Get all profiles that belong to this user with transaction count
    $profiles = Profile::where('user_id', $userId)
        ->withCount('transactions') // Assuming the Profile model has a `transactions` relation
        ->where('archive' ,1)
        ->get();
  
        

        // return $profiles ;
        

    return view('Userdashboard.manageProfiles', compact('profiles' , 'proId'));
}

public function activate($id)
{
    $profile = Profile::findOrFail($id);

    $profile->update([
        'active' => 0, // Deactivate the profile
    ]);

    return redirect()->route('profiles.manage'); // Redirect back to the manage page
}

public function deactivate($id)
{
    $profile = Profile::findOrFail($id);

    $profile->update([
        'active' => 1, // Activate the profile
    ]);

    return redirect()->route('profiles.manage'); // Redirect back to the manage page
}

public function archive($id)
{
    $profile = Profile::findOrFail($id);

    $profile->update([
        'archive' => 0, // Archive the profile
    ]);

    return redirect()->route('profiles.manage'); // Redirect back to the manage page
}




public function edit($id)
{
    $transaction = Transaction::findOrFail($id);
    $categories = Category::all(); // Assuming you want to show all categories
    return view('transactions.edit', compact('transaction', 'categories'));
}


public function update(Request $request)
{
    // return $request;
    $transaction = Transaction::findOrFail($request->id);
    // return $transaction;
    $transaction->update([
        'title' => $request->input('title'),
        'amount' => $request->input('amount'),
        'type' => $request->input('type'),
        'categorie_id' => $request->input('categorie_id'),
    ]);

    $pid =session('profile_id');

    return redirect('/dashboard/'.$pid);
}















}