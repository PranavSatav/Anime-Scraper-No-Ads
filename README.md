# Anime-Scraper-No-Ads
The project is a web-based image gallery application that fetches and displays unique anime cover image URLs from specified pages and the home page. It presents a Netflix-style grid layout with separate sections for "Dub" and "Others" images, allowing users to search and filter images dynamically.


The "Anime Scraper" is a web application that provides users with a visually appealing and interactive image gallery featuring anime cover images. The main goal of this project is to fetch, display, and categorize unique anime cover image URLs from specific pages and the home page of an anime website. The application's layout is designed in a Netflix-style grid format, making it visually appealing and easy to navigate for users.

Features:

1. Web Scraping: The application uses PHP and DOMDocument to fetch and parse the HTML content of the specified pages on the anime website. It extracts anime cover image URLs from elements with the attribute "data-src" containing "https://gogocdn.net/cover/". The process ensures that duplicate URLs are removed, ensuring a unique display of images.

2. Netflix-Style Grid Layout: The image gallery features a responsive grid layout, inspired by Netflix's interface. This layout provides a seamless and visually attractive way to showcase the anime cover images, making it easy for users to browse through the collection.

3. Categorization: The application categorizes the fetched anime cover images into two sections: "Dub" and "Others." Images containing the keyword "dub" in their file names are placed in the "Dub" section, while the rest are placed in the "Others" section. This feature aids users in quickly locating anime with dubbed content.

4. Search and Filter Functionality: The image gallery includes a search box that allows users to filter the displayed images dynamically. As users type in the search box, the images are filtered based on the image names, enabling users to find specific anime covers quickly.

5. Image Details: Each image displayed in the gallery is accompanied by the name of the anime cover. This detail helps users identify the anime and provides additional context for their choices.

6. Image Player Integration: When users click on an anime cover image, a JavaScript function opens a new tab with an integrated player URL. The player URL is constructed using the image's name, allowing users to access the anime's streaming episode-1 page directly.

7. User-Friendly Interface: The application features an intuitive user interface with well-designed sections and elements, making it easy for users of all ages to navigate and explore the anime cover images.

8. Performance and Efficiency: The PHP backend ensures efficient web scraping and processing of image URLs, leading to a smooth user experience and quick loading times.

9. Scalability: The application can be easily extended to fetch and display images from additional pages or categories by modifying the base URLs and implementing relevant filtering logic.
