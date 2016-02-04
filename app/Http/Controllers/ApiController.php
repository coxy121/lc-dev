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

    public function profileData()
    {

        $result['data'] = DB::table('profiles')
            ->select('profiles.id as id',
                'first_name',
                'last_name',
                'gender',
                'birthdate',
                'name',
                'users.id as user')
            ->leftJoin('users', 'user_id', '=', 'users.id')
            ->get();

        return json_encode($result);

    }

    public function userData(){

        $result['data'] = DB::table('users')->select('id',
            'name',
            'email',
            'is_subscribed',
            'is_admin',
            'user_type_id',
            'status_id',
            'created_at')->get();

        return json_encode($result);

    }
}