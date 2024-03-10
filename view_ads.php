<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Website</title>
    <style>
        /* Add your CSS styles here */
        .news-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .news-card {
            max-width: 300px;
            background-color: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .news-card img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
        }
        .news-card-content {
            padding: 20px;
        }
        .news-card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .news-card-details {
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="news-container" id="news-container">
    </div>

    <script>
        // Function to fetch news data from the API endpoint
        function fetchNews() {
            fetch('http://localhost/africtvApi/ads/read.php')
                .then(response => response.json())
                .then(data => displayNews(data.data))
                .catch(error => console.error('Error fetching news:', error));
        }

        // Function to display news data in cards
        function displayNews(data) {
            var newsContainer = document.getElementById('news-container');

            data.forEach(function(item) {
                var newsCard = document.createElement('div');
                newsCard.classList.add('news-card');

                var img = document.createElement('img');
                img.src = item.img_video;
                img.alt = 'Image';

                var content = document.createElement('div');
                content.classList.add('news-card-content');

                var title = document.createElement('h2');
                title.classList.add('news-card-title');
                title.textContent = item.description;

                var date = document.createElement('p');
                date.classList.add('news-card-details');
                date.textContent = 'Date: ' + item.ads_start;

                var readTime = document.createElement('p');
                readTime.classList.add('news-card-details');
                readTime.textContent = 'Read Time: ' + item.ads_end;

                var views = document.createElement('p');
                views.classList.add('news-card-details');
                views.textContent = 'Number of Views: ' + item.number_of_views;

                var link = document.createElement('a');
                link.href = item.share_url;
                link.textContent = 'Visit';

                content.appendChild(title);
                content.appendChild(date);
                content.appendChild(readTime);
                content.appendChild(views);
                content.appendChild(link);

                newsCard.appendChild(img);
                newsCard.appendChild(content);

                newsContainer.appendChild(newsCard);
            });
        }

        // Fetch and display news data when the page loads
        window.onload = function() {
            fetchNews();
        };
    </script>
</body>
</html>
