<?php

namespace boxe\Http\Controllers\API;

use auth;
use boxe\info;
use boxe\shippment;
use Illuminate\Http\Request;
use boxe\Http\Controllers\Controller;

class InfoController extends Controller
{
    public function index()
    {
        if(auth()->user()->type == 'admin'){
            $info = info::with('shippment')->get();
            return $info;
        }else{
            $user = auth()->user();
            return $user->shippment->info()->with('shippment')->get();
        }
    }

    
    public function store(Request $request)
    {
        if(auth()->user()->type == 'disable'){
            return response()->json(['error' => 'Account Disabled'], 422);   
        }
        else{
            $this->validate($request, [
                'shippment_id' => ['required'],
                'trackId' => ['required'],
                'location' => ['required'],
                'status' => ['required'],
                'remark' => ['required'],
            ]);
        
            return info::create([  
                'shippment_id' => $request ['shippment_id'],
                'trackId' => $request ['trackId'],
                'location' => $request ['location'],
                'status' => $request ['status'],
                'remark' => $request ['remark'],
            ]);
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        if(auth()->user()->type == 'disable'){
            return response()->json(['error' => 'Account Disabled'], 422);   
        }
        else{
                $info = info::findOrFail($id);
                $this->validate($request, [
                    'trackId' => ['required'],
                    'location' => ['required'],
                    'status' => ['required'],
                    'remark' => ['required'],
                ]);

                $info->update($request->all());
                return ['message' => 'updated  Info'];
            
            }
        }

   
    public function destroy($id)
    {
        $info = info::findOrFail($id);
        $info->delete();
        return ['message' => 'Info Deleted'];
    }
}
