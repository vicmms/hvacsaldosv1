<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .w-full{
        width: 100% !important;
        display: block;
    }
    .qr-pdf{
        display: block;
  margin-left: auto;
  margin-right: auto;
    } 
    .text-center{
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        text-transform: uppercase;
        font-family: sans-serif;
    }
    .pt-2{
        padding-top: 0.5rem;
    }
</style>
<body>
    <div class="text-center">
        <img src="https://chart.googleapis.com/chart?cht=qr&chl={{ $product->id }}&chs=200x200&chld=L|0"
                        class="qr-code img-thumbnail img-responsive mx-auto" />
    </div>
    <div class="text-center pt-2">
        <span>{{$product->name}}</span>
    </div>
</body>
</html>