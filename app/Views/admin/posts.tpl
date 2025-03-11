<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>User ID</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?php echo $post['id']; ?></td>
                <td><?php echo htmlspecialchars($post['title']); ?></td>
                <td><?php echo $post['user_id']; ?></td>
                <td><?php echo (new DateTime($post['created_at']))->format('F j, Y, g:i A'); ?></td>
                <td>
                    <a href="<?php echo $basePath; ?>/admin/posts/delete/<?php echo $post['id']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>