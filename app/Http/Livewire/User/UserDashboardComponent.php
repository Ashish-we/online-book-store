<?php

namespace App\Http\Livewire\User;


use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Livewire\Component;

class UserDashboardComponent extends Component
{   public function render()
    {
        $user = Auth::user();
        $already = Cart::all();
            
            if (Cart::exists()){
                foreach($already as $already_)
                {
                    if($already_->email == $user->email)
                    {
                        $cart_item = Cart::where('email', $user->email)->get();
                        return view('livewire.user.user-dashboard-component', ['cart_items' => $cart_item]);
                    }
                }
                return view('livewire.user.user-dashboard-component', ['cart_items' => 0] );
            }
            else{
                return view('livewire.user.user-dashboard-component',['cart_items' => $already]);
            }
    }
    
}
