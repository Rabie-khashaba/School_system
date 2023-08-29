<?php

namespace App\Http\Controllers;

use App\Http\Traits\AttachFilesTrait;
use App\Models\Setting;
use Illuminate\Http\Request;

class settingController extends Controller
{
    use AttachFilesTrait;
    public function index(){

        $collection = Setting::all();
        //return $collection;
        $setting['setting'] = $collection->flatMap(function ($collection) {
            return [$collection->key => $collection->value];
        });

        //return $setting;
        return view('pages.setting.index', $setting);
    }

    public function update(Request $request){

        try{
            $info = $request->except('_token', '_method', 'logo');
           // return  $info;
            foreach ($info as $key=> $value){  // key --> name   , value --> mllk
                Setting::where('key', $key)->update(['value' => $value]);
            }


//            $key = array_keys($info);
//            $value = array_values($info);
//            for($i =0; $i<count($info);$i++){
//                Setting::where('key', $key[$i])->update(['value' => $value[$i]]);
//            }

            if($request->hasFile('logo')) {
                $logo_name = $request->file('logo')->getClientOriginalName();
                Setting::where('key', 'logo')->update(['value' => $logo_name]);
                $this->uploadFile($request,'logo','logo');
            }

            $notification = array(
                'message' => 'Setting Updated successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('settings.index')->with($notification);
        }
        catch (\Exception $e){

            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }
}
