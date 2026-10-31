<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>My wishlist | Nabta Botanical</title>
  <meta name="description" content="Your saved plants and essentials at Nabta." />
  <meta name="robots" content="noindex,nofollow" />
  <meta name="theme-color" content="#c5d4b4" />
  <link rel="icon" href="../../public/assets/img/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="../../public/assets/css/shared.css">
  <link rel="stylesheet" href="../../public/assets/css/style.css">
  <link rel="stylesheet" href="../../public/assets/css/canopy.css">

  <style>
    /* ===== Wishlist page only ===== */
    .wishlist-page{
      --wl-accent:#d5f56b;               /* لون السعر والزر الرئيسي: غيّره من هون */
      --wl-card:rgba(10,28,20,.62);
      --wl-border:rgba(255,255,255,.14);
    }

    .wishlist-page .wishlist-grid{
      display:grid;
      grid-template-columns:repeat(auto-fill,minmax(250px,1fr));
      gap:24px;
      align-items:stretch;
    }

    .wishlist-page .wishlist-card{
      display:flex;
      flex-direction:column;
      height:100%;
      margin:0;
      padding:0;
      overflow:hidden;
      background:var(--wl-card);
      border:1px solid var(--wl-border);
      border-radius:22px;
      backdrop-filter:blur(8px);
      transition:transform .25s ease,border-color .25s ease,box-shadow .25s ease;
    }
    .wishlist-page .wishlist-card:hover{
      transform:translateY(-4px);
      border-color:rgba(213,245,107,.55);
      box-shadow:0 14px 34px rgba(0,0,0,.35);
    }

    /* الصورة: نسبة ثابتة عشان كل الكروت تطلع بنفس الحجم */
    .wishlist-page .wishlist-card .product-visual{
      position:relative;
      display:block;
      width:100%;
      aspect-ratio:4/4.4;
      margin:0;
      overflow:hidden;
      border-radius:0;
    }
    .wishlist-page .wishlist-card .product-visual img{
      display:block;
      width:100%;
      height:100%;
      object-fit:cover;
      transition:transform .5s ease;
    }
    .wishlist-page .wishlist-card:hover .product-visual img{transform:scale(1.05)}

    .wishlist-page .wishlist-card .product-tag{
      position:absolute;
      top:12px;
      left:12px;
      padding:6px 12px;
      font-size:.72rem;
      font-weight:700;
      letter-spacing:.04em;
      color:#10231a;
      background:var(--wl-accent);
      border-radius:999px;
    }

    /* المعلومات: بتاخد باقي ارتفاع الكارد والأزرار تنزل لآخره */
    .wishlist-page .wishlist-card .product-info{
      display:flex;
      flex-direction:column;
      flex:1;
      gap:6px;
      padding:18px 18px 20px;
    }
    .wishlist-page .wishlist-card .product-info h3{
      margin:0;
      font-size:1.12rem;
      line-height:1.25;
    }
    .wishlist-page .wishlist-card .product-info h3 a{color:inherit;text-decoration:none}
    .wishlist-page .wishlist-card .product-info p{
      margin:0;
      font-size:.88rem;
      opacity:.7;
    }

    /* السعر: واضح */
    .wishlist-page .wishlist-card .price{
      display:block;
      margin-top:2px;
      font-size:1.35rem;
      font-weight:700;
      line-height:1.2;
      color:var(--wl-accent);
    }

    /* الأزرار جنب بعض */
    .wishlist-page .wishlist-actions{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:10px;
      margin-top:auto;
      padding-top:14px;
    }
    .wishlist-page .wishlist-actions form{margin:0}
    .wishlist-page .wishlist-actions .btn{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      width:100%;
      min-height:44px;
      padding:0 10px;
      font-size:.88rem;
      white-space:nowrap;
      border-radius:999px;
    }
    .wishlist-page .wishlist-actions .btn.secondary:hover{
      border-color:#ff8a80;
      color:#ff8a80;
    }

    @media (max-width:520px){
      .wishlist-page .wishlist-grid{grid-template-columns:1fr}
    }
  </style>
</head>
<body class="botanical-edition wishlist-page">
<a class="skip" href="#main">Skip to content</a>

<header class="header"><div class="container header-row">
  <a class="logo" href="#" aria-label="Nabta home"><svg class="leaf-logo" viewBox="0 0 36 36" aria-hidden="true"><path d="M28 5C9 4 4 15 10 24c8 7 21-2 18-19Z"/><path d="M8 31 23 12"/></svg>NABTA<span class="logo-sub">BOTANICAL</span></a>
  <nav class="main-nav" aria-label="Main navigation">
    <a href="#">Shop all</a>
    <a href="#">Find your plant ↗</a>
  </nav>
  <div class="header-actions">
    <a href="#" aria-label="Search products"><svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="10" cy="10" r="6"/><path d="m15 15 5 5"/></svg></a>
    <a href="wishlist.php" aria-label="My wishlist"><svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10Z"/></svg></a>
    <a class="account-link" href="profile.php">My account</a>
    <a class="account-link register-link" href="#">Sign out</a>
    <a class="bag-link" href="#" aria-label="Shopping basket"><svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 7h14l1 14H4L5 7Z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/></svg><span class="bag-count">0</span></a>
    <details class="mobile-nav"><summary aria-label="Open navigation">☰</summary><nav>
      <a href="#">Shop plants &amp; essentials</a>
      <a href="#">Plant assistant</a>
      <a href="profile.php">My account</a>
      <a href="wishlist.php">My wishlist</a>
      <a href="#">Sign out</a>
    </nav></details>
  </div>
</div></header>

<main id="main"><div class="container page-main">
  <nav class="breadcrumbs" aria-label="Breadcrumb"><a href="#">Home</a><span>/</span><span>My wishlist</span></nav>
  <div class="page-heading"><div><div class="eyebrow">SAVED FOR LATER</div><h1>Your wishlist.</h1><p>The pieces you love, all in one place.</p></div></div>

  <div class="account-layout" style="display:block">
    <div class="flex" style="flex-wrap:wrap;gap:12px;margin-bottom:24px">
      <a class="btn secondary" href="profile.php">Personal information</a>
      <a class="btn secondary" href="#">My orders</a>
      <a class="btn" href="wishlist.php">My wishlist</a>
      <a class="btn secondary" href="#">Sign out</a>
    </div>

    <section>
      <div class="wishlist-grid">

        <article class="product-card wishlist-card">
          <a class="product-visual" href="#" aria-label="View Monstera">
            <img src="../../public/assets/img/plant.jpg" width="900" height="990" loading="lazy" alt="Monstera">
          </a>
          <div class="product-info">
            <h3><a href="#">Monstera</a></h3>
            <p>Indoor plant</p>
            <span class="price">12.50 JOD</span>
            <div class="wishlist-actions">
              <form method="post" action="#"><button class="btn" type="submit">Add to basket</button></form>
              <form method="post" action="#"><button class="btn secondary" type="submit" aria-label="Remove Monstera from wishlist">Remove</button></form>
            </div>
          </div>
        </article>

        <article class="product-card wishlist-card">
          <a class="product-visual" href="#" aria-label="View Peace Lily">
            <img src="../../public/assets/img/plant.jpg" width="900" height="990" loading="lazy" alt="Peace Lily">
          </a>
          <div class="product-info">
            <h3><a href="#">Peace Lily</a></h3>
            <p>Indoor plant</p>
            <span class="price">8.00 JOD</span>
            <div class="wishlist-actions">
              <form method="post" action="#"><button class="btn" type="submit">Add to basket</button></form>
              <form method="post" action="#"><button class="btn secondary" type="submit" aria-label="Remove Peace Lily from wishlist">Remove</button></form>
            </div>
          </div>
        </article>

        <article class="product-card wishlist-card">
          <a class="product-visual" href="#" aria-label="View Organic Care Collection">
            <img src="../../public/assets/img/plant.jpg" width="900" height="990" loading="lazy" alt="Organic Care Collection">
            <span class="product-tag">Collection · -10%</span>
          </a>
          <div class="product-info">
            <h3><a href="#">Organic Care Collection</a></h3>
            <p>Collection</p>
            <span class="price">3.83 JOD</span>
            <div class="wishlist-actions">
              <form method="post" action="#"><button class="btn" type="submit">Add to basket</button></form>
              <form method="post" action="#"><button class="btn secondary" type="submit" aria-label="Remove Organic Care Collection from wishlist">Remove</button></form>
            </div>
          </div>
        </article>

      </div>

      <!--
        Empty state: لو الـ wishlist فاضية، استبدل بلوك wishlist-grid فوق بهاد:

        <div class="empty-state">
          <h3>Nothing saved yet</h3>
          <p>Tap the heart on any product and it will wait for you here.</p>
          <a class="btn" href="#">Browse the collection</a>
        </div>
      -->
    </section>
  </div>
</div></main>

<footer class="footer"><div class="container">
  <div class="footer-grid">
    <div>
      <a class="logo" href="#" aria-label="Nabta home"><svg class="leaf-logo" viewBox="0 0 36 36" aria-hidden="true"><path d="M28 5C9 4 4 15 10 24c8 7 21-2 18-19Z"/><path d="M8 31 23 12"/></svg>NABTA<span class="logo-sub">BOTANICAL</span></a>
      <p>A little nature, closer to home.<br>Plants, thoughtful objects, and everyday growing essentials.</p>
    </div>
    <div><div class="footer-title">GROW YOUR SPACE</div><nav class="footer-links">
      <a href="#">Shop the collection</a>
      <a href="#">Plant assistant</a>
    </nav></div>
    <div><div class="footer-title">YOUR NABTA</div><nav class="footer-links">
      <a href="profile.php">My account</a>
      <a href="wishlist.php">My wishlist</a>
    </nav></div>
    <div><div class="footer-title">ROOTED IN THE EVERYDAY</div><p>For windowsills, balconies, and the small corners that make a home.</p></div>
  </div>
  <div class="footer-bottom">
    <span>© 2026 Nabta Botanical</span>
    <span>Jordan / JOD</span>
  </div>
</div></footer>
</body>
</html>