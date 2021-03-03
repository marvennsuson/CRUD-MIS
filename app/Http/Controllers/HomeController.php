<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User; 
use App\BusinessPermit; 

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected $bp;
    public function __construct()
    {
        $this->bp = new BusinessPermit;
    }
    public function index()
    {

        $data['count_bp'] = $this->bp->countTypeOfBusinessPermits();
        $data['main_page'] = 'dashboard';
        $data['sub_page'] = '';
        return view('admin.dashboard.home', $data);
    }
}
