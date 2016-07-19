<?php
if($_SERVER['REQUEST_METHOD'] != 'POST') {header("Location: index.php");}else {
    set_time_limit(PHP_INT_MAX);
    ini_set('output_buffering', 'off');
    ini_set('zlib.output_compression', false);
    while (@ob_end_flush()) ;
    ini_set('implicit_flush', true);
    ob_implicit_flush(true);
    class tweeter_post
    {
        private function cookies()
        {
            $cookie_file = substr(str_shuffle(str_repeat((string)(rand(0, PHP_INT_MAX)), 27)), 0, 5) . substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 27)), 0, 7) . substr(str_shuffle(str_repeat((string)(rand(0, PHP_INT_MAX)), 27)), 0, 5);
            return $cookie_file;
        }
        private $c = '';
        function __construct()
        {
            $this->start();
        }
        function start()
        {
            if (isset($_POST['acc']) and isset($_POST['post'])) {
                if (strlen($_POST['post']) <= 140 and strlen($_POST['post']) > 0 and strlen($_POST['acc']) > 0) {
                    $accounts = $this->da($_POST['acc']);
                    function printnow($str, $bbreak = true)
                    {
                        if (strlen($str) > 0) {
                            print "$str";
                            if ($bbreak) {
                                print "<br />";
                            }
                            @ob_flush();
                            flush();
                        }
                    }
                    foreach ($accounts as $account) {
                        if (strlen($account[0]) > 5) {
                            sleep(3);
                            printnow(htmlentities($account[0]) . $this->post($this->login(rtrim($account[0]), rtrim($account[1])), $_POST['post']));
                        }
                    }
                } elseif (!strlen($_POST['post']) > 140 or !strlen($_POST['post']) > 0) {
                    echo 'Tweet Size Must Be Greater Than 0.';
                } elseif (!strlen($_POST['acc']) > 0) {
                    echo 'accounts count Must Be Greater Than 0.';
                } else {
                    echo 'You Must Set Accounts And Tweet.';;
                }
            } else {
            }
        }
        function da($data = null)
        {
            if (isset($data)) {
                $data = explode("\n", $data);
                $acc_data = [];
                foreach ($data as $d) {
                    try {
                        @$acc_data[] = [explode(':', $d)[0], explode(':', $d)[1]];
                    } catch (Exception $e) {
                        continue;
                    }
                }
                return $acc_data;
            } else {
                return null;
            }
        }
        function login($username = null, $password = null)
        {
            if (isset($password) and isset($username)) {
                $username = urlencode($username);
                $password = urlencode($password);
                $ch = curl_init();
                $opt = '';
                $url = '';
                $s = $this->cookies() . ".txt";
                $this->c = $s;
                realpath($this->c);
                curl_setopt($ch, CURLOPT_URL, "https://mobile.twitter.com/session/new");
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_FAILONERROR, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($this->c));
                curl_setopt($ch, CURLOPT_COOKIEFILE, realpath($this->c));
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko');
                $page = curl_exec($ch);
                $doc = new DOMDocument();
                @$doc->loadHTML($page);
                foreach ($doc->getElementsByTagName('input') as $input) {
                    try {
                        if (stripos($opt, $input->getAttribute('name')) === false) {
                            if (stripos($input->getAttribute('name'), 'username') == false and stripos($input->getAttribute('name'), 'password') == false) {
                                if (strlen($input->getAttribute('name')) > 0 and strlen($input->getAttribute('value')) > 0) {
                                    $opt .= $input->getAttribute('name') . '=' . $input->getAttribute('value') . '&';
                                }
                            } elseif (stripos($input->getAttribute('name'), 'username')) {
                                $opt .= $input->getAttribute('name') . '=' . $username . '&';
                            } elseif (stripos($input->getAttribute('name'), 'password')) {
                                $opt .= $input->getAttribute('name') . '=' . $password . '&';
                            } else {
                            }
                        } else {
                        }
                    } catch (Exception $e) {
                    }
                }
                foreach ($doc->getElementsByTagName('form') as $form) {
                    $url = 'https://mobile.twitter.com' . $form->getAttribute('action');
                }
                foreach ($doc->getElementsByTagName('a') as $a) {
                    try {
                        if ($a->getAttribute('href') == '/compose/tweet') {
                            @fopen('my_cookies.txt', 'w');
                        }
                    } catch (Exception $e) {
                    }
                }
                $opt = rtrim($opt, ' &');
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $opt);
                $page = curl_exec($ch);
                @$doc->loadHTML($page);
                $find = new DOMXPath($doc);
                $nodes = $find->query("//div[@class='message']");
                if ($nodes->length > 0) {
                    foreach ($nodes as $node) {
                        return $node->textContent;
                    }
                } else {
                    $nodes = $find->query("//a[@href='/compose/tweet']");
                    if ($nodes->length > 0) {
                        return $ch;
                    } else {
                        return ' Failed';
                    }
                }
            }
            return null;
        }
        function post($ch = null, $tweet = null)
        {
            if (isset($ch) and isset($tweet)) {
                if (gettype($ch) == gettype(curl_init())) {
                    curl_setopt($ch, CURLOPT_URL, 'https://mobile.twitter.com//compose/tweet');
                    $page = curl_exec($ch);
                    $opt = '';
                    $url = '';
                    $doc = new DOMDocument();
                    @$doc->loadHTML($page);
                    foreach ($doc->getElementsByTagName('input') as $input) {
                        try {
                            if (stripos($opt, $input->getAttribute('name')) === false) {
                                if (strlen($input->getAttribute('name')) > 0 and strlen($input->getAttribute('value')) > 0) {
                                    $opt .= $input->getAttribute('name') . '=' . $input->getAttribute('value') . '&';
                                }
                            } else {
                            }
                        } catch (Exception $e) {
                        }
                    }
                    foreach ($doc->getElementsByTagName('textarea') as $input) {
                        try {
                            if (stripos($opt, $input->getAttribute('name')) === false) {
                                if (strlen($input->getAttribute('name')) > 0) {
                                    $opt .= $input->getAttribute('name') . '=' . $tweet;
                                }
                            } else {
                            }
                        } catch (Exception $e) {
                        }
                    }
                    foreach ($doc->getElementsByTagName('form') as $form) {
                        $url = 'https://mobile.twitter.com' . $form->getAttribute('action');
                    }
                    $opt = rtrim($opt, ' &');
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $opt);
                    $page = curl_exec($ch);
                    @$doc->loadHTML($page);
                    $find = new DOMXPath($doc);
                    $nodes = $find->query('//div[@class="toast toast-error"]');
                    if ($nodes->length > 0){
                        return ' Failed';
                    } else{
                        $nodes = $find->query("//a[@href='/compose/tweet']");
                        if ($nodes->length > 0) {
                            @unlink(realpath($this->c));
                            return ' Succeed';
                        } else {
                            @unlink(realpath($this->c));
                            return ' Failed';
                        }
                    }
                } else {
                    @unlink(realpath($this->c));
                    return ' Failed';
                }
            } else {
                @unlink(realpath($this->c));
                return " Failed";
            }
        }
    }
    $poster = new tweeter_post();
}
?>
