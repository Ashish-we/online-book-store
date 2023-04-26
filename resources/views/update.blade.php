<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            color: black !important;
        }
    </style>
</head>
<body class="antialiased">
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
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
        <a href="{{route('welcome')}}" style="margin-left: 90%;" class="btn btn-danger">Back</a>
        <form method="POST" action="{{url('update_book/'.$books->isbn)}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="put" />
            <div class="mb-3">
                <label for="text" class="form-label">Author name</label>
                <input type="text" class="form-control" value="{{$auth->name}}" name="author" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Title</label>
                <input type="text" class="form-control" value="{{$books->title}}" name="title" required>
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">Category </label>
                <input type="text" class="form-control" value="{{$books->Category}}" name="category" required>
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">Year</label>
                <input type="text" class="form-control" value="{{$books->year}}" name="year" required>
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">ISBN</label>
                <input type="text" class="form-control" value="{{$books->isbn}}" name="isbn" required>
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">Price</label>
                <input type="number" step="0.01" value="{{$books->price}}" class="form-control" name="price" required>
            </div>
            
            <div class="form-group mb-3">
                <label for="text" class="form-label">Current image : {{$bok->image}}</label>
                <input type="file"name="image" id="" class="form-control" required>
                <img style="height: 300px; width:200px; margin-top:40px; border-radius: 20px;" src="{{ asset('storage/images/'.$bok->image)}}" class="card-img-top" alt="...">

            </div>
            <input type="hidden" value="{{$books->isbn}}" name="old_isbn">
                <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>