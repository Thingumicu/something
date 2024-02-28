<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function listTables()
    {
        $tables = DB::select('SHOW TABLES');
        $tables = array_map('current',$tables);

        $tableCounts = [];

        foreach($tables as $table){
            $count = DB::table($table)->count();
            $tableCounts[$table] = $count;
        }

        return view('dashboard', compact('tables','tableCounts'));
    }

    public function seedDatabase()
    {

        Artisan::call('db:seed');

        return redirect()->route('dashboard')->with('success', 'Database seeded successfully.');
    }


}
