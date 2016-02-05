<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateImageRequest;
use Intervention\Image\Facades\Image;
use App\MarketingImage;
use App\Http\Requests\EditImageRequest;
use Illuminate\Support\Facades\File;

class MarketingImageController extends Controller
{

    private $destinationFolder = '/imgs/marketing/';
    private $destinationThumbnail = '/imgs/marketing/thumbnails/';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('marketing-image.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marketing-image.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateImageRequest $request)
    {
        //create new instance of model to save from form

        $marketingImage = new Marketingimage([
            'image_name'        => $request->get('image_name'),
            'image_extension'   => $request->file('image')
                ->getClientOriginalExtension(),
            'is_active'         => $request->get('is_active'),
            'is_featured'       => $request->get('is_featured'),
            'image_weight'      => $request->get('image_weight')

        ]);

        // format checkbox values and save model

        $this->formatCheckboxValue($marketingImage);
        $marketingImage->save();

        //parts of the image we will need

        $file = Input::file('image');

        $imageName = $marketingImage->image_name;
        $extension = $request->file('image')
            ->getClientOriginalExtension();

        //create instance of image from temp upload

        $image = Image::make($file->getRealPath());

        //save image with thumbnail

        $image->save(public_path() . $this->destinationFolder
            . $imageName
            . '.'
            . $extension)
            ->resize(60, 60)
            // ->greyscale()
            ->save(public_path() . $this->destinationThumbnail
                . 'thumb-'
                . $imageName
                . '.'
                . $extension);

        alert()->success('Congrats!', 'Marketing Image Created!');

        return redirect()->route('marketing-image.show', [$marketingImage]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marketingImage = MarketingImage::findOrFail($id);

        return view('marketing-image.show', compact('marketingImage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $marketingImage = MarketingImage::findOrFail($id);

        return view('marketing-image.edit', compact('marketingImage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, EditImageRequest $request)
    {
        $marketingImage = MarketingImage::findOrFail($id);

        // assign new values to attributes

        $marketingImage->is_active = $request->get('is_active');
        $marketingImage->is_featured = $request->get('is_featured');
        $marketingImage->image_weight = $request->get('image_weight');
        // if file, assign file extension to model attribute

        if ( ! empty(Input::file('image'))) {

            // delete old images before saving new

            File::delete(public_path($this->destinationFolder) .
                $marketingImage->image_name . '.' .
                $marketingImage->image_extension);


            File::delete(public_path($this->destinationThumbnail) . 'thumb-' .
                $marketingImage->image_name . '.' .
                $marketingImage->image_extension);

            $marketingImage->image_extension = $request->file('image')->getClientOriginalExtension();
        }

        $this->formatCheckboxValue($marketingImage);

        $marketingImage->save();

        // check for file, if file, overwrite existing file

        if ( ! empty(Input::file('image'))){

            $file = Input::file('image');

            $imageName = $marketingImage->image_name;
            $extension = $request->file('image')->getClientOriginalExtension();

            //create instance of image from temp upload
            $image = Image::make($file->getRealPath());

            //save image with thumbnail
            $image->save(public_path() . $this->destinationFolder
                . $imageName
                . '.'
                . $extension)
                ->resize(60, 60)
                // ->greyscale()
                ->save(public_path() . $this->destinationThumbnail
                    . 'thumb-'
                    . $imageName
                    . '.'
                    . $extension);

        }

        alert()->success('Congrats!', 'image edited!');

        return view('marketing-image.show', compact('marketingImage'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marketingImage = MarketingImage::findOrFail($id);

        File::delete(public_path($this->destinationFolder).
            $marketingImage->image_name . '.' .
            $marketingImage->image_extension);

        File::delete(public_path($this->destinationThumbnail). 'thumb-' .
            $marketingImage->image_name . '.' .
            $marketingImage->image_extension);

        MarketingImage::destroy($id);

        alert()->error('Notice', 'image deleted!');

        return redirect()->route('marketing-image.index');
    }

    public function formatCheckboxValue($marketingImage)
    {
        $marketingImage->is_active = ($marketingImage->is_active == null) ? 0 : 1;
        $marketingImage->is_featured = ($marketingImage->is_featured == null) ? 0 : 1;
    }
}
