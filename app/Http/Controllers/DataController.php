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

            $yesterdayDate = Carbon::yesterday();
           
            $yesterdayDate = $yesterdayDate->format('d/m/Y');

              $dataSql=integrations::select('country','aggregator','product','operator')->get();
            return view('index', ['sql'=>$dataSql,'country'=>"Select an country",'aggregator'=>"Select an Aggregator",'product'=>"Select an product",'operator'=>"Select an operator",'date'=>$yesterdayDate,'datefrom'=>$yesterdayDate ,'dateto'=>$yesterdayDate]);

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

        $dateInp=$request->input('date');
        $carbonDate = Carbon::createFromFormat('d/m/Y', $dateInp);
        $date = $carbonDate->format('Ymd');
        // dd($date);  
        $fromdate=$request->input('fromdate');
        $carbonDate = Carbon::createFromFormat('d/m/Y', $fromdate);
        $from = $carbonDate->format('Ymd');

        $todate=$request->input('todate');
        $carbonDate = Carbon::createFromFormat('d/m/Y', $todate);
        $to = $carbonDate->format('Ymd');
        // dd($from ,$to);

        $id = integrations::where('country', $country)
        ->where('aggregator', $aggregator)
        ->where('product', $product)
        ->where('operator', $operator)
        ->pluck('id');
        // dd($id);
        try {
           
           $dataMongo = DB::connection('mongodb')->collection('all_reports_daily')->where(['integration_id'=> $id[0]])->get();
    //    dd($dataMongo);
            $dataSql=integrations::select('country','aggregator','product','operator')->get();
            $particularData=[];
            for($a=0;$a<count($dataMongo);$a++)
            {             
              $particularData[$dataMongo[$a]['date']] = $dataMongo[$a]['stats'];
            }
            foreach($particularData as $mainDate => $dateData)
            {

                $our_share=$dataMongo[0]['integration_data']['our_share'];
                $currency_conversion=$dataMongo[0]['integration_data']['currency_conversion'];
    
            //    dd($our_share,$currency_conversion);
                if($mainDate==$date)
                {

                    ksort($dateData);                  
 
                        $particular=[];
        

                        foreach($dateData as $date => $dvalue)
                        {
                            
                            if ($date>=$from && $date<=$to) {
                                
                                $particular[$date] = $dvalue;
                
                            }
                        }

                        // dd($particular);
                        if (empty($particular)) {
                            
                            return view('index',['notfound'=>"Data not Found",'sql'=>$dataSql,'date'=>$dateInp,'country'=>$country,'aggregator'=>$aggregator,'product'=>$product,'operator'=>$operator,'datefrom'=>$fromdate ,'dateto'=>$todate]);
                
                        } else {

                            return view('index',['searchData'=>$particular,'sql'=>$dataSql,'date'=>$dateInp,'country'=>$country,'aggregator'=>$aggregator,'product'=>$product,'operator'=>$operator,'datefrom'=>$fromdate ,'dateto'=>$todate,'our_share'=>$our_share,'currency_conversion'=>$currency_conversion]);
                       
                           
                        }
                    
                }
                
            }
      
        return view('index',['notfound'=>"Data not Found",'sql'=>$dataSql,'date'=>$dateInp,'country'=>$country,'aggregator'=>$aggregator,'product'=>$product,'operator'=>$operator,'datefrom'=>$fromdate ,'dateto'=>$todate]);

            
       } 
        
        catch (\Throwable $th) {
            throw $th;
        }
    }





}