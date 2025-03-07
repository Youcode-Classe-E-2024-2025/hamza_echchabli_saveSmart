<?php
namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Transaction;
use App\Models\User;

use App\Models\Goal;
use App\Models\Type;
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
        $needs=$U->balance->needs;
        $wants=$U->balance->wants;
        // Fetch transactions
        $transactions = Transaction::whereIn('profile_id', $profileIds)
            ->with('profile', 'categorie')
            ->orderBy('created_at', 'desc')
            ->get();
    

            $expenseTypes = [2, 3, 4];
$transactionsSum = Transaction::whereIn('profile_id', $profileIds)
    ->whereIn('type_id', $expenseTypes)
    ->with('profile', 'categorie')
    ->orderBy('created_at', 'desc')
    ->get();


    $totalExpenses = $transactionsSum->sum('amount');

            $user = Auth::user();

$totalIncome = $user->balance->needs + $user->balance->wants + $user->balance->saves;

// $totalExpenses = $user->balance->needs + $user->balance->wants;

$totalBalance = $totalIncome - $totalExpenses;


    
        return view('Userdashboard.dashboard', compact('categories', 'transactions', 'totalBalance', 'totalIncome', 'totalExpenses', 'proId', 'bala','needs','wants'));
    }


    public function stat()
{

   

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


public function  returnCategories(int $type)
{
  
        $categories = Categorie::where('type_id', $type)->get();
  

          return response()->json($categories);
}

  
    
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id', // Ensure type_id is valid
        ]);
        
        Categorie::create([
            'title' => $validated['title'],
            'user_id' => Auth::id(),
            'type_id' => $validated['type_id'], // Assign the selected type_id
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

    // // Store a new expense
    // public function storeTransaction(Request $request)
    // {

        
    //     $profileId = session('profile_id');
    //     // Validate the request
    //     $validated = $request->validate([
    // 'title' => 'nullable|string|max:255',
    // 'amount' => 'required|numeric|min:0',
    // 'type' => 'required|in:needs,wants,saves,income',
    // 'categorie_id' => 'required|exists:categories,id', 
    //  ]);

    
    //     // Get the authenticated user
    //     $user = Auth::user();
    
    //     if (!$user) {
            
    //         return redirect('dashboard/'.$profileId)->withErrors(['user' => 'User not found.']);
    //     }
    
       
       
    //     switch ($validated['type']) {
    //         case 'needs':
    //             // Subtract from needs
    //             $needsAmount = $validated['amount'];
    //             if ($user->needs < $needsAmount) {
    //                 return redirect('dashboard/'.$profileId)->withErrors(['balance' => 'Insufficient needs balance.']);
    //             }
    //             $user->needs -= $needsAmount;
    //             break;
        
    //         case 'wants':
    //             // Subtract from wants
    //             $wantsAmount = $validated['amount'];
    //             if ($user->wants < $wantsAmount) {
    //                 return redirect('dashboard/'.$profileId)->withErrors(['balance' => 'Insufficient wants balance.']);
    //             }
    //             $user->wants -= $wantsAmount;
    //             break;
        
    //         case 'saves':
    //             // Subtract from savings
    //             $savesAmount = $validated['amount'];
    //             if ($user->saves < $savesAmount) {
    //                 return redirect('dashboard/'.$profileId)->withErrors(['balance' => 'Insufficient savings balance.']);
    //             }
    //             $user->saves -= $savesAmount;
    //             break;
        
    //         case 'income':
    //             // Add to all categories based on the specified percentages
    //             $needsAmount = $validated['amount'] * 0.50;
    //             $wantsAmount = $validated['amount'] * 0.30;
    //             $savesAmount = $validated['amount'] * 0.20;
        
    //             $user->needs += $needsAmount;
    //             $user->wants += $wantsAmount;
    //             $user->saves += $savesAmount;
    //             break;
    //     }
        
    //     $user->save();
        
    
    //     $user->save();
    
    //     $profileId = session('profile_id');
    
       
    //     // Create the transaction
    //     Transaction::create([
    //         'title' => $validated['title'],
    //         'amount' => $validated['amount'],
    //         'profile_id' => $profileId,
    //         'type' => $validated['type'],

    //     ]);
        
    
    //     return redirect('dashboard/'.$profileId)->with('success', 'Transaction added successfully!');
    // }

    public function storeTransaction(Request $request)
{

   
    $profileId = session('profile_id');

    // Validate the request
     $validated = $request->validate([
        'title' => 'nullable|string|max:255',
        'amount' => 'required|numeric|min:0',
        'type_id' => 'required', // Validate type_id
        'categorie_id' => '',
    ]);

    // return $validated;

    // Get the authenticated user
    $user = Auth::user();

    if (!$user) {
        return redirect('dashboard/'.$profileId)->withErrors(['user' => 'User not found.']);
    }

    // Process the transaction based on the type_id
    $type = Type::findOrFail($validated['type_id']);
    
    switch ($type->title) {
        case 'needs':
            // Subtract from needs
            $needsAmount = $validated['amount'];
            if ($user->balance->needs < $needsAmount) {
                return redirect('dashboard/'.$profileId)->withErrors(['balance' => 'Insufficient needs balance.']);
            }
            $user->balance->needs -= $needsAmount;
            break;
    
        case 'wants':
            // Subtract from wants
            $wantsAmount = $validated['amount'];
            if ($user->balance->wants < $wantsAmount) {
                return redirect('dashboard/'.$profileId)->withErrors(['balance' => 'Insufficient wants balance.']);
            }
            $user->balance->wants -= $wantsAmount;
            break;
    
        case 'saves':
            // Subtract from savings
            $savesAmount = $validated['amount'];
            if ($user->balance->saves < $savesAmount) {
                return redirect('dashboard/'.$profileId)->withErrors(['balance' => 'Insufficient savings balance.']);
            }
            $user->balance->saves -= $savesAmount;
            break;
    
        case 'income':
            // Add to all categories based on the specified percentages
            $needsAmount = $validated['amount'] * 0.50;
            $wantsAmount = $validated['amount'] * 0.30;
            $savesAmount = $validated['amount'] * 0.20;
    
            $user->balance->needs += $needsAmount;
            $user->balance->wants += $wantsAmount;
            $user->balance->savings += $savesAmount;
            break;
    }
    
    // Save the updated balance
    $user->balance->save();
    

    // Create the transaction
    Transaction::create([
        'title' => $validated['title'],
        'amount' => $validated['amount'],
        'profile_id' => $profileId,
        'type_id' => $validated['type_id'],
        'categorie_id' => $validated['categorie_id'],
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







public function Goals()
{
    $goals = auth()->user()->goals;
    $U = auth()->user() ;
    $savings=$U->balance->savings;

    $pid =session('profile_id');


    return view('goals.goalsView', compact('goals' , 'savings' , 'pid'));
}



public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'target_amount' => 'required|numeric|min:0',
    ]);

    Goal::create([
        'title' => $validated['title'],
        'target_amount' => $validated['target_amount'],
        'user_id' => auth()->id(),
        'current_amount' => 0,
    ]);

    return redirect('/goals');
}


public function submitGoal(Request $request)
{
    
    $user = Auth::user();

    if ($user->balance->saves < $request['amount']) {

        $user->balance->savings -= $request['amount'];
        $user->balance->save();

        return redirect('/goals')->withErrors(['balance' => 'Insufficient savings balance.']);
        
    }

   

    Transaction::create([
        'title' => $request['title'],
        'amount' => $request['amount'],
        'profile_id' => $request['profile_id'],
        'type_id' => $request['type_id'],
        'categorie_id' => $request['categorie_id'],
    ]);

    if ($request->has('goal_id')) {
        $goal = Goal::findOrFail($request->input('goal_id'));
        $goal->delete();
    }

    
    return redirect('/goals')->withErrors('balance', 'Goal submitted and transaction created successfully.');
}



public function deleteGoal(int $id)
{
   

    
        $goal = Goal::findOrFail($id);
        $goal->delete();
    

    // Redirect with a success message
    return redirect('/goals')->with('success', 'Goal submitted and transaction created successfully.');
}




}