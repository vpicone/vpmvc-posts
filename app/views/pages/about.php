<?php require APPROOT . '/views/inc/header.php'; ?>
  <div style="padding: 3rem 1.5rem; text-align: center; max-width: 540px; margin: auto;">
    <h1><?php echo $data['title']; ?></h1>
    <p>This application was created using the VPMVC framework.
    You can check out the <a href="https://github.com/vpicone/vpmvc">github</a> readme for details
    on how the framework works.</p>
    <p>Version: <strong><? echo APPVERSION; ?></strong></p>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>