<?php

namespace App\Http\Controllers;
use App\Models\Book_mtr;
use App\Models\book;
use App\Models\author;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    function add_book(Request $request)
    {
        $auth_add = new author;
        $auth_add->name = $request->author;
        $auth_add->isbn = $request->isbn;
        $auth_add->save();

        $book_itm = new book;
        $book_itm->isbn = $request->isbn;
        $book_itm->title = $request->title;
        $book_itm->year = $request->year;
        $book_itm->category = $request->category;
        $book_itm->price = $request->price;
        $book_itm->save();

        //to add image
        $book_img = new Book_mtr;
        $book_img->isbn = $request->isbn;

        $image = $request->image;
        $image_name = $image->getClientOriginalName();
        $image->storeAs('public/images', $image_name);
        $image->move(public_path('storage/images'), $image_name);

        $book_img->image = $image_name;
        $book_img->save();

        return redirect('/');

    }

    function update_book($isbn) {
    
        $book_item = book::find($isbn);
        
        return view('update', ['books'=>$book_item]);
        
    }
    function delete_book($isbn) {
    
        book::find($isbn)->delete();
        Author::where('isbn', $isbn)->delete();
        $image_name = DB::select("select image from Book_mtrs where isbn = $isbn");
        foreach ($image_name as $image_names){
        // dd($image_names->image);
        }
        Book_mtr::where('isbn', $isbn)->delete();
        $image_path = public_path().'/storage/images/';
        $image_pat = storage_path().'/app/public/images/';
        // dd($image_pat);
        $file = $image_path . $image_names->image;
        $file1 = $image_pat . $image_names->image;
        if(file_exists($file))
        {
            unlink($file);
        }
        if(file_exists($file1))
        {
            unlink($file1);
        }
        return redirect('/');
        
    }

    function update_book_done(Request $request,$isbn){
        // $destination = 'storage/public/images/'.$request->old_image;
        // if(Storage::exists('images/$request->old_image')){
        //     Storage::delete('images/$request->old_image');
        // }
        $image_nam = DB::select("select image from Book_mtrs where isbn = $request->old_isbn");
        foreach ($image_nam as $image_names){
        // dd($image_names->image);
        }
        $image_path = public_path().'/storage/images/';
        $image_pat = storage_path().'/app/public/images/';
        // dd($image_pat);
        $file = $image_path . $image_names->image;
        $file1 = $image_pat . $image_names->image;
        if(file_exists($file))
        {
            unlink($file);
        }
        if(file_exists($file1))
        {
            unlink($file1);
        }
          
        $author = $request->author;
        $title = $request->title;
        $category = $request->category;
        $year = $request->year;
        $isbn = $request->isbn;
        $old_isbn = $request->old_isbn;
       
        $price = $request->price;
        $image = $request->image;
        $image_name = $image->getClientOriginalName();
        $image->storeAs('public/images', $image_name);
        $image->move(public_path('storage/images'), $image_name);
        DB::update('update books set title = ?,Category=?,isbn=?,year=?,price=? where isbn = ?',
            [$title,$category,$isbn,$year,$price,$old_isbn]);
        DB::update('update authors set name = ?,isbn=? where isbn = ?',
            [$author,$isbn,$old_isbn]);
        DB::update('update Book_mtrs set image = ?,isbn=? where isbn = ?',
            [$image_name,$isbn,$old_isbn]);
          
        return redirect()->back()->with('status','success');
    }
  

    function book_details($isbn) {
    
        $book_item = book::find($isbn);
        
        return view('detail', ['books'=>$book_item]);
        
    }

    


    function add_to_cart(Request $request){
        $user = Auth::user();
        $already = Cart::where('isbn',$request->isbn)->get();
        
        if (Cart::exists()){
            foreach($already as $already_)
            {
                if($already_->email == $user->email)
                {
                    $already_->num_of_items += 1;
                    $already_->save();
                    return redirect('user/dashboard');
                }
            }
            $cart_itm = new Cart;
            $cart_itm->isbn = $request->isbn;
            $cart_itm->email = $user->email;
            $book_itm = Book::find($request->isbn);
            $cart_itm->title = $book_itm->title;
            $cart_itm->price = $book_itm->price;
            $cart_itm->num_of_items = 1;
            $cart_itm->save();
            
        }
        else{
        $cart_itm = new Cart;
        $cart_itm->isbn = $request->isbn;
        $cart_itm->email = $user->email;
        $book_itm = Book::find($request->isbn);
        $cart_itm->title = $book_itm->title;
        $cart_itm->price = $book_itm->price;
        $cart_itm->num_of_items = 1;
        $cart_itm->save();
        
        }
        
        return redirect('user/dashboard');
    }
    function decrease_(Request $request){
        $user = Auth::user();
        $already = Cart::where('isbn',$request->isbn)->get();
        
        if (Cart::exists()){
            foreach($already as $already_)
            {
                if($already_->email == $user->email)
                {
                    if($already_->num_of_items !=1) {
                        $already_->num_of_items -= 1;
                        $already_->save();
                        return redirect('user/dashboard');
                    }
                    else {
                        Cart::where('isbn',$request->isbn)->delete();
                        return redirect('user/dashboard');
                    }
                }
            }
        }
        else{
            return redirect('user/dashboard',['cart_items' => $already]);
        }
    }
    function find_books(Request $request){
        // $hello = DB::select("select * from books where title like '%$request->search%'");
        // dd($hello);
        $book_s = DB::select("select books.title, books.isbn,book_mtrs.image, authors.name from books join book_mtrs on books.isbn=book_mtrs.isbn join authors on books.isbn = authors.isbn where books.title like '%$request->search%' ");
        return view('welcome',['book_s'=>$book_s]);
    }
}


