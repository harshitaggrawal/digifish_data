<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;

    }

    .img {
        padding: 10px;
        display: flex;
    }

    .img img {
        margin: auto;
    }

    form {
        /* margin:auto; */
        padding: 15px;
    }

    form .select {
        display: flex;
        gap: 18px;
        padding-bottom: 20px;
    }

    form .select select {
        padding: .5rem;
        width: 250px;

    }

    form button {
        padding: .2rem;
        width: 150px;
        background: green;
        color: white;
        border: none;
        outline: none;
        display: flex;
        align-items: center;
        border-radius: 8px;
        font-size: 25px;
    }


    .main {
        background: white;
        padding: 2rem 5%;
        color: black;
        /* display:none; */
    }

    .main .date {
        display: flex;
        color: black;
        border: 2px solid black;
        border-radius: 10px;
        color: white;
        padding: 4px;
        margin-bottom: 20px;
    }

    .main .date .allcontent .content {
        display: flex;
    }

    .main .date h1 {
        color: black;
        text-align: center;
        padding: 5px;
        font-size: 30px;
    }

    .main .date hr {
        background: black;
        height: 3px;
        color: black;

    }

    .main .date .id {
        color: black;
        padding: 0 10px;
    }

    .notfound {
        color: red;
        font-size: 35px;
        text-align: center;
    }

    .search {
        display: flex;
        gap: 25px;

    }

    .search input {
        padding: .1rem .3rem;
        width: 200px;
        border-radius: 8px;
        background: lightgrey;
        color: black;
        border: none;
        outline: none;

    }

    .search button {
        padding: .2rem 2rem;
        width: 150px;
        background: green;
        color: white;
        border: none;
        outline: none;
        display: flex;
        align-items: center;
        border-radius: 8px;
        font-size: 25px;
    }
    </style>
</head>

<body>

    <div class="img">
        <img src="https://digifish3.com/images/logo2x.png" alt="">
    </div>
    <form action="selectdata" method="get">
        @csrf
        <div class="select">
            <select id="country" name="country" onChange="filterData()"></select>
            <select name="aggregator" id="aggregator" onChange="filterProduct()" style="display:none;"></select>
            <select name="product" id="product" onChange="filterOperator()" style="display:none;"></select>
            <select name="operator" id="operator" onChange="filterOption()" style="display:none;"></select>
        </div>
        <center> <button type='submit' style="display:none;" id="button">Submit</button></center>
    </form>



    @if(isset($data))

    <form action="search" class="search ">
        @csrf
        <input type="text" name="searchdate" placeholder="YYYYMMDD" id="">
        <input type="text" name="fromdate" placeholder="From: YYYYMMDD" id="">
        <input type="text" name="todate" placeholder="To :YYYYMMDD" id="">

        <button type="submit">search</button>

    </form>


    <div class="main">
        @foreach($data['stats'] as $tdate=> $datevalue)
        <div class="date">
            <h1>Date: {{$tdate}}</h1>
            <hr>
            <div class="allcontent">

                @foreach($datevalue as $pubId => $pubData)
                <div class="content">
                    <div class="id">
                        <p>Publisher Id: {{$pubId}}</p>
                        @foreach($pubData as $subPubId => $subPubData)
                        <p> SubPublisher Id: {{$subPubId}}</p>
                    </div>
                    <table class="table table-light table-hover">
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
                </div>
                @endforeach


            </div>
        </div>
        @endforeach
    </div>



    @endif


    @if(isset($notfound))
    <h1 class="notfound">{{$notfound}}</h1>
    @endif




    @if(isset($searchDate))


    <form action="search" class="search">
        @csrf
        <input type="text" name="searchdate" placeholder="YYYYMMDD">
        <input type="text" name="fromdate" placeholder="From: YYYYMMDD" id="">
        <input type="text" name="todate" placeholder="To :YYYYMMDD" id="">
        <button type="submit">Search</button>

    </form>

    <div class="main">
        <div class="date">
            <h1>Date: {{$search}}</h1>
            <div class="allcontent">
                @foreach($searchDate as $pubId => $pubData)
                <div class="content">
                    <div class="id">
                        <p>Publisher Id: {{$pubId}}</p>
                        @foreach($pubData as $subPubId => $subPubData)
                        <p> SubPublisher Id: {{$subPubId}}</p>
                    </div>  
                    <table class="table table-light table-hover">
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
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif


    @if(isset($datenotfound))
    <form action="search" class="search">
        @csrf
        <input type="text" name="searchdate" placeholder="YYYYMMDD">
        <input type="text" name="fromdate" placeholder="From: YYYYMMDD" id="">
        <input type="text" name="todate" placeholder="To :YYYYMMDD" id="">
        <button type="submit">Search</button>

    </form>
    <h1 class="notfound">{{$datenotfound}}</h1>
    @endif

    <script>
    var Sql = <?php echo json_encode($sql); ?>;
    // console.log(Sql);



    var uniqueArray = [...new Set(Sql.map(item => item.country))];
    uniqueArray.unshift("Select a Country");

    var selectElement = document.getElementById("country");
    uniqueArray.forEach(function(element) {
        var option = document.createElement("option");
        option.text = element;
        option.value = element;
        selectElement.add(option);
    });


    function filterData() {

        var selectOperator = document.getElementById("operator").style.display = 'none';

        var selectOperator = document.getElementById("operator");
        selectOperator.innerHTML = '';

        var selectProduct = document.getElementById("product");
        selectProduct.innerHTML = '';
        selectProduct.style.display = 'none';

        document.getElementById("button").style.display = 'none';

        var selectAgg = document.getElementById("aggregator").style.display = 'block';
        var selectedValue = selectElement.value;
        // console.log(selectedValue);


        var filteredData = Sql.filter(item => item.country === selectedValue);
        // console.log(filteredData);


        var Aggregator = filteredData.map(function(item) {
            return item.aggregator;
        });
        // console.log(Aggregator);

        var uniqueAggregator = [...new Set(Aggregator)];
        // console.log(uniqueAggregator);
        var selectAgg = document.getElementById("aggregator");

        selectAgg.innerHTML = '';
        uniqueAggregator.unshift("Select an Aggregator");


        uniqueAggregator.forEach(function(element) {
            var option = document.createElement("option");
            option.text = element;
            option.value = element;
            selectAgg.add(option);
        });
    }


    function filterProduct() {
        var selectOperator = document.getElementById("operator");
        selectOperator.innerHTML = '';
        selectOperator.style.display = 'none';
        document.getElementById("button").style.display = 'none';



        var selectElement = document.getElementById("country");
        let country = selectElement.value;
        var selectAgg = document.getElementById("aggregator");
        let aggregator = selectAgg.value;
        // console.log(country,aggregator);
        var filteredData = Sql.filter(item => item.aggregator === aggregator && item.country === country);
        // console.log(filteredData);



        var uniqueProduct = [...new Set(filteredData.map(item => item.product))];
        uniqueProduct.unshift("Select an Product");

        // console.log(uniqueProduct);

        var selectProduct = document.getElementById("product").style.display = 'block';
        var selectProduct = document.getElementById("product");
        selectProduct.innerHTML = '';

        uniqueProduct.forEach(function(element) {
            var option = document.createElement("option");
            option.text = element;
            option.value = element;
            selectProduct.add(option);
        });

    }

    function filterOperator() {
        document.getElementById("button").style.display = 'none';


        var selectElement = document.getElementById("country");
        let country = selectElement.value;
        var selectAgg = document.getElementById("aggregator");
        let aggregator = selectAgg.value;

        var selectProduct = document.getElementById("product");
        let product = selectProduct.value;
        console.log(country, aggregator, product);
        var filteredData = Sql.filter(item => item.aggregator === aggregator && item.country === country && item
            .product === product);
        console.log(filteredData);


        var uniqueOperator = [...new Set(filteredData.map(item => item.operator))];
        uniqueOperator.unshift("Select an Operator");

        console.log(uniqueOperator);
        var selectOperator = document.getElementById("operator").style.display = 'block';
        var selectOperator = document.getElementById("operator");

        selectOperator.innerHTML = '';

        uniqueOperator.forEach(function(element) {
            var option = document.createElement("option");
            option.text = element;
            option.value = element;
            selectOperator.add(option);
        });
    }

    function filterOption() {
        document.getElementById("button").style.display = 'block';

    }
    </script>



</body>

</html>