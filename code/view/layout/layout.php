<!DOCTYPE html>
<html>
  <head>
    <title>Topcoder FinTech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="view/style.css">
    <!--BOXICON CDN link -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
  </head>

  <body>
    <main>
      <section>
        <img src="src/main-logo.png" alt="company logo" id="main-logo">
        <span id="vertical-line"></span>
        <span id="menu-span">
          MENU
        </span>
        <!-- <div id="sidebar-selection">
          <div><i class='bx bxs-bar-chart-square bx-sm'></i><a href="">Onboard Customer</a></div>
          <div><i class='bx bxs-user-account bx-sm'></i><a href="">Customer List</a></div>
        </div> -->

        <ul class="navlist">
          <li>
            <a href="">
              <i class='bx bxs-bar-chart-square bx-sm'></i>
              <span class="links_name">Onboard Customer</span>
            </a>
          </li>
          <li>
            <a href="">
              <i class='bx bxs-user-account bx-sm'></i>
              <span class="links_name">Customer List</span>
            </a>
          </li>
        </ul>
      </section>
      <section>
        <?php echo $content ?>
      </section>
    </main>
  </body>
</html>