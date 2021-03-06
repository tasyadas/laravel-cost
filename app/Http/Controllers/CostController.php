<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cost;
use Carbon\Carbon;
use App\Http\Controllers\CostController;
use Illuminate\Support\Facedes\Session;
use Illuminate\Support\Facades\Storage;

class CostController extends Controller
{
    public static function GetCost()
    {
        $loginauth = session()->get('data');
        if ($loginauth != null) {
            $costs = Cost::where('user_id', $loginauth->id)->get();
            return $costs;

        }else{
            return redirect('/');
        }
    }

    public static function SumCost()
    {
        $sum = CostController::GetCost()->sum('total');
        // $sum = 0;
        // foreach ($costs as $key) {
        //     $sum = $sum + $key->total;
        // }
        // dd($sum);

        return $sum;
    }

    public function CreateCost(Request $request)
    {
        $user_id=session()->get('data')->id;
        $now = Carbon::now('Asia/Jakarta');
        $time = '[' . $now->micro . ']';

        $filename = str_replace(array('/', '\\', ':', ' '), '', strtolower($request->name) . $time . '.png');
        $destinationPath = 'uploads/image/';

        $file = $request->image;
        $file->move(public_path($destinationPath), $filename);

        $create = Cost::create([
            'user_id'=> $user_id,
            'name' => $request->name,
            'qty' => $request->qty,
            'value' => $request->value,
            'total' => $request->qty * $request->value,
            'image' => $destinationPath . '/' . $filename,
            'created_at' => Carbon::now('Asia/Jakarta'),
            'updated_at' => Carbon::now('Asia/Jakarta')
        ]);

        // return $create;
        return redirect('/pengeluaran');
    }

    public function DeleteCost($id)
    {
        $cost = Cost::find($id);

        if ($cost->image != null){
            $cost->image = Storage::delete([$cost->image]);
        }

        $cost->delete();
        return redirect('/pengeluaran');
    }

    public function UpdateCost(Request $request, $id)
    {
        $cost = Cost::find($id);
        $cost->name = $request->name;
        $cost->qty = $request->qty;
        $cost->value = $request->value;
        $cost->total = $request->qty * $request->value;
        $cost->updated_at = Carbon::now('Asia/Jakarta');

        if ($request->image != null) {
            $oldimg = $cost->image;
            Storage::delete([$oldimg]);
            $now = Carbon::now('Asia/Jakarta');
            $time = '[' . $now->micro . ']';

            $filename = str_replace(array('/', '\\', ':', ' '), '', strtolower($request->name) . $time . '.png');
            $destinationPath = 'uploads/image/';

            $file = $request->image;
            $file->move(public_path($destinationPath), $filename);

            $cost->image = $destinationPath . '/' . $filename;
        }

        $cost->save();

        return redirect('/pengeluaran');
    }
}
