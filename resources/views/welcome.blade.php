<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome  to E-Checklist System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */
            *,::after,::before{
                box-sizing:border-box;
                border-width:0;
                border-style:solid;
                border-color:#e5e7eb
            }
            ::after,::before{
                --tw-content:''
            }
            html{
                line-height:1.5;
                -webkit-text-size-adjust:100%;
                -moz-tab-size:4;
                tab-size:4;
                font-family:Figtree, sans-serif;
                font-feature-settings:normal
            }
            body{
                margin:0;
                line-height:inherit;
                background-color: #3a5dae;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: center;
                min-height: 100vh;
            }
            .topbar {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }
            .logo {
                height: 40px;
            }
            .login-button {
                background-color: #cc8800;
                color: #fff;
                padding: 10px 20px;
                border-radius: 4px;
                text-decoration: none;
                font-weight: bold;
            }
            .login-button:hover {
                background-color: #cc8800;
            }
            .content {
                display: flex;
                justify-content: space-between;
                align-items: center;
                align-items: center;
                flex-wrap: wrap;
                gap: 25px;
                padding: 100px;
                margin-top:0px;
            }
            .content-text {
                flex: 1;
                color: white;
            }
            .content-text h1 {
                font-size: 3rem;
                font-weight: bold;
                margin-bottom: 1rem;
            }
            .content-text p {
                font-size: 1.5rem;
            }
            .content-image {
                flex: 1;
            }
            .content-image img {
                max-width: 90%;
                height: auto;
                border-radius:25px;
            }
        </style>
    </head>
    <body>
        <div class="topbar">
            <img src="{{url('/images/logo.png')}}" alt="logo" class="logo" style="height:60px;">
            <a href="{{ url('admin') }}" class="login-button">Login</a>
        </div>
        <div class="content">
            <div class="content-text">
                <h1>Welcome to E-Checklist System</h1>
                <p>"An easier way to create checklists!"</p>
            </div>
            <div class="content-image">
                <img src="{{url('/images/checklist.jpg')}}" alt="placeholder image">
            </div>
        </div>
    </body>
</html>

