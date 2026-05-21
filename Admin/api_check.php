<?php

$apiUrl = "http://10.152.173.210:3001/health";

$response = @file_get_contents($apiUrl);

if ($response === FALSE) {
    die("
        <div style='
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            background:#f5f5f5;
            font-family:Arial;
        '>
            <div style='
                background:white;
                padding:30px;
                border-radius:12px;
                text-align:center;
                box-shadow:0 0 10px rgba(0,0,0,0.1);
            '>
                <h1 style='color:red;'>Server Offline</h1>
                <p>Node.js API is not running.</p>
            </div>
        </div>
    ");
}
?>