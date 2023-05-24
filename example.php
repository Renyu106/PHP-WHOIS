<?php
require_once "WHOIS.php";
$WHOIS = new WHOIS("WHOIS_SERVERS.json");

if(isset($_POST['domain'])){
    $HEY_WAKE_UP = true;
    $CALL_WHOIS = $WHOIS->WHOIS($_POST['domain']);
    if($CALL_WHOIS['STATUS'] !== "OK"){
        $DISPLAY = $CALL_WHOIS['MSG'];
    }else{
        $DISPLAY = str_replace("\n", "<br>", $CALL_WHOIS['RESULT']);
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex,nofollow">
    <title>WHOIS EXAMPLE</title>
    <link rel="stylesheet" as="style" crossorigin href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.6/dist/web/static/pretendard.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.18/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.18/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.18/dist/js/uikit-icons.min.js"></script>
    <style>
        *, html, body,h1,pre{
            font-family: "Pretendard Variable", Pretendard, -apple-system, BlinkMacSystemFont, system-ui, Roboto, "Helvetica Neue", "Segoe UI", "Apple SD Gothic Neo", "Noto Sans KR", "Malgun Gothic", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", sans-serif;
        }
    </style>
</head>

<div class="uk-container uk-container-small" style="margin-top: 30px">
    <h1>WHOIS</h1>
    <form method="post" action>
        <div class="uk-margin">
            <input class="uk-input" type="text" placeholder="DOMAIN" aria-label="Input" autocomplete="off" name="domain" value="<?=$_POST['domain']?>">
        </div>
        <button class="uk-button uk-button-primary" type="submit">WHO?</button>
    </form>
    <?php if($HEY_WAKE_UP){?>
    <div class="uk-margin">
        <pre><?=$DISPLAY?></pre>
    </div>
    <?php }?>
</div>
