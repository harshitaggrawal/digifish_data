<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\integrations; 
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function index()
    {
 
        try {
           
              $dataSql=integrations::select('country','aggregator','product','operator')->get();
            return view('index', ['sql'=>$dataSql]);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
      
    }

    public function selectdata(Request $request)
    {
        

        $country=$request->input('country');
        $aggregator=$request->input('aggregator');
        $product=$request->input('product');
        $operator=$request->input('operator');

        // dd($country, $aggregator,$product,$operator);
        try {
            $dataMongo = DB::connection('mongodb')->collection('all_reports_daily')->get();
            // dd($dataMongo[129]);
            // dd(count($dataMongo));
            for($a=0;$a<count($dataMongo);$a++)
            {
                $intData=$dataMongo[$a]['integration_data'];
                if($intData['country']==$country && $intData['aggregator']==$aggregator && $intData['product']==$product && $intData['operator']==$operator)
                {
                   
                        return view('table',['data'=>$dataMongo[$a]]);
                        break;
                    
                     
                   
                }        
            }

            return view('notfound');
       } 
        
        catch (\Throwable $th) {
            //throw $th;
        }
    }




}
