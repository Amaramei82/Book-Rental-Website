<?php require('header.php') ?>

<style>
  /* Enhanced Homepage Styles */
  .hero-carousel .carousel-item {
    height: 500px;
    background: linear-gradient(135deg, #0f172a, #1e293b);
  }
  .hero-carousel .carousel-item img {
    object-fit: cover;
    height: 100%;
    width: 100%;
    opacity: 0.7;
  }
  .hero-carousel .carousel-caption {
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(8px);
    border-radius: 2rem;
    padding: 1.5rem;
    max-width: 600px;
    margin: 0 auto;
    bottom: 20%;
  }
  .hero-carousel .carousel-caption p {
    font-size: 1rem;
    line-height: 1.5;
  }
  .section-title {
    text-align: center;
    margin: 3rem 0 1.5rem;
  }
  .section-title h2 {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #1e293b, #2563eb);
    background-clip: text;
    -webkit-background-clip: text;
    color: transparent;
    display: inline-block;
    padding-bottom: 0.5rem;
    border-bottom: 3px solid #2563eb;
  }
  .book-card {
    background: #ffffff;
    border-radius: 1.25rem;
    overflow: hidden;
    transition: transform 0.25s, box-shadow 0.25s;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    border: 1px solid #edf2f7;
  }
  .book-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 25px -12px rgba(0,0,0,0.1);
    border-color: #cbdffc;
  }
  .book-img {
    background: #f8fafc;
    padding: 1.5rem;
    text-align: center;
    height: 240px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .book-img img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.3s;
  }
  .book-card:hover .book-img img {
    transform: scale(1.02);
  }
  .book-info {
    padding: 1rem 1rem 1.2rem;
    text-align: center;
    flex-grow: 1;
  }
  .book-title {
    font-weight: 700;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
    color: #0f172a;
    line-height: 1.3;
  }
  .book-title a {
    color: inherit;
    text-decoration: none;
  }
  .book-title a:hover {
    color: #2563eb;
  }
  .book-price {
    font-weight: 800;
    color: #2563eb;
    font-size: 0.9rem;
    margin: 0.5rem 0 0;
  }
  .btn-detail {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 2rem;
    padding: 0.4rem 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #1e293b;
    transition: 0.2s;
    display: inline-block;
    text-decoration: none;
    margin-top: 0.5rem;
  }
  .btn-detail:hover {
    background: #2563eb;
    border-color: #2563eb;
    color: white;
  }
  /* Dark mode styles (compatible with existing dark mode toggle) */
  body.dark-mode .book-card {
    background: #1e293b;
    border-color: #334155;
  }
  body.dark-mode .book-title {
    color: #e2e8f0;
  }
  body.dark-mode .btn-detail {
    background: #0f172a;
    border-color: #475569;
    color: #cbd5e1;
  }
  body.dark-mode .btn-detail:hover {
    background: #2563eb;
    color: white;
  }
  body.dark-mode .hero-carousel .carousel-item {
    background: linear-gradient(135deg, #0a0f1a, #0f172a);
  }
  @media (max-width: 768px) {
    .hero-carousel .carousel-item {
      height: 350px;
    }
    .hero-carousel .carousel-caption {
      bottom: 10%;
      padding: 1rem;
      font-size: 0.8rem;
    }
    .book-img {
      height: 180px;
    }
  }
</style>

<!--------------------------------------------------CAROUSEL------------------------------------------------------------------->
<div id="myCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
            aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="Img/carousel/carousel1.jpg" alt="" class="img-fluid" />
            <div class="container">
                <div class="carousel-caption text-start"></div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="Img/carousel/carousel2.jpg" alt="" class="img-fluid" />
            <div class="container">
                <div class="carousel-caption text-end"></div>
            </div>
        </div>
        <div class="carousel-item">
            <img src="Img/carousel/carousel3.jpg" alt="" class="img-fluid" />
            <div class="container">
                <div class="carousel-caption text-start carousel-justify mt-5">
                    <br /><br /><br />
                    <p> Dear Readers,</p>
                    <br />
                    <p>
                        Due to the disruptions caused by Covid - 19 pandemic, our deliveries
                        have been affected . We would like to inform you that due to
                        various restrictions and precautions, there would be delays in
                        servicing your request . We would request for your co-operation and
                        support during this time .
                    </p>
                    <p> Team - Book Rental </p>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden"> Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden"> Next</span>
    </button>
</div>

<!--------------------------------------------NEW ARRIVALS CONTAINER------------------------------------------------------->
<div class="container mb-5 mt-5">
    <div class="section-title">
        <h2>📚 New Arrivals</h2>
    </div>
    <div class="row gy-4 gx-3">
        <?php
        $orderBy = 'id desc';
        $getProduct = getProduct($con, 4, '', '', $orderBy);
        foreach ($getProduct as $list) {
            $img = BOOK_IMAGE_SITE_PATH . $list['img'];
        ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="book-card">
                <div class="book-img">
                    <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($list['name']); ?>">
                </div>
                <div class="book-info">
                    <div class="book-title">
                        <a href="book.php?id=<?php echo $list['id']; ?>"><?php echo htmlspecialchars($list['name']); ?></a>
                    </div>
                    <div class="book-price">₹<?php echo $list['rent']; ?> <span style="font-size: 0.75rem;">/ day</span></div>
                    <a href="book.php?id=<?php echo $list['id']; ?>" class="btn-detail">
                        <i class="fas fa-info-circle"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<!--------------------------------------------MOST VIEWED CONTAINER-------------------------------------------------------->
<div class="container mb-5 mt-5">
    <div class="section-title">
        <h2>🔥 Most Viewed</h2>
    </div>
    <div class="row gy-4 gx-3">
        <?php
        function getBook($con)
        {
            $sql = "select * from books where best_seller=1 limit 8";
            $res = mysqli_query($con, $sql);
            $data = array();
            while ($row = mysqli_fetch_assoc($res)) {
                $data[] = $row;
            }
            return $data;
        }

        $getBook = getBook($con);
        foreach ($getBook as $list) {
            $img = BOOK_IMAGE_SITE_PATH . $list['img'];
        ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="book-card">
                <div class="book-img">
                    <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($list['name']); ?>">
                </div>
                <div class="book-info">
                    <div class="book-title">
                        <a href="book.php?id=<?php echo $list['id']; ?>"><?php echo htmlspecialchars($list['name']); ?></a>
                    </div>
                    <div class="book-price">₹<?php echo $list['rent']; ?> <span style="font-size: 0.75rem;">/ day</span></div>
                    <a href="book.php?id=<?php echo $list['id']; ?>" class="btn-detail">
                        <i class="fas fa-info-circle"></i> View Details
                    </a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php require('footer.php') ?>