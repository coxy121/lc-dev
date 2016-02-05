<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use App\Category;
use App\Subcategory;

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

    public function marketingImageData()
    {
        $result['data'] = DB::table('marketing_images')
            ->select('id',
                'image_name',
                'image_extension',
                'is_active',
                'is_featured',
                'image_weight',
                'created_at')
            ->get();
        return json_encode($result);
    }

    public function categoryDropDownData()
    {

        $category_id = Input::get('category_id');

        /*
        $subcategories = Subcategory::where('category_id', '=', $category_id)
            ->orderBy('subcategory_name', 'asc')
            ->get();
        */
        $subcategories =  Category::find($category_id)->subcategory()->get();

        return Response::json($subcategories);


    }
}