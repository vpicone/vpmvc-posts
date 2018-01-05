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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'id' => $id,
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
                    redirect('/');
                } else {
                    die('Failed to edit post.');
                }
            } else {
                //render with error messages
                $this->view('posts/edit', $data);
            }


        } else {
            //  Fetch frome existing model
            $post = $this->postModel->getPostById($id);
            if ($post->user_id != $_SESSION['user_id']) {
                    //If post's user isn't the current user redirect
                redirect('posts');
            }

            $data = [
                'title' => $post->title,
                'body' => $post->body,
            ];

            $this->view('posts/edit', $data);
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
            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post removed.');
                redirect('posts');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('posts');
        }
    }
}