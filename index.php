<?php
$strRtx = file_get_contents("rtx.json");
$arrRtx = json_decode($strRtx);
$objVideo = dir("video");
while (false !== ($filename = $objVideo->read())) {
    if ($filename != '.' && $filename != '..' && $filename != 'index.php' && $filename != '.htaccess') {
        $arrRtxVideo[] = str_replace(".mp4", "", $filename);
    }
}
$objVideo->close();
function getRtx($rtx)
{
    global $arrRtx;
    $i = 0;
    foreach ($arrRtx as $key => $value) {
        if ($value->rtx == $rtx) {
            $value->index = $i;
            return $value;
            break;
        }
        $i++;
    }
}

function getJump($current)
{
    global $arrRtxVideo;
    $arrJump["current"] = getRtx($current);
    $i = 0;
    foreach ($arrRtxVideo as $value) {
        if ($current == $value) {
            break;
        }
        $i++;
    }
    if ($i > 0) {
        $arrJump["previous"] = getRtx($arrRtxVideo[$i - 1]);
    }
    if ($i + 1 < count($arrRtxVideo)) {
        $arrJump["next"] = getRtx($arrRtxVideo[$i + 1]);
    }
    return $arrJump;
}


if (isset($_GET["rtx"])) {
    $currentRTx = getRtx($_GET["rtx"]);
    $arrJump = getJump($currentRTx->rtx);
}

?>
<!DOCTYPE HTML>
<html lang="en-US" dir="ltr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content=" initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>Dreamer ecd</title>
    <meta name="apple-mobile-web-app-capable" content="no"/>
    <link rel="stylesheet" href="meeting.css"/>
</head>
<body>
<div id="wifi" class="mod-wifi">检测到非WIFI环境,请留意流量</div>
<?php if (isset($currentRTx)) {

    ?>
    <video id="movie" class="mod-movie" preload controls autoplay poster="img/banner.png" width="100%">
        <source src="video/<?php echo $currentRTx->rtx; ?>.mp4" type="video/mp4"/>
        Your browser doesn't support the &lt;video&gt; tag.
    </video>

    <div class="mod-control">

        <?php
        if (array_key_exists("next", $arrJump)) {
            ?>
            <a href="?rtx=<?php echo $arrJump["next"]->rtx ?>"
               class="mod-control__jump mod-control__next">下一个视频</a>
        <?php
        }
        if (array_key_exists("previous", $arrJump)) {
            ?>
            <a href="?rtx=<?php echo $arrJump["previous"]->rtx ?>"
               class="mod-control__jump mod-control__previous">上一个视频</a>
        <?php
        }
        ?>
        <a href="#<?php echo $currentRTx->rtx ?>">
            <img
                class="mod-control__img"
                src="avatar/<?php echo $currentRTx->rtx; ?>.jpg"
                width="36"/>

            <div class="mod-control__name">
                <?php echo ucfirst($currentRTx->rtx); ?>
            </div>
            的新年愿望
        </a>

    </div>

<?php
} else {
    ?>
    <img src="img/banner.png" width="100%"/>
<?php
}
?>

<?php
$arrIndex = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p","q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
foreach ($arrIndex as $index) {
    echo '<a href="#top" id="'.$index.'" class="mod-list__index">' . strtoupper($index) . '<span class="mod-index__hint">返回顶部</span></a>';
    foreach ($arrRtxVideo as $value) {
        if (substr($value, 0, 1) == $index) {
            $objPeople = getRtx($value);
            echo '<a href="?rtx='.$value.'" id="'.$value.'" class="mod-list__item"><img src="avatar/'.$objPeople->rtx.'.jpg" width="36" class="mod-list__avatar" />' . ucfirst($objPeople->rtx) .' '.  $objPeople->name.' </a>';
        }
    }
}

?>

<script type="text/javascript">
    <?php echo "var arrIndex=".json_encode($arrIndex).";"?>
</script>
<script src="meeting.js"></script>
</body>
</html>