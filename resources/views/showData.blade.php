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
        padding: .5rem;
        width: 250px;

    }

    form .select .date {
        padding: .5rem 2rem;
        width: 200px;
        border-radius: 8px;
        background: lightgrey;
        color: black;
        border: none;
        outline: none;
    }
    form .dateconn {
        display:flex;
        gap:20px;
    }
    form .dateconn input {
        padding: .5rem 2rem;
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
        font-size: 25px;
        padding: .2rem 2rem;

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



   
    </style>
</head>
<body>
    
<div class="img">
        <img src="https://digifish3.com/images/logo2x.png" alt="">
    </div>
    <form action="showdata" method="get">
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


            
        </div>
        <div class="dateconn">
        <label for="from">From:</label>
        <input type="text" name="fromdate" value="{{$datefrom}}" id="from">
        <label for="to">To:</label>
        <input type="text" name="todate" value="{{$dateto}}" id="to">

        <button type='submit' id="button">Submit</button>
        </div>


    </form>


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
        document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#inputdate", {
        dateFormat: "d/m/Y",
        
    });
});

document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#from", {
        dateFormat: "d/m/Y",
        
    });
});
document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#to", {
        dateFormat: "d/m/Y",
        
    });
});
    </script>

</body>
</html>