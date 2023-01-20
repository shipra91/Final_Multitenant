<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demo Email</title>
    <style>
        .buttonClass{
            align-items: center;
            background-clip: padding-box;
            background-color: #fa6400;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            box-shadow: rgb(0 0 0 / 2%) 0 1px 3px 0;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            display: inline-flex;
            font-family: system-ui,-apple-system,system-ui,"Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 16px;
            font-weight: 600;
            justify-content: center;
            line-height: 1.25;
            margin: 0;
            min-height: 3rem;
            padding : 15px 30px;
            position: relative;
            text-decoration: none;
            transition: all 250ms;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: baseline;
            width: auto;
        }
    </style>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>
    <div>
        <h4>Please click on the given link given below:</h4>
        <a class="buttonClass" type="button" href="{{ $mailData['body'] }}">Acivate Email</a>
    </div>
</body>
</html>