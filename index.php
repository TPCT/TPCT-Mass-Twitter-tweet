<?php
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>';
$data_main = "<html xmlns=\"http://www.w3.org/1999/html\"><head><title>TPCT Twitter Mass Poster</title><link rel=\"icon\" type=\"image/png\" href=\"https://cdn0.iconfinder.com/data/icons/large-glossy-icons/512/Spy.png\"/><style>
    *{
        outline: none;
    }
    pre{
    max-height: 100px;
    max-width: 400px;
    overflow: auto;
    }
    form{
    }
    textarea{resize: none;}
    body{
        overflow: hidden;
        text-align: center;
        background-size: cover;
        background: url(\"http://fastpayads.s3.amazonaws.com/blog/wp-content/uploads/2016/02/Hackers.jpg\");
    }
    #acc{
        background-color: black;
        color: lawngreen;
        border: 1px greenyellow solid;
        border-radius: 5px;
        overflow: auto;
        min-width: 400px;
        max-width: 400px;
        min-height: 80px;
        max-height: 80px;
    }
    #tweet{
        background-color: black;
        color: lawngreen;
        border: 1px greenyellow solid;
        border-radius: 5px;
        overflow: auto;
        min-width: 400px;
        max-width: 400px;
        min-height: 50px;
        max-height: 50px;
    }
    #submit{
        background-color: black;
        color: lawngreen;
        border: 1px greenyellow solid;
        border-radius: 5px;
    }
    fieldset{
        position: absolute;
        top: 50%;
        margin-top: -50px;
        color: lawngreen;
        border: 1px greenyellow solid;
        border-radius: 5px;
        text-align: center;
        background: black;
    }
    hr{
        line-height: 7px;
        display: block;
        color:transparent;
        border: none;
    }
    legend{
        text-align: center;
        margin-left: 32%;
    }
</style></head>
<body>
<fieldset>
    <legend>
        Twitter Mass Tweet Form
    </legend>
    <center><label>accounts list <br/><textarea name=\"acc\" id=\"acc\"></textarea></label></center><hr/>
        <center><label>Tweet<br/><textarea name=\"post\" id=\"tweet\" onkeyup=\"checker();\"></textarea><hr></label><label id=\"count\"></label></center><hr/>
        <input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Post\" onclick=\"post();\"/><hr/>
        <label id='status'></label>
</fieldset>
       <script>
    function post(){
        document.getElementById(\"status\").innerHTML = 'Initializing';
            var f = (function () {
                var data = document.getElementById(\"acc\").value.split('\\n');
                var xhr = [];
                for (i = 0; i < data.length; i++) {
                    (function (i) {
                        var ln = document.getElementById(\"tweet\").value;
                        var url = \"nom.php\";
                        xhr[i] = new XMLHttpRequest();
                        var vars = \"acc=\" + data[i] + \"&post=\" + ln;
                        xhr[i].open(\"POST\", url, true);
                        xhr[i].setRequestHeader(\"Content-type\", \"application/x-www-form-urlencoded\");
                        xhr[i].onreadystatechange = function () {
                            if (xhr[i].readyState == 4 && xhr[i].status == 200) {
                                var return_data = xhr[i].responseText;
                                if (document.getElementById(\"status\").innerHTML == 'Initializing') {
                                    document.getElementById(\"status\").innerHTML = '';
                                    document.getElementById(\"status\").innerHTML += return_data + \"\\n\";
                                }
                                else {
                                    document.getElementById(\"status\").innerHTML += return_data + \"\\n\";
                                }
                            }
                        };
                        xhr[i].send(vars);
                    })(i);
                }
            })();
    }
    </script>
       <script>
    function checker(e){
        var len = 140,
        arealen = document.getElementById('tweet').value.length;
        document.getElementById('tweet').setAttribute('maxlength',140);
        if (Number(arealen) < 141){
            document.getElementById('count').innerHTML = len - Number(arealen);
        }
    }
    function center() {
        var f = document.getElementsByTagName('fieldset')[0],
                width = f.offsetWidth,
                dwidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
                height = f.offsetHeight,
                dheight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        if (f.style.left != Math.floor((dwidth-width)/2)) {
            f.style.left = Math.floor((dwidth - width) / 2);
            if (f.style.top != Math.floor((dheight - height) / 2)) {
                f.style.top = Math.floor((dheight - height) / 2);
                setTimeout(\"center()\", 200);
            }
            else {
                setTimeout(\"center()\", 200);
            }
        }
        else{
            if (f.style.top != Math.floor((dheight-height)/2)){
                f.style.top = Math.floor((dheight-height)/2);
                setTimeout(\"center()\", 200);}
            else{
                setTimeout(\"center()\", 200);
            }
            }
        }
    center();
</script>
</body>
</html>";
echo $data_main;

?>
