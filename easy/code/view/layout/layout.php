<!DOCTYPE html>
<html>

<head>
  <title>Topcoder FinTech</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="view/style/style.css">
  <link rel="stylesheet" href="view/style/default_style.css">

  <!-- BOOTSTRAP -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


  <!--BOXICON CDN link -->
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

  <style>
    <?php include "view/style/table_style.css"?>
  </style>
</head>

<body>
  <main class="dashboard-main">
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
          <a href="customer-list">
            <i class='bx bxs-user-account bx-sm'></i>
            <span class="links_name">Customer List</span>
          </a>
        </li>
        <li>
          <a href="onboard">
            <i class='bx bxs-bar-chart-square bx-sm'></i>
            <span class="links_name">Onboard Customer</span>
          </a>
        </li>
      </ul>
    </section>
    <section>
      <header>
        <div>
          <img src="src/thumbnail.png" alt="">
          <p><?php echo $_SESSION['first-name'] . ' ' . $_SESSION['last-name'] ?></p>
          <form method="POST" action="logout">
            <a id='logout' href=""><i class='bx bx-log-out bx-sm'></i>Logout</a>
          </form>
        </div>
      </header>
      <?php echo $content ?>
    </section>
  </main>
</body>

</html>

<script>
  const btnSubmit = document.getElementById('logout');
  btnSubmit.addEventListener('click', function(e){
    e.preventDefault();
    let form = btnSubmit.parentElement;
    form.submit();
  });

</script>