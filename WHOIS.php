<?php
class WHOIS{

    function __construct($WHOIS_SERVER_LIST = "whois_servers.json"){
        $this->WHOIS_SERVER_LIST = $WHOIS_SERVER_LIST;
    }

    private function GET_WHOIS_SERVER($DOMAIN){
        $RETURN = array();
        if(!$this->VALIDATION_DOMAIN($DOMAIN)){
            $RETURN['STATUS'] = "ERR";
            $RETURN['MSG'] = "DOMAIN NOT VALID";
        }else{
            $DOMAIN_PARTS = explode(".", $DOMAIN);
            $TLD = strtolower(array_pop($DOMAIN_PARTS));
            $WHOIS_SERVERS = json_decode(file_get_contents($this->WHOIS_SERVER_LIST), true);
            $WHOIS_SERVER = $WHOIS_SERVERS[$TLD];
            if($WHOIS_SERVER){
                $RETURN['STATUS'] = "OK";
                $RETURN['WHOIS_SERVER'] = $WHOIS_SERVER;
                $RETURN['DOMAIN'] = $DOMAIN;
                $RETURN['TLD'] = $TLD;
            }else{
                $RETURN['STATUS'] = "ERR";
                $RETURN['MSG'] = "TLD not found";
            }
        }
        return $RETURN;
    }

    private function SEND_SOCKET($TARGET_SERVER, $PORT=43, $TIMEOUT=10, $DATA){
        $SEND_SOCKET = @fsockopen($TARGET_SERVER, $PORT, $ERR_CODE, $ERR_MSG, $TIMEOUT) or die ("SOCKET ERROR : ".$ERR_MSG);
        fputs($SEND_SOCKET, $DATA . "\r\n");
        $SOCKET_RESPONSE = stream_get_contents($SEND_SOCKET);
        fclose($SEND_SOCKET);
        return $SOCKET_RESPONSE;
    }

    private function EXTRACT_TEXT($CONTENT, $START_STRING, $SEND_STRING, $REPLACE=array()){
        $PROCESS = explode($START_STRING,$CONTENT);
        $PROCESS = $PROCESS[1];
        $PROCESS = explode($SEND_STRING,$PROCESS);
        $PROCESS = $PROCESS[0];
        $PROCESS = trim($PROCESS);
        foreach ($REPLACE as $KEY => $VALUE) {
            $PROCESS = str_replace($KEY, $VALUE, $PROCESS);
        }
        return $PROCESS;
    }

    private function VALIDATION_DOMAIN($DOMAIN) {
        if(!preg_match("/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i", $DOMAIN)) {
            return false;
        }
        return true;
    }

    public function FIND_WHOIS_SERVER($TLD="kr"){
        $WHOIS_SERVERS = json_decode(file_get_contents($this->WHOIS_SERVER_LIST), true);
        if($WHOIS_SERVERS[$TLD]) {
            $RETURN['STATUS'] = "OK";
            $RETURN['MSG'] = "WHOIS SERVER FOUND";
            $RETURN['WHOIS_SERVER'] = $WHOIS_SERVERS[$TLD];
        }else{
            $CURL = curl_init();
            curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($CURL, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($CURL, CURLOPT_URL, "https://www.iana.org/domains/root/db/$TLD.html");
            curl_setopt($CURL, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($CURL, CURLOPT_HTTPHEADER, array(
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4143.7 Safari/537.36",
            ));
            $RESULT = curl_exec($CURL);
            $RETURN = array();
            if (curl_errno($CURL)) {
                $RETURN['STATUS'] = "ERR";
                $RETURN['MSG'] = 'Error:' . curl_error($CURL);
            }else{
                $FIND_WHOIS_SERVER = $this->EXTRACT_TEXT($RESULT, "<b>WHOIS Server:</b>", "</p>");
                if(empty($FIND_WHOIS_SERVER)){
                    $RETURN['STATUS'] = "ERR";
                    $RETURN['MSG'] = "WHOIS SERVER NOT FOUND";
                }else{
                    $RETURN['STATUS'] = "OK";
                    $RETURN['MSG'] = "WHOIS SERVER FOUND";
                    $RETURN['WHOIS_SERVER'] = $FIND_WHOIS_SERVER;
                    $WHOIS_SERVERS[$TLD] = $FIND_WHOIS_SERVER;
                    file_put_contents($this->WHOIS_SERVER_LIST, json_encode($WHOIS_SERVERS, JSON_PRETTY_PRINT));
                }
            }
        }
        return $RETURN;
    }

    public function WHOIS($DOMAIN){
        $WHOIS_SERVER = $this->GET_WHOIS_SERVER($DOMAIN);
        $RETURN = array();
        if($WHOIS_SERVER['STATUS'] !== "OK"){
            $RETURN['STATUS'] = "ERR";
            $RETURN['MSG'] = "WHOIS SERVER NOT FOUND : ".$WHOIS_SERVER['MSG'];
        }else{
            $RETURN['STATUS'] = "OK";
            $RETURN['MSG'] = "WHOIS SERVER FOUND";
            $RETURN['DOMAIN'] = $WHOIS_SERVER['DOMAIN'];
            $RETURN['WHOIS_SERVER'] = $WHOIS_SERVER['WHOIS_SERVER'];
            $RETURN['RESULT'] = $this->SEND_SOCKET($WHOIS_SERVER['WHOIS_SERVER'], 43, 10, $DOMAIN);
        }
        return $RETURN;
    }

    public function IP_INFO($IP, $WHOIS_SERVER="ALL"){ // ALL or INPUT ADDRESS
        $IP_WHOIS_SERVERS = array(
            "whois.apnic.net",
            "whois.ripe.net",
            "whois.afrinic.net",
            "whois.lacnic.net",
            "whois.arin.net",
        );
        $WHOIS_SERVER = ($WHOIS_SERVER === "ALL") ? $IP_WHOIS_SERVERS : $WHOIS_SERVER;
        $RETURN = array();
        $RETURN['STATUS'] = "OK";
        $RETURN['IP'] = $IP;
        $RETURN['WHOIS_SERVER'] = $WHOIS_SERVER;
        foreach ($WHOIS_SERVER as $WHOIS_SERVER_ADDR){
            $RETURN['RESULT'][$WHOIS_SERVER_ADDR] = $this->SEND_SOCKET($WHOIS_SERVER_ADDR, 43, 10, $IP);
        }
        return $RETURN;
    }

}
