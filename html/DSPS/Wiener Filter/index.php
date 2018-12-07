<html>
<head>
<title>Kalman Filter</title>

</head>

<body>


<script type="text/javascript" src="math.js">



var dataConstant = Array.apply(null, {length: dataSetSize}).map(function() {
  return 4;
});
//Add noise to data
var noisyDataConstant = dataConstant.map(function(v) {
  return v + randn(0, 3);
});

//Apply kalman filter
var kalmanFilter = new KalmanFilter({R: 0.01, Q: 3});

var dataConstantKalman = noisyDataConstant.map(function(v) {
  return kalmanFilter.filter(v);
});

document.write("<p>"+dataConstantKalman+"</p>");
</script>

</body>
</html>