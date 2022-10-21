<?php

namespace App\View\Composers;

use App\Models\core\cart;
use App\Models\core\offer;
use Illuminate\View\View;

class NavbarComposer
{
    public function compose(View $view)
    {
        $cart_count = cart::query()
            ->where('user_id', auth()->id())
            ->count();

        $cart_count += offer::query()
            ->where('user_id', auth()->id())
            ->count();

        $view->with('cart_counts', $cart_count);
    }
}
