<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Widget;
use Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\AuthTraits\OwnsRecord;
use App\Exceptions\UnauthorizedException;
use App\Category;
use App\Subcategory;

class WidgetController extends Controller
{
    use OwnsRecord;
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['index', 'show']] );
        $this->middleware('auth', ['except' => ['index', 'show']] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('widget.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('category_name', 'asc')->lists('category_name', 'id');
        $subcategories = array();
        return view('widget.create', compact('categories','subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'widget_name' => 'required|unique:widgets|string|max:40',
            'category_id' => 'required',
            'subcategory_id' =>  'required'

        ]);

        $slug = str_slug($request->widget_name, "-");

        $widget = Widget::create(['widget_name' => $request->widget_name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'user_id' => Auth::id()]);

        $widget->save();

        alert()->success('Congrats!', 'You made a widget');

        return Redirect::route('widget.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug = '')
    {
        $widget = Widget::findOrFail($id);

        if ($widget->slug !== $slug) {

            return Redirect::route('widget.show', ['id' => $widget->id,
                'slug' => $widget->slug],
                301);
        }

        return view('widget.show', compact('widget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $widget = Widget::findOrFail($id);

        if ( ! $this->adminOrCurrentUserOwns($widget)){
            throw new UnauthorizedException;
        }
        $categories = Category::orderBy('category_name', 'asc')->lists('category_name', 'id');
        $subcategories = Subcategory::orderBy('subcategory_name', 'asc')->where('category_id','=',$widget->category_id)->lists('subcategory_name', 'id');
        return view('widget.edit', compact('widget','categories','subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'widget_name' => 'required|string|max:40|unique:widgets,widget_name,' .$id,
            'category_id' => 'required',
            'subcategory_id' =>  'required'
        ]);

        $widget = Widget::findOrFail($id);

        if ( ! $this->adminOrCurrentUserOwns($widget)){
            throw new UnauthorizedException;
        }

        $slug = str_slug($request->widget_name, "-");

        $widget->update(['widget_name' => $request->widget_name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'user_id' => Auth::id()]);

        alert()->success('Congrats!', 'You updated a widget');

        return Redirect::route('widget.show', ['widget' => $widget, 'slug' =>$slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Widget::destroy($id);

        alert()->overlay('Attention!', 'You deleted a widget', 'error');

        return Redirect::route('widget.index');
    }
}
