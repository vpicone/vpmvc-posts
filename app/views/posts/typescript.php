<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="<?php echo CSS_BUILD; ?>">
  <title><?php echo SITENAME; ?></title>
</head>
    <body>
        <div id="root"></div>
        <?php
            // $css = scandir('css/react');
            echo CSS_BUILD;
            // explode(".", scandir('css/react')[2])[1];
            // echo ($cssBuild[1]);
        ?>
        <script>let data = <?php echo $data ?>; console.log(data);</script>
        <script src="<?php echo JS_BUILD ?>"></script>
    </body>
</html>
