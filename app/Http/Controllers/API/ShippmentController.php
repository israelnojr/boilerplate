<?php

namespace boxe\Http\Controllers\API;

use boxe\shippment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use boxe\Http\Controllers\Controller;

class ShippmentController extends Controller
{
    public function index()
    {
        if(auth()->user()->type == 'admin'){
            return shippment::all();
        }else{
            $user = auth()->user();
            return $user->shippment()->get();
        }
    }

    
    public function store(Request $request)
    {
        if(auth()->user()->type == 'disable'){
            return response()->json(['error' => 'Account Disabled'], 422);      
        }
        else{
            $this->validate($request, [                
                'key' => ['unique:shippments'],                    
                'title' => ['required', 'string' ], 
                'shipperName' => ['required', 'string' ],
                'shipperNum' => ['required', 'max:15' ],
                'shipperAddress'  => ['required', 'string'],
                'recieverName' => ['required', 'string'],
                'recieverNum'  => ['required', 'max:15' ],
                'recieverAddress' => ['required', 'string'],
                'type'        => ['required', 'string'],
                'weight'      => ['required'],
                'departure'   => ['required', 'string'],
                'destination' => ['required', 'string'],
                'bookingMode' => ['required', 'string'],
                'amount'      => ['required'],
                'mode'        => ['required', 'string'],
                'pickupDate'  => ['required', 'string'],
                'description' => ['required', 'string'],
            ]);
        
            return shippment::create([
                'key' => str_random(11),
                'user_id' => Auth::user()->id,
                'title' => $request ['title'],     
                'shipperName' => $request ['shipperName'], 
                'shipperNum' => $request ['shipperNum' ], 
                'shipperAddress'  => $request ['shipperAddress'],
                'recieverName' => $request ['recieverName'],
                'recieverNum'  => $request ['recieverNum' ],
                'recieverAddress' => $request ['recieverAddress'],
                'type'        => $request ['type'],
                'weight'      => $request ['weight'],
                'departure'   => $request ['departure'],
                'destination' => $request ['destination'],
                'bookingMode' => $request ['bookingMode'],
                'amount'      => $request ['amount'],
                'mode'        => $request ['mode'],
                'pickupDate'  => $request ['pickupDate'],
                'description' => $request ['description'],
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        if(auth()->user()->type == 'disable'){
            return response()->json(['error' => 'Account Disabled'], 422);   
        }
        else{
            $shippment = shippment::findOrFail($id);
            $this->validate($request, [
                'key' => [],                    
                'title' => ['required', 'string' ], 
                'shipperName' => ['required', 'string' ],
                'shipperNum' => ['required', 'max:15' ],
                'shipperAddress'  => ['required', 'string'],
                'recieverName' => ['required', 'string'],
                'recieverNum'  => ['required', 'max:15'],
                'recieverAddress' => ['required', ],
                'type'        => ['required', 'string'],
                'weight'      => ['required'],
                'departure'   => ['required', 'string'],
                'destination' => ['required', 'string'],
                'bookingMode' => ['required', 'string'],
                'amount'      => ['required'],
                'mode'        => ['required', 'string'],
                'pickupDate'  => ['required', 'string'],
                'description' => ['required', 'string'],
            ]);

            $shippment->update($request->all());
            return response()->json(['success' => 'Shippment updated successfully'], 200);   
        }    
    }

    
    public function destroy($id)
    {
        $shippment = shippment::findOrFail($id);
        $shippment->delete();
        return ['message' => 'shippment Deleted'];
    }
}
