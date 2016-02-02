<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiController extends Controller
{
    use SoftDeletes;

    public function widgetData(){
        $result['data'] = DB::table('widgets')
                            ->select('id', 'slug', 'widget_name', 'created_at')
                            ->whereNull('deleted_at')
                            ->get();
        return json_encode($result);
    }
}