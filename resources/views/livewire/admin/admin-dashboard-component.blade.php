<div>
    <h1>Admin dashboard</h1>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                            
<div class="text-center text-sm text-gray-500 sm:text-left">
        <div class=" m-5">
            @if (Route::has('login'))
                @auth
                    @if(Auth::user()->utype == 'ADM')
                        <a class="btn btn-primary" role="button" href="{{route('add')}}" class="ml-1">
                            Add Book
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</div>  
                            
                    