### Worflow for adding feature/section.

    1. Create a controller ->

```php
class Posts extends Controller
{
    public function index()
    {
        $data = [];
        $this->view('posts/index', $data);
    }
}
```

    2. Create the view ->

```html
<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="row">
    <div class="col-md-6">
        <h1>Posts</h1>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary pull-right">
            <i class="fa fa-pencil"></i> Add Post
        </a>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
```

### Authenticated Routes

```php
class Posts extends Controller
{

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
        }
    }
    ...
```
