<?php
$conn = new mysqli("localhost", "root", "", "ngo_site");
$settings = ["logo" => "images/logo/default_logo.png"]; 

$result = $conn->query("SELECT logo FROM settings WHERE id = 1");
if ($result) {
    $row = $result->fetch_assoc();
    if (!empty($row['logo']) && file_exists('images/logo/' . basename($row['logo']))) {
        $settings['logo'] = 'images/logo/' . basename($row['logo']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GURU RAGAVENDHARA PHOTO GALLERY</title>
<style>
/* --- Reset & body --- */
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(145deg, #e0f7fa, #ffffff);
    color: #333;
}

/* --- Header --- */
header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 30px;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    position: sticky;
    top: 0;
    z-index: 1000;
}
header img {
    height: 60px;
    max-width: 200px;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

/* --- Page Heading --- */
.page-title {
    text-align: center;
    font-size: 2.5rem;
    font-weight: 700;
    margin: 30px 0 20px;
    color: #00796b;
    letter-spacing: 1px;
}

/* --- Album Grid --- */
.album-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 24px;
    padding: 20px 40px;
    justify-items: start;
}

/* --- Album Card --- */
.album {
    background: #ffffff;
    border-radius: 25px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}
.album:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 12px 28px rgba(0,0,0,0.15);
}
.album img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-top-left-radius: 25px;
    border-top-right-radius: 25px;
    transition: transform 0.3s ease;
}
.album:hover img {
    transform: scale(1.07);
}
.album-details {
    padding: 14px 16px;
}
.album-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 6px;
    color: #004d40;
}
.album-desc {
    font-size: 0.95rem;
    color: #666;
    line-height: 1.4;
}

/* --- Photos Section --- */
.photos-section {
    display: none;
    padding: 20px 40px;
    max-width: 1200px;
    margin: 0 auto;
}
.photos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 18px;
    margin-top: 20px;
}
.photo {
    border-radius: 20px;
    overflow: hidden;
    background: #f0f0f0;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.photo img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    display: block;
    border-radius: 20px;
    transition: transform 0.3s ease;
}
.photo:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
.photo:hover img {
    transform: scale(1.05);
}

/* --- Back Button --- */
.back-btn {
    display: inline-block;
    margin-bottom: 18px;
    padding: 10px 22px;
    background: linear-gradient(135deg, #00796b, #004d40);
    color: #fff;
    font-weight: 600;
    font-size: 0.95em;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.back-btn:hover {
    background: linear-gradient(135deg, #004d40, #00251a);
    transform: translateY(-2px) scale(1.02);
}

/* --- Album Title in Photos Section --- */
#album-title {
    font-size: 1.8rem;
    color: #00796b;
    margin-bottom: 12px;
}
</style>
</head>
<body>
<header>
    <img src="<?php echo $settings['logo']; ?>" alt="Logo">
</header>

<h1 class="page-title">GURU RAGAVENDHARA PHOTO GALLERY</h1>

<div id="albums" class="album-list"></div>

<div id="photos-section" class="photos-section">
    <button class="back-btn" onclick="showAlbums()">Back to Albums</button>
    <h3 id="album-title"></h3>
    <div id="photos" class="photos-grid"></div>
</div>

<script>
// Fetch albums
async function fetchAlbums() {
    const response = await fetch('admin/fetch_albums.php');
    return response.json();
}

// Fetch photos
async function fetchPhotos(albumId) {
    const response = await fetch('admin/fetch_photos.php?album_id=' + albumId);
    return response.json();
}

// Show albums
function showAlbums() {
    document.getElementById('albums').style.display = 'grid';
    document.getElementById('photos-section').style.display = 'none';
}

// Show photos
async function showPhotos(albumId, title) {
    document.getElementById('albums').style.display = 'none';
    document.getElementById('photos-section').style.display = 'block';
    document.getElementById('album-title').textContent = title;

    const photos = await fetchPhotos(albumId);
    const photosDiv = document.getElementById('photos');
    photosDiv.innerHTML = '';

    if (photos.length === 0) {
        photosDiv.innerHTML = '<p>No photos in this album.</p>';
        return;
    }

    photos.forEach(photo => {
        const div = document.createElement('div');
        div.className = 'photo';
        div.innerHTML = `<img src="${photo.photo}" alt="Photo">`;
        photosDiv.appendChild(div);
    });
}

// Render albums
async function renderAlbums() {
    const albums = await fetchAlbums();
    const albumsDiv = document.getElementById('albums');
    albumsDiv.innerHTML = '';

    if (albums.length === 0) {
        albumsDiv.innerHTML = '<p>No albums found.</p>';
        return;
    }

    albums.forEach(album => {
        const div = document.createElement('div');
        div.className = 'album';
        div.onclick = () => showPhotos(album.id, album.title);
        div.innerHTML = `
            <img src="${album.cover_image}" alt="Cover">
            <div class="album-details">
                <div class="album-title">${album.title}</div>
                <div class="album-desc">${album.description}</div>
            </div>
        `;
        albumsDiv.appendChild(div);
    });
}

// Initialize
renderAlbums();
</script>
</body>
</html>
