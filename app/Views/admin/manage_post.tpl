public function managePosts() {
    $this->requireAdmin();
    $posts = (new Post())->getAllPosts();
    $this->view('admin/manage_posts', ['posts' => $posts]);
}