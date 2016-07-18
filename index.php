<?php
class tweeter_post{
    private function cookies(){
        $cookie_file = substr(str_shuffle(str_repeat((string)(rand(0, PHP_INT_MAX)), 27)),0, 5).substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 27)), 0, 7). substr(str_shuffle(str_repeat((string)(rand(0, PHP_INT_MAX)), 27)),0, 5);
        return $cookie_file;
    }
    private $c = '';
    private $data_main = "<html xmlns=\"http://www.w3.org/1999/html\"><head><title>TPCT Twitter Mass Poster</title><link rel=\"icon\" type=\"image/png\" href=\"https://cdn0.iconfinder.com/data/icons/large-glossy-icons/512/Spy.png\"/><style>
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
        Shorten Url Form
    </legend>
    <form method=\"post\" action=\"\">
        <center><label>accounts list <br/><textarea name=\"acc\" id=\"acc\"></textarea></label></center><hr/>
        <center><label>Tweet<br/><textarea name=\"post\" id=\"tweet\" onkeyup=\"checker();\"></textarea><hr></label><label id=\"count\"></label></center><hr/>
        <input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Post\"/>
    </form>
</fieldset>
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
    function __construct()
    {
        if (!is_dir('cookies')){
            mkdir('cookies');
        }
        print($this->data_main);
        $this->start();
    }
    function start(){
        if (isset($_POST['acc']) and isset($_POST['post'])){
            if (strlen($_POST['post']) <= 140 and strlen($_POST['post']) > 0 and strlen($_POST['acc']) > 0){
                $accounts = $this->da($_POST['acc']);
                function printnow($str, $bbreak=true){
                    if (strlen($str) > 0){
                        print "$str";
                        if($bbreak){
                            print "<br />";
                        }
                        ob_flush(); flush();
                    }
                }
                printnow('<script>
                     var x = document.createElement("pre");
                     x.id = "result";
                     document.getElementsByTagName("fieldset")[0].appendChild(x);
                    </script>');
                foreach($accounts as $account){
                    if (strlen($account[0]) > 5){
                        printnow('<script>document.getElementById("result").innerHTML += "[+] '.htmlentities($account[0]).$this->post($this->login($account[0], $account[1]), $_POST['post']).'".replace(/(\r\n|\n|\r)/gm,"")+"\n";</script>');
                    }
                }
            }
            elseif (!strlen($_POST['post']) <= 140 or !strlen($_POST['post']) > 0){
                echo '<script>
                     var x = document.createElement("p");
                     x.innerHTML = "Tweet Size Must Be Greater Than 0."
                     document.getElementsByTagName("fieldset")[0].appendChild(x);
                    </script>';
            }
            elseif(!strlen($_POST['acc']) <= 140 or !strlen($_POST['acc']) > 0){
                echo '<script>
                     var x = document.createElement("p");
                     x.innerHTML = "accounts count Must Be Greater Than 0."
                     document.getElementsByTagName("fieldset")[0].appendChild(x);
                    </script>';
            }
            else{
                echo '<script>
                     var x = document.createElement("p");
                     x.innerHTML = "You Must Set Accounts And Tweet."
                     document.getElementsByTagName("fieldset")[0].appendChild(x);
                    </script>';;
            }
        }
        else{}
    }
    function da($data = null){
        if (isset($data)){
            $data = explode("\n", $data);
            $acc_data = [];
            foreach ($data as $d){
                try{
                    @$acc_data[] = [explode(':', $d)[0], explode(':', $d)[1]];
                }
                catch (Exception $e){
                    continue;
                }
            }
            return $acc_data;
        }
        else{
            return null;
        }
    }
    function login($username = null, $password = null){
        if (isset($password) and isset($username)){
            $username = urlencode($username);
            $password = urlencode($password);
            $ch = curl_init();
            $opt = '';
            $url = '';
            $s = 'cookies/'.$this->cookies().".txt";
            fopen($s, 'w+');
            $this->c = realpath($s);
            curl_setopt($ch, CURLOPT_URL, "https://mobile.twitter.com/session/new");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($this->c));
            curl_setopt($ch, CURLOPT_COOKIEFILE, realpath($this->c));
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko');
            $page = curl_exec($ch);
            $doc = new DOMDocument();
            $doc->loadHTML($page);
            foreach ($doc->getElementsByTagName('input') as $input){
                try {
                    if (stripos($opt, $input->getAttribute('name')) === false)
                    {
                        if (stripos($input->getAttribute('name'), 'username') == false and stripos($input->getAttribute('name'), 'password') == false){
                            if (strlen($input->getAttribute('name')) > 0 and strlen($input->getAttribute('value')) > 0){
                                $opt.= $input->getAttribute('name').'='.$input->getAttribute('value').'&';
                            }
                        }
                        elseif (stripos($input->getAttribute('name'), 'username')){
                            $opt.= $input->getAttribute('name').'='.$username.'&';
                        }
                        elseif (stripos($input->getAttribute('name'), 'password')){
                            $opt.= $input->getAttribute('name').'='.$password.'&';
                        }
                        else{
                        }
                    }
                    else{
                    }
                }
                catch (Exception $e){

                }
            }
            foreach($doc->getElementsByTagName('form') as $form){
                $url = 'https://mobile.twitter.com'.$form->getAttribute('action');
            }
            foreach ($doc->getElementsByTagName('a') as $a){
                try{
                    if ($a->getAttribute('href') == '/compose/tweet'){
                        @fopen('my_cookies.txt', 'w');
                    }
                }catch (Exception $e){

                }

            }
            $opt = rtrim($opt, ' &');
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $opt);
            $page = curl_exec($ch);
            @$doc->loadHTML($page);
            $find = new DOMXPath($doc);
            $nodes = $find->query("//div[@class='message']");
            if ($nodes->length > 0){
                foreach($nodes as $node){
                    return $node->textContent;
                }
            }
            else{
                $nodes = $find->query("//a[@href='/compose/tweet']");
                if ($nodes->length > 0){
                    return $ch;
                }
                else{
                    return ' Failed';
                }
            }
        }
        return null;
    }
    function post ($ch = null, $tweet = null){
        if (isset($ch) and isset($tweet)){
            if (gettype($ch) == gettype(curl_init())){
                curl_setopt($ch, CURLOPT_URL, 'https://mobile.twitter.com//compose/tweet');
                $page = curl_exec($ch);
                $opt = '';
                $url = '';
                $doc = new DOMDocument();
                $doc->loadHTML($page);
                foreach ($doc->getElementsByTagName('input') as $input){
                    try {
                        if (stripos($opt, $input->getAttribute('name')) === false)
                        {
                            if (strlen($input->getAttribute('name')) > 0 and strlen($input->getAttribute('value')) > 0) {
                                $opt .= $input->getAttribute('name') . '=' . $input->getAttribute('value') . '&';
                            }
                        }
                        else{
                        }
                    }
                    catch (Exception $e){

                    }
                }
                foreach ($doc->getElementsByTagName('textarea') as $input){
                    try {
                        if (stripos($opt, $input->getAttribute('name')) === false)
                        {
                            if (strlen($input->getAttribute('name')) > 0) {
                                $opt .= $input->getAttribute('name') . '=' .$tweet;
                            }
                        }
                        else{
                        }
                    }
                    catch (Exception $e){

                    }
                }
                foreach($doc->getElementsByTagName('form') as $form){
                    $url = 'https://mobile.twitter.com'.$form->getAttribute('action');
                }
                $opt = rtrim($opt, ' &');
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $opt);
                $page = curl_exec($ch);
                @$doc->loadHTML($page);
                $find = new DOMXPath($doc);
                $nodes = $find->query("//a[@href='/compose/tweet']");
                if ($nodes->length > 0){
                    return ' Succeed';
                }
                else{
                    return ' Failed';
                }
            }
            else{
                return ' Failed';
            }
        }
        else{
            return " Failed";
        }
        return false;
    }
}
$poster = new tweeter_post();
?>
