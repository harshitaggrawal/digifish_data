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
            $dataSql=integrations::select('country','aggregator','product','operator')->get();

            // dd($dataMongo[129]);
            // dd(count($dataMongo));
            for($a=0;$a<count($dataMongo);$a++)
            {
                $intData=$dataMongo[$a]['integration_data'];
                if($intData['country']==$country && $intData['aggregator']==$aggregator && $intData['product']==$product && $intData['operator']==$operator)
                {
                //    dump($dataMongo[$a]);
                    request()->session()->put('data', $dataMongo[$a]['stats']);
                        return view('index',['data'=>$dataMongo[$a],'sql'=>$dataSql]);
                        break;                 
                }        
            }

            return view('index',['notfound'=>"Data not Found",'sql'=>$dataSql]);
       } 
        
        catch (\Throwable $th) {
            //throw $th;
        }
    }

    function search(Request $request)
    {
        $dataSql=integrations::select('country','aggregator','product','operator')->get();
        $value = session()->get('data');
      
        $search=$request->input('searchdate');
        $from=$request->input('fromdate');
        $to=$request->input('todate');

        foreach($value as $date => $dvalue)
        {
            if($search==$date)
            {
                // dd("data found");
                return view('index',['searchDate'=>$value[$search],'sql'=>$dataSql,'search'=>$search]);
                break;
            }
            elseif ($date>=$from && $date<=$to) {
                return view('index',['searchDate'=>$value[$date],'sql'=>$dataSql,'search'=>$date]);

            }
        }

        return view('index',['datenotfound'=>"Data not Found",'sql'=>$dataSql]);



    }

}
