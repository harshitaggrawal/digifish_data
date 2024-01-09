<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\integrations; 
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class newData extends Controller
{
    public function index()
    {
        try {

            $yesterdayDate = Carbon::yesterday();  
            $yesterdayDate = $yesterdayDate->format('d/m/Y');
              $dataSql=integrations::select('country','aggregator','product','operator')->get();
            return view('showData', ['sql'=>$dataSql,'country'=>"Select an country",'aggregator'=>"Select an Aggregator",'product'=>"Select an product",'operator'=>"Select an operator",'date'=>$yesterdayDate,'datefrom'=>$yesterdayDate ,'dateto'=>$yesterdayDate]);

        }
         catch (Exception $e) {
            dd($e->getMessage());
        }
    }








    public function showdata(Request $request)
    {
        

        $country=$request->input('country');
        $aggregator=$request->input('aggregator');
        $product=$request->input('product');
        $operator=$request->input('operator');

       
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

        try {
           
           $dataMongo = DB::connection('mongodb')->collection('all_reports_daily')->where(['integration_id'=> $id[0]])->get();

        //    dd($dataMongo);
            $dataSql=integrations::select('country','aggregator','product','operator')->get();
            $particularData=[];
            for($a=0;$a<count($dataMongo);$a++)
            {             
              $particularData[$dataMongo[$a]['date']] = $dataMongo[$a]['stats'];
            }
            // dd($particularData);
            $i=0;
            $alldata=[];
            foreach($particularData as $mainDate => $dateData)
            {

                if($mainDate>=$from && $mainDate <=$to)
                {
                    $alldata[$mainDate]=$dateData;
                }

            }            
            // dd($alldata);
            $array1=[];
            foreach($alldata as $Date => $DataofDate)
            {
                foreach($particularData as $mainDate => $dateData)
                {
                   
                   
                    if($Date==$mainDate)
                    {
                        $array2=[];
                        $index = array_search($mainDate, array_keys($particularData));
                        // dump($index);
                        $keys=array_keys($particularData);
                        // dump(count($keys));
                        for($i=$index;$i<count($keys);$i++)
                        {
                            if($i==$index || $i==$index+3 || $i==$index+7 || $i==$index+14 || $i==$index+28)
                            {
                                // dump($i);

                                $array2[$keys[$i]]= $particularData[$keys[$i]][$mainDate];
                            }
                        }
                        // dump($array2);
                    }
                }
                // dump($array2);
                $array1[$Date]=$array2;

            }

            
            dd($array1);


                // if($i==1 || $i==3 || $i==7 || $i==14 || $i==28)
                // {                        
                //         ksort($dateData);                                  
                //         $particular=[];
                //         foreach($dateData as $date => $dvalue)
                //         {
                            
                //             if ($date>=$from && $date<=$to) {
                                
                //                 $particular[$date] = $dvalue;
                
                //             }
                //         }
                //         $alldata[$mainDate]=$particular;
                // }                
           
        } 
        
        catch (\Throwable $th) {
            throw $th;
        }
    }


}