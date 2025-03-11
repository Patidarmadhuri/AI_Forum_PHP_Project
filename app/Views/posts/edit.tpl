<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - AI Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $basePath; ?>/">AI Forum</a>
            <div class="d-flex">
                <a href="<?php echo $basePath; ?>/" class="btn btn-primary me-2">Back to Home</a>
                <a href="<?php echo $basePath; ?>/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Edit Post</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo $basePath; ?>/post/edit/<?php echo $post['id']; ?>" method="POST">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" 
                       value="<?= htmlspecialchars($post['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?= 
                    htmlspecialchars($post['content']) 
                ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="<?php echo $basePath; ?>/post/<?= $post['id'] ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>