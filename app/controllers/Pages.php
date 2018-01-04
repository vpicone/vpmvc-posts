<?php
class Pages extends Controller
{
  public function __construct()
  {

  }

  public function index()
  {
    if (isLoggedIn()) {
      redirect('posts');
    }

    $data = [
      'title' => 'Posts',
      'description' => 'Simple social network for sharing posts with eachother built with VPMVC PHP framework.'
    ];

    $this->view('pages/index', $data);
  }

  public function about()
  {
    $data = [
      'title' => 'About Us',
    ];

    $this->view('pages/about', $data);
  }
}