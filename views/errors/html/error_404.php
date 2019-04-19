<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>404页面</title>

<style>
body, html{
  margin: 0 auto;
  padding: 0;
  font-weight: 800;
}

body{
  background: #FFF3EA;
  font-family: cursive;
}

svg {
    display: block;
    font: 10.5em 'Monoton';
    width: 960px;
    height: 300px;
    margin: 0 auto;
}

.content{
  text-align: center;
  margin-top:150px;
}

h1{
  text-align: center;
  font: 2em 'Roboto', sans-serif;
  font-weight: 900;
  color: #2f8f7f;
  opacity: .6;
}

a{
   display: inline-block;
   text-transform: uppercase;
   font: 1em 'Roboto';
   font-weight: 300;
   border: 1px solid #2f8f7f;
   border-radius: 4px;
   color: #2f8f7f;
   margin-top: 10%;
   padding: 8px 14px;
   text-decoration: none;
   opacity: .6;
}

.text {
    fill: none;
    stroke: white;
    stroke-dasharray: 8% 29%;
    stroke-width: 5px;
    stroke-dashoffset: 1%;
    animation: stroke-offset 5.5s infinite linear;
}

.text:nth-child(1){
	stroke: #F5C996;
	animation-delay: -1;
}

.text:nth-child(2){
	stroke: #F58010;
	animation-delay: -2s;
}

.text:nth-child(3){
	stroke: #2f8f7f;
	animation-delay: -3s;
}

.text:nth-child(4){
	stroke: #2f8f7f;
	animation-delay: -4s;
}

.text:nth-child(5){
	stroke: #f34533;
	animation-delay: -5s;
}

@keyframes stroke-offset{
	100% {
    stroke-dashoffset: -35%;
  }
}
</style>
</head>
<body>


<div class="content">
    <h1>国家战略 国家公益 人人敬老 人人有责</h1>
    <a href="#">系统正在努力完善中...</a>
</div>
<!--
<?php echo $heading; echo $message; debug();?>
-->
</body>
</html>
