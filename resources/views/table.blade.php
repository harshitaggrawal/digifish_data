<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<style>
      *{
            padding: 0;
            margin:0;
            box-sizing:border-box;
            
        }

        .main{
            background:black;

            padding:2rem 5%;
        }
        .main .date{
            border:2px solid white;
            border-radius:10px;
            color:white;
            margin-bottom:40px;
        }
        .main .date h1{
            text-align:center;
            padding:5px ;
        }
        .main .date hr{
            background:white;
            height:3px;
        }
        .main .date .id{
            display:flex;
            justify-content:space-between;
            padding:0 10px;
        }
</style>
</head>
<body>


<div class="main">



    
@forelse($data['stats'] as $tdate=> $datevalue)
    <div class="date">
        <h1>Date: {{$tdate}}</h1>
        <hr>

        @foreach($datevalue as $pubId => $pubData)
        <div class="id">
            <p>Publish Id: {{$pubId}}</p>
            @foreach($pubData as $subPubId => $subPubData)
                <p> SubPublish: {{$subPubId}}</p>
        </div>
                <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">Subscribe</th>
                        <th scope="col" colspan="3">Unsubscribe</th>
                        <th scope="col" colspan="3">Renew</th>
                        <th scope="col" colspan="3">Failed_renew</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- Sub -->
                        <td>Count</td>
                        <!-- Unsub -->
                        <td>Count</td>
                        <td>Unique</td>
                        <td>Amount</td>
                        <!-- Renew -->
                        <td>Count</td>
                        <td>Unique</td>
                        <td>Amount</td>
                        <!-- Failed renew -->
                        <td>Count</td>
                        <td>Unique</td>
                        <td>Amount</td>
                    </tr>
                    <tr>
                        @if(array_key_exists('sub', $subPubData))
                        <td>{{$subPubData['sub']['count']}}</td>
                        @else <td>0</td>
                        @endif
                       

                        @if(array_key_exists('unsub', $subPubData))

                        <td>{{$subPubData['unsub']['count']}}</td>
                        <td>{{$subPubData['unsub']['unique']}}</td>
                        <td>{{$subPubData['unsub']['amount']}}</td>
                        @else
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        @endif

                        @if(array_key_exists('renewals', $subPubData))

                        <td>{{$subPubData['renewals']['count']}}</td>
                        <td>{{$subPubData['renewals']['unique']}}</td>
                        <td>{{$subPubData['renewals']['amount']}}</td>
                        @else
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        @endif

                        @if(array_key_exists('renewal_failed', $subPubData))
                        <td>{{$subPubData['renewal_failed']['count']}}</td>
                        <td>{{$subPubData['renewal_failed']['unique']}}</td>
                        <td>{{$subPubData['renewal_failed']['amount']}}</td>

                        @else
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                       
                        @endif
                    </tr>
                </tbody>
                </table>

            @endforeach
        @endforeach
    </div>


    @empty
    <p>No data available.</p>
@endforelse

</div>



</body>
</html>