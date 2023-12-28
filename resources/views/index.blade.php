<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            padding: 0;
            margin:0;
            box-sizing:border-box;
            
        }
        
        .img{
            padding:20px ;
            display:flex;
        }
        .img img{
            margin:auto;
        }
        form{
            margin:auto;
            padding:45px;
            display:flex;
            flex-direction:column;
            gap:18px;
            align-items:center;
            width:450px;
     
        }
        form select{
            padding:.5rem;
            width:100%;

        }
        form button{
            padding:.5rem;
            width:100%;
            background:green;
            color:white;
            border:none;
            outline:none;
            border-radius:8px;
            font-size:25px;


        }
    </style>
</head>
<body>
    <div class="img">
    <img src="https://digifish3.com/images/logo2x.png" alt="">
    </div>
<form action="selectdata" method="get">
@csrf
    <select id="country" name="country" onChange="filterData()"></select>
    <select name="aggregator" id="aggregator" onChange="filterProduct()" style="display:none;"></select>
    <select name="product" id="product" onChange="filterOperator()" style="display:none;"></select>
    <select name="operator" id="operator" onChange="filterOption()" style="display:none;"></select>
    <button type='submit' style="display:none;" id="button">Submit</button>
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
       
        var selectOperator = document.getElementById("operator").style.display='none';

        var selectOperator = document.getElementById("operator");
        selectOperator.innerHTML='';
       
        var selectProduct = document.getElementById("product");
        selectProduct.innerHTML='';
        selectProduct.style.display='none';

     document.getElementById("button").style.display='none';

        var selectAgg = document.getElementById("aggregator").style.display='block';
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
       
        selectAgg.innerHTML='';
        uniqueAggregator.unshift("Select an Aggregator");


        uniqueAggregator.forEach(function(element) {
        var option = document.createElement("option");
        option.text = element;
        option.value = element;
        selectAgg.add(option);
    });
    }


    function filterProduct()
    {
        var selectOperator = document.getElementById("operator");
        selectOperator.innerHTML='';
        selectOperator.style.display='none';
     document.getElementById("button").style.display='none';



        var selectElement = document.getElementById("country");
        let country=selectElement.value;
        var selectAgg = document.getElementById("aggregator");
        let aggregator=selectAgg.value;
        // console.log(country,aggregator);
        var filteredData = Sql.filter(item => item.aggregator === aggregator && item.country === country );
        // console.log(filteredData);



        var uniqueProduct = [...new Set(filteredData.map(item => item.product))];
        uniqueProduct.unshift("Select an Product");

        // console.log(uniqueProduct);
        
        var selectProduct = document.getElementById("product").style.display='block';
        var selectProduct = document.getElementById("product");
        selectProduct.innerHTML='';

        uniqueProduct.forEach(function(element) {
        var option = document.createElement("option");
        option.text = element;
        option.value = element;
        selectProduct.add(option);
    });

    }

    function filterOperator()
    {
        document.getElementById("button").style.display='none';


        var selectElement = document.getElementById("country");
        let country=selectElement.value;
        var selectAgg = document.getElementById("aggregator");
        let aggregator=selectAgg.value;

        var selectProduct = document.getElementById("product");
        let product=selectProduct.value;
        console.log(country,aggregator,product);
        var filteredData = Sql.filter(item => item.aggregator === aggregator && item.country === country && item.product === product );
        console.log(filteredData);


        var uniqueOperator = [...new Set(filteredData.map(item => item.operator))];
        uniqueOperator.unshift("Select an Operator");

        console.log(uniqueOperator);
        var selectOperator = document.getElementById("operator").style.display='block';
        var selectOperator = document.getElementById("operator");

        selectOperator.innerHTML='';

        uniqueOperator.forEach(function(element) {
        var option = document.createElement("option");
        option.text = element;
        option.value = element;
        selectOperator.add(option);
    });
    }

    function filterOption(){
     document.getElementById("button").style.display='block';

    }

</script>




</body>
</html>