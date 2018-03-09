<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        /*echo'<pre>';
        print_r($_POST);
        print_r($_FILES);
        die('tesr');*/


        $this->validate(request(), [
             'name' => 'required',
             'price' => 'required|numeric',
           //  'product_image' => 'required|mimes:jpg,png,jpeg,gif',
             'product_category' => 'required'
        ]);
        
        $data = array
          (
            'name' => $request->name,
            'price' => $request->price,            
            'product_image_one' => '',
            'product_image_two' => '',
            'product_image_three' => '',
            'product_category' => $request->product_category,
          );
        
       echo'<pre>';   
       // print_r($_FILES);
       // print_r(File::extension($_FILES['product_image']['name'][1]));
       // print_r(count(array_filter($_FILES['product_image']['name'])));
       // die;   

        $product =  Product::create($data);

        $imgLength = count(array_filter($_FILES['product_image']['name']));
        $files = $request->file('product_image');
        
        print_r($files);
        die;

      /* foreach($files as $file)
       {
                $extension = $file->getClientOriginalExtension();
                $fileName = str_random(5)."-".date('his')."-".str_random(3).".".$extension;
                $folderpath  = 'images'.'/';
                $file->move($folderpath , $fileName);
        }*/




        for($i=0;$i<$imgLength;$i++)
        {
            $extension = File::extension($_FILES['product_image']['name'][$i]);
            $image_name[$i]= $product->id.'_'.$i.'.'.$extension;
            $imgResponse = $request->file('product_image')->move(public_path("/uploads/product/"), $image_name[$i]);   
        }

        print_r($imgResponse);
        die('after');


        $imgUpload = Product::where('id', $product->id)->update(array('product_image_one' => $image_name[0],
            'product_image_two' => $image_name[1],'product_image_three' => $image_name[2]
            ));

      /*echo'<pre>';
        print_r($product->id); 
        die;*/
        if($imgUpload)
        {
         return back()->with('success','Product has been added.');       
        }else{
         return back()->with('error','Something went wrong.');
        }     

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
