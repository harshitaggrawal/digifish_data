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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3/dist/flatpickr.min.js"></script>

    <style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;

    }

    body {
        font-size: 80%;
    }

    .img {
        padding: 10px;
        display: flex;
    }

    .img img {
        margin: auto;
        height: 80px;
        width: auto;
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
        padding: .3rem;
        width: 250px;

    }

    form .select .date {
        padding: .3rem 2rem;
        width: 200px;
        border-radius: 8px;
        background: lightgrey;
        color: black;
        border: none;
        outline: none;
    }

    form .dateconn {
        display: flex;
        gap: 20px;
    }

    form .dateconn input {
        padding: .3rem 2rem;
        width: 180px;
        border-radius: 8px;
        background: lightgrey;
        color: black;
        border: none;
        outline: none;

    }

    form label {
        color: black;
        padding: .1rem .3rem;
        font-size: 22px;
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
        font-size: 22px;
        padding: .2rem 2rem;

    }


    .main {
        background: white;
        padding: 2rem 4%;
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

    .main .date .maindate {
        color: black;
        text-align: center;
        padding: 5px;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 2px;
        border-right: 1px solid black;
    }

    .main .date .maindate p {
        margin-bottom: 2px;
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
    </style>
</head>

<body>

    <div class="img">
        <img src="https://digifish3.com/images/logo2x.png" alt="">
    </div>
    <form action="selectdata" method="get">
        @csrf
        <div class="select">
            <select id="country" name="country" onChange="filterData()" value="{{$country}}">
                <option value="{{$country}}">{{$country}}</option>
            </select>
            <select name="aggregator" id="aggregator" onChange="filterProduct()" value="{{$aggregator}}">
                <option value="{{$aggregator}}">{{$aggregator}}</option>
            </select>
            <select name="product" id="product" onChange="filterOperator()" value="{{$product}}">
                <option value="{{$product}}">{{$product}}</option>
            </select>
            <select name="operator" id="operator" onChange="filterOption()" value="{{$operator}}">
                <option value="{{$operator}}">{{$operator}}</option>
            </select>

            <input type="text" id="inputdate" class="date" value="{{$date}}" name="date">
        </div>
        <div class="dateconn">
            <label for="from">From:</label>
            <input type="text" name="fromdate" value="{{$datefrom}}" id="from">
            <label for="to">To:</label>
            <input type="text" name="todate" value="{{$dateto}}" id="to">

            <button type='submit' id="button">Submit</button>
        </div>


    </form>




    @if(isset($notfound))
    <h1 class="notfound">{{$notfound}}</h1>
    @endif




    @if(isset($searchData))
    <div class="main">
        @foreach($searchData as $tdate=> $datevalue)
        <div class="date">
            <div class="maindate">

                <p id="alDate_{{$tdate}}d"></p>
                <p id="alDate_{{$tdate}}m"></p>
                <p id="alDate_{{$tdate}}y"></p>

            </div>

            <script>
            function getMonthName(monthNumber) {
                const monthNames = [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sept', 'Octo', 'Nov', 'Dec'
                ];


                if (monthNumber >= 1 && monthNumber <= 12) {

                    return monthNames[monthNumber - 1];
                } else {
                    return 'Invalid Month';
                }
            }




            document.querySelector("#alDate_{{$tdate}}d").textContent = "";
            document.querySelector("#alDate_{{$tdate}}m").textContent = "";
            document.querySelector("#alDate_{{$tdate}}y").textContent = "";

            var dateP = "<?php echo $tdate; ?>";

            var newdate = [...dateP];
            var year = newdate.slice(0, 4).join("");
            var month = getMonthName(newdate.slice(4, 6).join(""));
            var day = newdate.slice(6, 8).join("");

            //document.getElementById("alDate").innerHTML = day + "/" + month + "/" + year;

            document.querySelector("#alDate_{{$tdate}}d").textContent = day;
            document.querySelector("#alDate_{{$tdate}}m").textContent = month;
            document.querySelector("#alDate_{{$tdate}}y").textContent = year;
            </script>


            <div class="allcontent">
                <table class="table table-light">
                    <thead>
                        <tr  class="text-center">
                            <th scope="col">Publisher</th>
                            <th scope="col">SubPublisher</th>
                            <th scope="col">Subscribe</th>
                            <th scope="col">Unsubscribe</th>
                            <th scope="col" colspan="3">Renew</th>
                            <th scope="col">Failed_renew</th>
                            <th scope="col" colspan="3">Paid</th>
                            <th scope="col" colspan="3">Charged</th>
                            <th scope="col" colspan="3">Revenue</th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th></th>
                            <th></th>
                            <!-- Sub -->
                            <th>Count</th>
                            <!-- Unsub -->
                            <th>Unique</th>
                            <!-- Renew -->
                            <th>Count</th>
                            <th>Unique</th>
                            <th>Amount</th>
                            <!-- Failed renew -->
                            <th>Unique</th>
                            <!-- Paid -->
                            <th>Count</th>
                            <th>Unique</th>
                            <th>Amount</th>
                            <!-- charged -->
                            <th>Count</th>
                            <th>Unique</th>
                            <th>Amount</th>
                            <!-- Revenew -->
                            <th>TopLine</th>
                            <th>BottomLine</th>

                        </tr>
                        @foreach($datevalue as $pubId => $pubData)
                        <div class="content">

                            @foreach($pubData as $subPubId => $subPubData)



                            <tr>
                                <td>{{$pubId}}</td>
                                <td>{{$subPubId}}</td>

                                @if(array_key_exists('sub', $subPubData))
                                <td>{{$subPubData['sub']['count']}}</td>
                                @else <td>0</td>
                                @endif


                                @if(array_key_exists('unsub', $subPubData))
                                <td>{{$subPubData['unsub']['unique']}}</td>
                                @else
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
                                <td>{{$subPubData['renewal_failed']['unique']}}</td>
                                @else
                                <td>0</td>
                                @endif

                                @if(array_key_exists('paid', $subPubData))


                                @if(array_key_exists('count', $subPubData['paid']))
                                <td>{{$subPubData['paid']['count']}}</td>
                                @else
                                <td>0</td>
                                @endif

                                @if(array_key_exists('unique', $subPubData['paid']))
                                <td>{{$subPubData['paid']['unique']}}</td>
                                @else
                                <td>0</td>
                                @endif

                                @if(array_key_exists('amount', $subPubData['paid']))
                                <td>{{$subPubData['paid']['amount']}}</td>
                                @else
                                <td>0</td>
                                @endif



                                @else
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                @endif


                                @if(array_key_exists('charged', $subPubData))

                                <td>{{$subPubData['charged']['count']}}</td>
                                <td>{{$subPubData['charged']['unique']}}</td>
                                <td>{{$subPubData['charged']['amount']}}</td>
                                @else
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                @endif

                                <td id="revenue_{{$pubId}}_{{$tdate}}_{{$subPubId}}_top"></td>
                                <td id="revenue_{{$pubId}}_{{$tdate}}_{{$subPubId}}_bottom"></td>


                                <script>
                                    document.querySelector("#revenue_{{$pubId}}_{{$tdate}}_{{$subPubId}}_top").textContent = "";
                                    document.querySelector("#revenue_{{$pubId}}_{{$tdate}}_{{$subPubId}}_bottom").textContent = "";


                                var renewAmount = "<?php 
                                    if(array_key_exists('renewals', $subPubData))
                                    {
                                        echo $subPubData['renewals']['amount'];
                                    }
                                    else{
                                        echo 0;
                                    }
                                    ?>";

                                var chargedAmount = "<?php 
                                    if(array_key_exists('charged', $subPubData))
                                    {
                                        echo $subPubData['charged']['amount'];
                                    }
                                    else{
                                        echo 0;
                                    }
                                    ?>";

                                    // console.log(Number(renewAmount)+Number(chargedAmount));
                                    var sum=  Number(renewAmount)+Number(chargedAmount);
                                    var our_share = "<?php echo $our_share; ?>";
                                    var currency_conversion = "<?php echo $currency_conversion; ?>";
                                    // console.log(sum,our_share,currency_conversion);

                                    var topline=sum*currency_conversion;
                                    var bottomline=topline*our_share;

                                    // console.log(parseFloat(topline).toFixed(2));
                                    // console.log(topline,bottomline);
                                    document.querySelector("#revenue_{{$pubId}}_{{$tdate}}_{{$subPubId}}_top").textContent = parseFloat(topline).toFixed(2);
                                    document.querySelector("#revenue_{{$pubId}}_{{$tdate}}_{{$subPubId}}_bottom").textContent = parseFloat(bottomline).toFixed(2);

                                </script>

                            </tr>


                            @endforeach
                        </div>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        @endforeach
    </div>




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

        var selectOperator = document.getElementById("operator");

        selectOperator.innerHTML = '';

        uniqueOperator.forEach(function(element) {
            var option = document.createElement("option");
            option.text = element;
            option.value = element;
            selectOperator.add(option);
        });
    }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#inputdate", {
            dateFormat: "d/m/Y",

        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#from", {
            dateFormat: "d/m/Y",

        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#to", {
            dateFormat: "d/m/Y",

        });
    });
    </script>

</body>

</html>