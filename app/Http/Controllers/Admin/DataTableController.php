<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Freshbitsweb\Laratables\Laratables;
use App\Dress;
use App\User;

class DataTableController extends Controller
{
    public function getCustomColumnDatatablesData()
    {
    	// abort_unless(\Gate::allows('dress_access'), 403);
        return Laratables::recordsOf(User::class);
    }
}
