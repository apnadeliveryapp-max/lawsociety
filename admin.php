<?php
include 'connection.php'; // Ensure this file has your $conn details

$message = "";

// Handle New Post Submission
if (isset($_POST['submit_post'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "INSERT INTO posts (title, image_url, category, author, status_badge) 
            VALUES ('$title', '$image_url', '$category', '$author', '$status')";
    
    if ($conn->query($sql)) {
        $message = "<div class='alert success'>New update posted successfully!</div>";
    }
}

// Handle Banner Update
if (isset($_POST['update_banner'])) {
    $pos = $_POST['position'];
    $url = mysqli_real_escape_string($conn, $_POST['banner_url']);
    
    // Check if position exists, update if yes, insert if no
    $sql = "INSERT INTO banners (position, image_url) VALUES ('$pos', '$url') 
            ON DUPLICATE KEY UPDATE image_url='$url'";
    
    if ($conn->query($sql)) {
        $message = "<div class='alert success'>Banner updated successfully!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LawSociety - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #ff5722; --dark: #333; }
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .admin-container { max-width: 1000px; margin: auto; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: var(--dark); border-bottom: 2px solid var(--primary); padding-bottom: 10px; }
        label { display: block; margin-top: 15px; font-weight: bold; color: #555; }
        input, select, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { background: var(--primary); color: white; border: none; padding: 12px 20px; margin-top: 20px; border-radius: 5px; cursor: pointer; width: 100%; font-size: 16px; transition: 0.3s; }
        button:hover { background: #e64a19; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

<div class="admin-container">
    <h1 style="text-align:center;"><i class="fa-solid fa-gauge"></i> LawSociety Admin Panel</h1>
    <?php echo $message; ?>

    <div class="grid">
        <div class="card">
            <h2><i class="fa-solid fa-file-pen"></i> Add Latest Update</h2>
            <form method="POST">
                <label>Post Title</label>
                <input type="text" name="title" placeholder="e.g. 12 Online Certificate Courses..." required>
                
                <label>Category</label>
                <input type="text" name="category" placeholder="e.g. OPPORTUNITIES & EVENTS">
                
                <label>Author Name</label>
                <input type="text" name="author" placeholder="e.g. ADITYA ARYAN">
                
                <label>Featured Image URL</label>
                <input type="text" name="image_url" placeholder="Paste image link here" required>
                
                <label>Status Badge</label>
                <select name="status">
                    <option value="Ongoing">Ongoing</option>
                    <option value="Closed">Closed</option>
                    <option value="Expiring Soon">Expiring Soon</option>
                </select>
                
                <button type="submit" name="submit_post">Publish to Feed</button>
            </form>
        </div>

        <div class="card">
            <h2><i class="fa-solid fa-ad"></i> Manage Advertisements</h2>
            <form method="POST">
                <label>Ad Position</label>
                <select name="position" required>
                    <option value="top_left">Top Banner (Left)</option>
                    <option value="top_right">Top Banner (Right)</option>
                    <option value="sidebar">Sidebar Ad Box</option>
                </select>
                
                <label>New Banner Image URL</label>
                <textarea name="banner_url" rows="4" placeholder="Paste the new advertisement image URL here..." required></textarea>
                
                <p style="font-size: 12px; color: #777; margin-top: 10px;">
                    *Note: Updating a position will replace the existing ad on the homepage.
                </p>
                
                <button type="submit" name="update_banner" style="background: #333;">Update Banner</button>
            </form>

            <div style="margin-top: 40px; border-top: 1px solid #ddd; padding-top: 20px;">
                <h3>Current Stats</h3>
                <p><i class="fa-solid fa-users"></i> Total Subscribers: 
                    <strong><?php echo $conn->query("SELECT id FROM subscriptions")->num_rows; ?></strong>
                </p>
                <p><i class="fa-solid fa-newspaper"></i> Total Live Posts: 
                    <strong><?php echo $conn->query("SELECT id FROM posts")->num_rows; ?></strong>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>