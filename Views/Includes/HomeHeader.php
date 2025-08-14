<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ProyectoPandora/Public/css/AdminDash.css"> <!-- AdminDash.css -->
    <title>HomePortal</title>
</head>
<body>
    <nav class="sidebar locked">
      <div class="logo_items flex">
            <div class="brand">
                <img class="brand-light" src="img/Innovasys_V2.png" alt="logo">
                <img class="brand-dark" src="img/Innovasys_V2.png" alt="logo">
                <span></span>
            </div>
        <i class="bx bx-lock-alt" id="lock-icon" title="Unlock Sidebar"></i>
        <i class="bx bx-x" id="sidebar-close"></i>
      </div>
      <div class="menu_container">
        <div class="menu_items">
          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="title">Dashboard</span>
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="/ProyectoPandora/Public/index.php?route=Dash/Home" class="link flex">
                <i class="bx bx-home-alt"></i>
                <span>Home</span>
              </a>
            </li>
            <li class="item">
              <a href="#" class="link flex">
                <i class="bx bx-grid-alt"></i>
                <span>Proyecto</span>
              </a>
            </li>
          </ul>
          <ul class="menu_item">

            <li class="item">
              <a href="#" class="link flex">
                <i class="bx bxs-magic-wand"></i>
                <span>Magic Build</span>
              </a>
            </li>
            <li class="item">
              <a href="#" class="link flex">
                <i class="bx bx-folder"></i>
                <span>Nuevos Proyectos</span>
              </a>
            </li>
            <li class="item">
              <a href="#" class="link flex">
                <i class="bx bx-cloud-upload"></i>
                <span>Actualizacion</span>
              </a>
            </li>
          </ul>
          <ul class="menu_item">
            <div class="menu_title flex">
              <span class="title">Setting</span>
              <span class="line"></span>
            </div>
            <li class="item">
              <a href="#" class="link flex">
                <i class="bx bx-flag"></i>
                <span>Notice Board</span>
              </a>
            </li>
            <li class="item">
              <a href="#" class="link flex">
                <i class="bx bx-award"></i>
                <span>Award</span>
              </a>
            </li>
            <li class="item">
              <a href="#" class="link flex">
                <i class="bx bx-cog"></i>
                <span>Setting</span>
              </a>
            </li>
          </ul>
        </div>
        </div>
    </nav>
</body>
</html>