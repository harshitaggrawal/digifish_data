<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\integrations; 
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $date=$request->input('date');
        $carbonDate = Carbon::parse($date);
        $formattedDate = $carbonDate->toDateString();
        $date = str_replace("-", "", $formattedDate);
     

        
        $id = integrations::where('country', $country)
        ->where('aggregator', $aggregator)
        ->where('product', $product)
        ->where('operator', $operator)
        ->pluck('id');

        try {
           
           $dataMongo = DB::connection('mongodb')->collection('all_reports_daily')->where(['integration_id'=> $id[0]])->get();
       
            $dataSql=integrations::select('country','aggregator','product','operator')->get();
            $particular=[];
            for($a=0;$a<count($dataMongo);$a++)
            {             
              $particular[$dataMongo[$a]['date']] = $dataMongo[$a]['stats'];
            }
           

            foreach($particular as $mainDate => $dateData)
            {
                if($mainDate==$date)
                {
                    
                    ksort($dateData);
                    
                    request()->session()->put('data', $dateData); 
                 return view('index',['data'=>$dateData,'sql'=>$dataSql,'date'=>$date]);

                }
            }

            
            return view('index',['notfound'=>"Data not Found",'sql'=>$dataSql]);
       } 
        
        catch (\Throwable $th) {
            throw $th;
        }
    }




    function search(Request $request)
    {
        $dataSql=integrations::select('country','aggregator','product','operator')->get();
        $value = session()->get('data');
  


        $from=$request->input('fromdate');
        $carbonDate = Carbon::parse($from);
        $formattedDate = $carbonDate->toDateString();
        $from = str_replace("-", "", $formattedDate);

        $to=$request->input('todate');
        $carbonDate = Carbon::parse($to);
        $formattedDate = $carbonDate->toDateString();
        $to = str_replace("-", "", $formattedDate);

        $particular=[];
        

        foreach($value as $date => $dvalue)
        {
            
            if ($date>=$from && $date<=$to) {
                
                $particular[$date] = $dvalue;

            }
        }
        if (empty($particular)) {
            
            return view('index',['datenotfound'=>"Data not Found",'sql'=>$dataSql]);

        } else {
            return view('index',['searchData'=>$particular,'sql'=>$dataSql]);
           
        }
       


    }

}