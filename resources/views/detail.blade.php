<!DOCTYPE html>
<html>
  <head>
    <title>Book Detail</title>
    <style>
      /* Add some basic styling for the page */
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
      }

      /* Create a container for the main content */
      .container {
        max-width: 1000px;
        margin: 0 auto;
      }

      /* Style the header section */
      header {
        background-color: #fff;
        color: #fff;
        padding: 20px;
      }

      header h1 {
        margin: 0;
      }

      /* Style the book cover image */
      .book-cover {
        width: 300px;
        float: left;
        margin-right: 20px;
      }

      /* Style the book information section */
      .book-info {
        overflow: auto;
      }

      .book-info h2 {
        margin: 0;
        font-size: 36px;
      }

      .book-info h3 {
        margin: 0;
        font-size: 24px;
      }

      .book-info p {
        font-size: 18px;
        line-height: 1.5;
        margin-bottom: 10px;
      }

      /* Style the "Add to Cart" button */
      .add-to-cart {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border-radius: 4px;
        text-decoration: none;
        margin-top: 20px;
        display: inline-block;
      }

      .add-to-cart:hover {
        background-color: #218838;
      }
      .logo1 {
        display: flex;
        align-items: center;
        justify-content: center;
        }

        .logo1 h1 {
        font-size: 3em;
        font-weight: bold;
        color: #2ecc71;
        text-shadow: 2px 2px #f1c40f;
        }

        .logo1 h2 {
        font-size: 2em;
        font-weight: lighter;
        color: #34495e;
        text-shadow: 2px 2px #f1c40f;
        }

    </style>
  </head>
  <body>
  <?php
        use Illuminate\Support\Facades\DB;
        $auth_name = DB::select("select name from authors where isbn='$books->isbn'");
        foreach ($auth_name as $auth) {
            // echo "$auth->name"."<br>";
        }
        $book_hi = DB::select("select image from Book_mtrs where isbn='$books->isbn'");
        foreach ($book_hi as $bok) {
            // echo "$bok->image";
        }
        ?>
    <header>
      <div class="container">
        <a href="{{ url('/') }}" style="color: white; text-decoration: none;">
        <div class="logo1">
        <h1>Mero</h1>
        <h2>Book Store</h2>
        </div>

    </a>
      </div>
    </header>
    <div class="container">
      <div class="book-info">
        <img class="book-cover" src="{{ asset('storage/images/'.$bok->image)}}" alt="<%= book.title %>">
        <h2>{{$books->title}}</h2>
        <h3>by {{$auth->name}}</h3>
        <h4>ISBN : {{$books->isbn}}</h4>
        <p class="btn btn-info">Lorem Ipsum is simply dummy text of the printing 
                and typesetting industry. Lorem Ipsum has been the industry's 
                standard dummy text ever since the 1500s, when an unknown printer
                took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into 
                electronic typesetting, remaining essentially unchanged.</p>
        <!-- <a href="#" class="add-to-cart">Add to Cart</a> -->
        @if (Route::has('login'))
            @auth
                @if(Auth::user()->utype == 'USR')
                    <div>
                        <form method="post" action="{{route('add_to_cart')}}" accept-charset="UTF-8">
                            @csrf
                            <input type="hidden" name="isbn" value="{{$books->isbn}}">
                            <input class="add-to-cart" type="submit" value="Add to cart" ><br><br>
                        </form>
                    </div>
                @endif
            @else
                <div>
                    <form method="post" action="{{route('add_to_cart')}}" accept-charset="UTF-8">
                        @csrf
                        <input type="hidden" name="isbn" value="{{$books->isbn}}">
                        <input class="add-to-cart" type="submit" value="Add to cart"><br><br>
                    </form>
                </div>
            @endauth
        @endif
      </div>
    </div>
  </body>
</html>

