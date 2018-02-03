<?php
class Admin extends Controller
{

    public function __construct()
    {
        if (!isAdmin()) {
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $this->view('admin/index');
    }

    public function users()
    {
        $users = $this->userModel->getUsers();

        $data = [
            'users' => $users
        ];
        $this->view('admin/users', $data);
    }

    public function posts()
    {
        $posts = $this->postModel->getPosts();

        $data = [
            'posts' => $posts,
        ];
        $this->view('admin/posts', $data);
    }





    // public function deletePost($id)
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         if (!isAdmin()) {
    //             // Check for admin role
    //             redirect('posts');
    //         }

    //         if ($this->postModel->deletePost($id)) {
    //             flash('post_message', 'Post removed.');
    //             redirect('posts');
    //         } else {
    //             die('Something went wrong');
    //         }
    //     } else {
    //         redirect('posts');
    //     }
    // }
}