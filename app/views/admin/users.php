<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">name</th>
          <th scope="col">email</th>
          <th scope="col">role</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data['users'] as $user) : ?>
          <tr>
            <th scope="row"><?php echo $user->id ?></th>
            <td scope="row"><?php echo $user->name ?></td>
            <td scope="row"><?php echo $user->email ?></td>
            <td scope="row"><?php echo $user->role ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
