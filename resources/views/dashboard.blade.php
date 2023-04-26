<x-app-layout>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Items in your cart!") }}
                </div>
                <div class="p-6 text-gray-900">
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">SN</th>
                            <th scope="col">Title</th>
                            <th scope="col">Price</th>
                            <th scope="col">No of items</th>
                            <th scope="col">ISBN</th>
                            </tr>
                        </thead>
                        <?php
                        $total_cost=0;
                        foreach($cart_items as $item)
                            {
                                $total_cost += $item->price*$item->num_of_items;
                            }
                            
                        
                        ?>
                            @foreach($cart_items as $item)
                                <tbody>
                                    <tr>
                                    <th scope="row">1</th>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->num_of_items}}</td>
                                    <td>{{$item->isbn}}</td>
                                    <td><form method="post" action="{{route('decrease_items')}}">
                                        @csrf
                                        <input type="hidden" value="{{$item->isbn}}" name="isbn">
                                        <input class="btn btn-danger" type="submit" value="decrease/delete">
                                    </form>
                                    </td>
                                    </tr>  
                                </tbody>
                            @endforeach 
                    </table>
                    <div class="p-6 text-gray-900">
                    Total Price : {{$total_cost}}
                    </div>
                    <button type="button" class="btn btn-outline-warning">Buy</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
