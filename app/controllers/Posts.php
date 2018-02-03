<?php
class Posts extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts,
        ];
        $this->view('posts/index', $data);
    }

    public function get()
    {
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts,
        ];
        echo json_encode($data);
    }

    public function typescript()
    {
        $posts = $this->postModel->getPosts();
        $data = [
            'posts' => $posts,
        ];
        $this->view('posts/typescript', $data);
        $this->view('posts/typescript');
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter a title.';
            }
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter a body.';
            }

            if (empty($data['title_err']) && empty($data['body_err'])) {
                //Validated
                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Post added successfully.');
                    redirect('posts');
                } else {
                    die('Failed to add post.');
                }
            } else {
                //render with error messages
                $this->view('posts/add', $data);
            }


        } else {
            $data = [
                'title' => '',
                'body' => ''
            ];
            $this->view('posts/add', $data);
        }

    }


    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sanitize first
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $post = $this->postModel->getPostById($id);
            if ($post->user_id != $_SESSION['user_id']) {
                    //If post's user isn't the current user redirect
                redirect('posts');
            }

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter a title.';
            }
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter a body.';
            }

            if (empty($data['title_err']) && empty($data['body_err'])) {
                //Validated
                if ($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post update successful.');
                    redirect('posts');
                } else {
                    die('Failed to edit post.');
                }

            } else {
                //render with error messages
                $this->view("posts/edit", $data);
            }

        } else {
            //  Fetch from existing model
            $post = $this->postModel->getPostById($id);
            if ($post->user_id != $_SESSION['user_id']) {
                    //If post's user isn't the current user redirect
                redirect('posts');
            }

            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body,
            ];

            $this->view("posts/edit", $data);
        }

    }

    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);
        $data = [
            'post' => $post,
            'user' => $user
        ];
        $this->view('posts/show', $data);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $this->postModel->getPostById($id);

            if ($post->user_id != $_SESSION['user_id'] && $_SESSION['role'] != 'admin') {
                // Only allow deletion if admin or owned post
                redirect('posts');
            }

            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post removed.');
                if (isAdmin()) {
                    redirect('admin/posts');
                } else {
                    redirect('posts');
                }
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('posts');
        }
    }

    public function load()
    {
        if (($handle = fopen("../MOCK_POSTS.csv", "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $title = filter_var($data[0], FILTER_SANITIZE_STRING);
                $body = filter_var($data[1], FILTER_SANITIZE_STRING);
                $user_id = filter_var($data[2], FILTER_SANITIZE_NUMBER_INT);

                $postData = [
                    'title' => $title,
                    'body' => $body,
                    'user_id' => $user_id
                ];

                if ($this->postModel->addPost($postData)) {
                    echo "$title registered. <br>";
                } else {
                    echo "Failure.";
                }
            }
            fclose($handle);
            redirect('/');
        } else {
            echo "Failed.";
        }
    }
}