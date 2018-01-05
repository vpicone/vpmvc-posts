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
        $posts = $this->postModel->getPosts();
        $users = $this->userModel->getUsers();

        $data = [
            'posts' => $posts,
            'users' => $users
        ];
        $this->view('admin/index', $data);
    }
}