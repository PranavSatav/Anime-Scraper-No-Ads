<?php
// Function to fetch and parse the webpage
function fetchWebPage($url) {
    $html = file_get_contents($url);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // Disable libxml errors
    $dom->loadHTML($html);
    libxml_clear_errors();
    return $dom;
}

// Function to extract image URLs with data-src="https://gogocdn.net/cover/"
function extractImageUrls($dom) {
    $imageUrls = [];
    $xpath = new DOMXPath($dom);
    $elements = $xpath->query("//img[contains(@data-src, 'https://gogocdn.net/cover/')]");

    foreach ($elements as $element) {
        $imageUrl = $element->getAttribute('data-src');
        if (!empty($imageUrl)) {
            $imageUrls[] = $imageUrl;
        }
    }

    return $imageUrls;
}

// Function to remove duplicates from an array
function removeDuplicates($array) {
    return array_values(array_unique($array));
}

// Function to scrape multiple pages and get all unique image URLs
function scrapeUniqueImageUrls($baseURL, $totalPages) {
    $allImageUrls = [];

    for ($page = 1; $page <= $totalPages; $page++) {
        $url = "{$baseURL}&page={$page}";
        $dom = fetchWebPage($url);
        $imageUrls = extractImageUrls($dom);
        $allImageUrls = array_merge($allImageUrls, $imageUrls);
    }

    return removeDuplicates($allImageUrls);
}

// Function to scrape multiple pages and get all image URLs from home page
function scrapeAllHomePages($baseURL) {
    $dom = fetchWebPage($baseURL);
    $imageUrls = extractImageUrls($dom);
    return removeDuplicates($imageUrls);
}

// Base URL of the website to scrape
$baseURL = 'https://anikatsu.me/type/movies?aph=';

// Total number of pages to scrape
$totalPages = 10;

// Fetch all unique image URLs from the specified pages and home page
$imageUrlsFromPages = scrapeUniqueImageUrls($baseURL, $totalPages);
$imageUrlsFromHome = scrapeAllHomePages('https://anikatsu.me/home');

// Merge the image URLs from both sources
$imageUrls = array_merge($imageUrlsFromPages, $imageUrlsFromHome);

// Separate images into Dub and Others categories
$dubImages = [];
$otherImages = [];

foreach ($imageUrls as $imageUrl) {
    $imageName = basename($imageUrl);
    $imageNameLower = strtolower($imageName);

    if (strpos($imageNameLower, 'dub') !== false) {
        $dubImages[] = $imageUrl;
    } else {
        $otherImages[] = $imageUrl;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Grid - Netflix Style</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .search-container {
            margin-top: 40px;
            text-align: center;
        }

        .search-container label {
            font-size: 18px;
        }

        .search-container input[type="text"] {
            font-size: 16px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            max-width: 100%;
        }

        .section-container {
            margin-top: 40px;
            text-align: center;
        }

        .section-title {
            font-size: 24px;
            font-weight: bold;
            text-transform: capitalize;
            margin-bottom: 10px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            max-width: 1200px;
        }

        .grid-item {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .grid-item img {
            width: 100%;
            height: 350px; /* Adjust this value as per your desired image height */
            object-fit: cover;
            display: block;
        }

        .grid-item p {
            margin: 0;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .grid-item:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="search-container">
        <label for="search">Search Image:</label>
        <input type="text" id="search" name="search" onkeyup="filterImages()">
    </div>

    <div class="section-container">
        <div class="section-title">Dub</div>
        <div class="grid-container">
            <?php foreach ($dubImages as $imageUrl): ?>
                <div class="grid-item" onclick="openPlayer('<?php echo basename($imageUrl); ?>')">
                    <img src="<?php echo $imageUrl; ?>" alt="Image">
                    <p><?php echo basename($imageUrl); ?></p> <!-- Display the image name -->
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="section-container">
        <div class="section-title">Others</div>
        <div class="grid-container">
            <?php foreach ($otherImages as $imageUrl): ?>
                <div class="grid-item" onclick="openPlayer('<?php echo basename($imageUrl); ?>')">
                    <img src="<?php echo $imageUrl; ?>" alt="Image">
                    <p><?php echo basename($imageUrl); ?></p> <!-- Display the image name -->
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function filterImages() {
            const input = document.getElementById('search').value.toLowerCase();
            const gridItems = document.querySelectorAll('.grid-item');

            let dubImagesFound = false;
            let otherImagesFound = false;

            gridItems.forEach((item) => {
                const imageName = item.querySelector('p').innerText.toLowerCase();
                if (imageName.includes(input)) {
                    item.style.display = 'block'; // Show the image
                    const isDubImage = imageName.includes('dub');
                    const isOtherImage = !isDubImage;
                    dubImagesFound = dubImagesFound || isDubImage;
                    otherImagesFound = otherImagesFound || isOtherImage;
                } else {
                    item.style.display = 'none'; // Hide the image
                }
            });

            // Show or hide section titles based on image search results
            const dubSectionTitle = document.querySelector('.section-title-dub');
            const otherSectionTitle = document.querySelector('.section-title-other');

            if (dubImagesFound) {
                dubSectionTitle.style.display = 'block';
            } else {
                dubSectionTitle.style.display = 'none';
            }

            if (otherImagesFound) {
                otherSectionTitle.style.display = 'block';
            } else {
                otherSectionTitle.style.display = 'none';
            }
        }

        function removeTrailingNumber(imageName) {
            return imageName.replace(/-\d+$/, ""); // Remove trailing number, if present
        }

        function openPlayer(imageName) {
            const basePlayerUrl = 'https://player.anikatsu.me/?id=';
            const imageNameWithoutExt = imageName.replace(/\.[^/.]+$/, ""); // Remove file extension (.png)
            const imageNameWithoutNumber = removeTrailingNumber(imageNameWithoutExt);
            const playerUrl = basePlayerUrl + imageNameWithoutNumber + '-episode-1';
            window.open(playerUrl, '_blank');
        }
    </script>
</body>
</html>
