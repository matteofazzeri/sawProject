<!doctype html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    foreach ($css as $key => $link) {
        $link = "src/style/" . $link . ".css";
        echo "<link rel='stylesheet' href=$link>";
    }
    ?>
    <title><?php echo $title ?? 'Document' ?></title>
    <?php
    foreach ($js as $key => $link) {
        $link = "src/js/" . $link . ".js";
        echo '<script src=' . $link . '></script>';
    }
    ?>
</head>

<body>