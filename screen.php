<html>
<head>
<script src="html2canvas.js"></script>
<script>
	function bodyShot() {  html2canvas(document.body)  .then( function (canvas) {  drawImg(canvas.toDataURL('image/png'));  saveAs(canvas.toDataURL(), 'file-name.png'); }).catch(function (err) { console.log(err); }); } function partShot() { html2canvas(document.getElementById("container")).then(function (canvas) { drawImg(canvas.toDataURL('image/jpeg')); saveAs(canvas.toDataURL(), 'file-name.jpg'); }).catch(function (err) { console.log(err); }); } function drawImg(imgData) { console.log(imgData); return new Promise(function reslove() {  var canvas = document.getElementById('canvas'); var ctx = canvas.getContext('2d'); ctx.clearRect(0, 0, canvas.width, canvas.height); var imageObj = new Image(); imageObj.onload = function () { ctx.drawImage(imageObj, 10, 10);  }; imageObj.src = imgData;  }, function reject() { }); } function saveAs(uri, filename) { var link = document.createElement('a'); if (typeof link.download === 'string') { link.href = uri; link.download = filename; document.body.appendChild(link); link.click(); document.body.removeChild(link); } else { window.open(uri); } }

</script>
</head>
<body>
	<!-- 전체 부분--> <button onclick=bodyShot()>bodyShot</button> <!-- 일부분 부분--> <button onclick=partShot()>partShot</button> <div class="container" id='container'> <!-- 로컬에서 불러온 파일 --> <div style="position:absolute; top:-300px; left:0px;">
	<iframe src="https://finance.naver.com/item/main.nhn?code=024110" width="680" height="400"scrolling="no" frameborder="0" />
</div> <!-- 웹에서 불러온 파일 --> <img src="https://www.w3schools.com/html/img_girl.jpg"> <!-- <img src="https://source.unsplash.com/user/erondu/400x400"> --> </div> <!-- 결과화면을 그려줄 canvas --> <canvas id="canvas" width="900" height="600" style="border:1px solid #d3d3d3;"></canvas>

</body>
</html>