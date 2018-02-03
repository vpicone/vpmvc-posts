<?php require APPROOT . '/views/inc/header.php'; ?>
  <h1>Posts</h1>
  <?php flash('post_message'); ?>
  <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">title</th>
          <th scope="col">created</th>
          <th scope="col">author</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data['posts'] as $post) : ?>
          <tr>
            <th scope="row"><?php echo $post->postId ?></th>
            <th scope="row"><?php echo $post->title ?></th>
            <td scope="row"><?php echo $post->created_at ?></td>
            <td scope="row"><?php echo $post->name ?></td>
            <td scope="row">
              <button
                class = 'btn btn-outline-danger'
                type="button"
                data-toggle="modal"
                data-target="#confirmDelete"
                data-id=<?php echo $post->postId ?>
              >
                <i class="fa fa-trash-o"></i>
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php require APPROOT . '/views/inc/confirmDelete.php'; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
