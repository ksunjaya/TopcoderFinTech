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
          <a href="" data-toggle="modal" data-target="#new-onboard" onclick="clearStatus()">
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

      <!--Modal for onboard customer-->
      <div class="modal fade modal-onboard" id="new-onboard" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-inner">
              <!-- form -->
              <form id='customer-onboarding'>
              <div class="modal-header">
                <p class="title">NEW CUSTOMER ONBOARDING</p>
              </div>
              <div class="modal-body">
                <div class="onboard-body" style="margin-left:50px; margin-right:50px; margin-top: 24px; margin-bottom: 24px;">
                  <label class="lbl" for="fullname">Name</label><br>
                  <input type="text" class="textbox" name="fullname" id="fullname" placeholder="Customer's full name"><br><br>
                  <label class="lbl" for="email">Email</label><br>
                  <input type="email" class="textbox" name="email" id="f-email" placeholder="Customer's email"><br><br>
                </div>
              </div>
              <div class="modal-footer">
                <input type="submit" class="customBtn" id='onboard-submit' value="Generate Link">
              </div>
              <!-- TODO : Styling! -->
              <p id="onboard-status" style="text-align:center; padding-left: 10px; padding-right: 10px; padding-bottom: 10px"></p>
              </form>
             </div>
          </div>
        </div>
      </div>
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

  const txtName = document.getElementById('fullname');
  const txtEmail = document.getElementById('f-email');
  const btnOnboardSubmit = document.getElementById('onboard-submit');
  btnOnboardSubmit.addEventListener('click', function(e){
    e.preventDefault();
    setDisabledOnboardForm(true);
    btnOnboardSubmit.style.color = 'black';
    btnOnboardSubmit.value = 'Processing..';
    btnOnboardSubmit.style.backgroundColor = '#F6F6FB';
    let p = document.getElementById("onboard-status");
    p.style.display="none";

    let input2 = {	
      "name" : txtName.value,
      "email" : txtEmail.value
    }
    let init2 = {
      method: 'post',
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(input2)
    }

    console.log(txtEmail.value);

    fetch('send-onboard', init2)
    .then(function(response){
      return response.json();
    }).then(function(data){
      console.log(data);
      let p = document.getElementById("onboard-status");
      p.style.display="block";
      if(data.result == true){
        p.innerHTML = "Email has been sent to customer.";
      }else{
        p.innerHTML = data.msg;
      }

      setDisabledOnboardForm(false);
      btnOnboardSubmit.style.backgroundColor = '#724DFF';
      btnOnboardSubmit.style.color = 'white';
      btnOnboardSubmit.value = 'Generate Link';
    });
  })

  function setDisabledOnboardForm(isDisabled){
    txtName.disabled = isDisabled;
    txtEmail.disabled = isDisabled;
    btnOnboardSubmit.disabled = isDisabled;
  }

  function clearStatus(){
    let p = document.getElementById("onboard-status");
    p.style.display="none";
  }
</script>