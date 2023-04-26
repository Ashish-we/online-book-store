<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Livewire\User\UserDashboardComponent;
use App\Http\Livewire\Admin\AdminDashboardComponent;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\book;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $book_s = DB::select("select books.title, books.isbn,book_mtrs.image, authors.name from books join book_mtrs on books.isbn=book_mtrs.isbn join authors on books.isbn = authors.isbn");
    // dd($book_s);
    return view('welcome',['book_s'=>$book_s]);
})->name('welcome');

Route::post('/add/create/', [BookController::class, 'add_book'])->name('add_book');

Route::get('/book_details/{isbn}', [BookController::class, 'book_details'])->name('book_details');

Route::middleware(['auth'])->group(function(){
Route::post('/book_details', [BookController::class,'add_to_cart'])->name('add_to_cart');
});

Route::post('user/dashboard', [BookController::class, 'decrease_'])->name('decrease_items');

Route::post('/search', [BookController::class, 'find_books'])->name('find_books');



Route::middleware(['auth','authadmin'])->group(function(){
    Route::get('add/', function() {
        return view('add');
    })->name('add');
});
Route::middleware(['auth','authadmin'])->group(function(){
    Route::get('/update_book/{isbn}', [BookController::class, 'update_book'])->name('update_book');
    Route::get('/delete_book/{isbn}', [BookController::class, 'delete_book'])->name('delete_book');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function(){
    Route::get('user/dashboard',UserDashboardComponent::class)->name('user.dashboard');
});

Route::middleware(['auth','authadmin'])->group(function(){
    Route::get('admin/dashboard',AdminDashboardComponent::class)->name('admin.dashboard');
});

Route::middleware(['auth','authadmin'])->group(function(){
    Route::put('update_book/{isbn}',[BookController::class, 'update_book_done'])->name('update_book_done');
});
// Route::get('/dashboard', function () {
//     $user = Auth::user();
//     $already = Cart::all();
        
//         if (Cart::exists()){
//             foreach($already as $already_)
//             {
//                 if($already_->email == $user->email)
//                 {
//                     $cart_item = Cart::where('email', $user->email)->get();
//                 }
//             }
//             return view('dashboard', ['cart_items' => $cart_item]);
//         }
//         else{
//             return view('dashboard',['cart_items' => $already]);
//         }
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

