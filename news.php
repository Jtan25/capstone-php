<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News - ADOHRE</title>
    <link rel="icon" href="assets/logo.png" type="image/jpg" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Styles -->
    <style>
    :root {
        --primary-color: #28a745;
        --secondary-color: #2c3e50;
        --accent-color: #f8f9fa;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #ffffff;
    }

    .news-container {
        background: var(--accent-color);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .news-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.15);
    }

    .news-card img {
        height: 250px;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
    }

    .news-card-body {
        padding: 1.5rem;
    }

    .news-meta {
        color: var(--primary-color);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 2rem;
        position: relative;
        padding-left: 1.5rem;
    }

    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 70%;
        width: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .category-badge {
        background: var(--primary-color);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
        display: inline-block;
        margin-bottom: 0.5rem;
    }

    .read-more {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .read-more:hover {
        color: #218838;
    }

    .scrollable-section {
        max-height: 90vh;
        overflow-y: auto;
        padding-right: 1rem;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #218838;
    }
    </style>
</head>

<body>
    <header>
        <?php include('header.php'); ?>
        <?php
    if (!isset($_SESSION['user_id'])) {
      header("Location: login.php");
      exit;
    }
    ?>
    </header>

    <?php include('sidebar.php'); ?>

    <main class="container mt-4 mb-4">
        <div class="news-container">
            <h2 class="section-title">Latest News</h2>
            <div class="scrollable-section" id="newsList">
                <!-- News articles will be populated here -->
            </div>
        </div>
    </main>

    <?php include('footer.php'); ?>

    <!-- Bootstrap JS -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const newsList = document.getElementById('newsList');

        // Fetch and render news
        fetch('backend/routes/news_manager.php?action=fetch')
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    renderNews(data.news);
                } else {
                    showError('Failed to load news');
                }
            })
            .catch(err => {
                console.error('Fetch error:', err);
                showError('Failed to load news');
            });

        function renderNews(news) {
            const html = news.map(article => `
          <div class="news-card">
            <img src="${article.image || 'assets/default-news.jpg'}" class="card-img-top" alt="${article.title}">
            <div class="news-card-body">
              <span class="category-badge">${article.category}</span>
              <div class="news-meta">
                <i class="fas fa-clock me-2"></i>
                ${new Date(article.published_date).toLocaleDateString()}
                <i class="fas fa-user ms-3 me-2"></i>
                ${article.author}
              </div>
              <h3 class="h4 fw-bold mb-3">${article.title}</h3>
              <p class="text-muted mb-3">${article.excerpt}</p>
              <a href="news-detail.php?id=${article.news_id}" class="read-more">
                Read More 
                <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        `).join('');
            newsList.innerHTML = html || '<p class="text-center text-muted">No news articles available</p>';
        }

        function showError(message) {
            newsList.innerHTML = `
          <div class="col-12 text-center text-danger">
            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
            <p>${message}</p>
          </div>
        `;
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>