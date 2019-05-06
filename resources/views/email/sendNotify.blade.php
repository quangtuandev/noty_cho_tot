<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width" />
        <style type="text/css">
            .wrapper {
                width: 60%;
                box-shadow: 0 0 2px #aaa;
                font-family: Hind;
                border: 1px solid rgba(255, 94, 58, 0.95);
            }
            .logo_header {
                height: 50px;
                padding: 5px;
                text-align: center;
                background-color: rgba(144, 99, 89, 0.95);
            }
            .logo_header a {
                color: white;
                text-decoration: unset;
            }
            .wrapper p img {
                height: 100%;
                text-align: center;
                margin-left: auto;
                margin-right: auto;
                display: block;
            }
            .logo_header a span {
                position: absolute !important;
                font-size: 20px;
            }
            .email_body {
                padding: 0 15px;
            }

            .email_body p{
                font-size: 15px;
            }
            @media(max-width:768px){
                .wrapper {
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="wrapper">
                    <div class="logo_header">
                            <a href="{{ $url }}">
                                <span>{{ $value->subject }}</span>
                            </a>
                        </div>
                    <div class="email_body">
                        <p>
                            <img  src="{{ $value->image }}"/> <br />
                            <span>Giá:  {{ $value->price_string }}</span>  <br />
                            <span>Nội dung: {{ $value->body }}</span>     <br />
                            <span>Địa chỉ:  
                                @if  (!empty($value->ward_name))
                                {{ $value->ward_name }} - 
                                @endif
                                {{ $value->area_name }} -  {{ $value->region_name }}</span><br />
                            <span>Xem chi tiết: {{ $url }}</span>     <br />
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
