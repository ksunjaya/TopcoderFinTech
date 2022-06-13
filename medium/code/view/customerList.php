<div class="menu-content">
  <div class="menu-container">
    <div class="menu-detail">
      <!-- Title Menu -->
      <p>Customer List</p>

      <!-- <div class="input-search">
        <form action="" method="GET">
          <input type="search" id="text" name="c-name" placeholder="Search Customer..">
          <img src="src/search.png" id="img-submit" alt="">
        </form>
      </div> -->
    </div>
  </div>
</div>
<table width="90%">
  <thead class="header-table">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Photo</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody class="body-table">
    <?php
      for($i = 0; $i < sizeof($customer_list); $i++){
        //buat status
        $status = 'Error';
        if($customer_list[$i]->status == 0) $status = 'Pending';
        else if($customer_list[$i]->status == 1) $status = 'Awaiting Verification';
        else if($customer_list[$i]->status == 2) $status = 'Approved';
        else if($customer_list[$i]->status == 3) $status = 'Rejected';

        echo '
          <tr>
          <td class="td-table">'.($i+1).'</td> 
          <td class="td-table">'.$customer_list[$i]->name.'</td>
          <td class="td-table">'.$customer_list[$i]->email.'</td>
          <td class="img-thumbnail"><img src="src/thumbnail.png" alt=""></td>
          <td class="status">
            <p>'.$status.'</p>
          </td>
          <td class="action">
            <button onclick="openModal('.$customer_list[$i]->id.')">
              Detail
            </button>
          </td>
          </tr>
        ';
      }
    ?>
  </tbody>
</table>
<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-inner">
        <div class="modal-header">
          <img src="src/thumbnail.png" alt="">
        </div>
        <div class="modal-body">
          <div class="detail-profile">
            <div class="desc-profile">
              <p>Name</p>
              <p id='name'>Moch Rafi Adnan Setiadipura</p>
            </div>
            <div class="desc-profile">
              <p>Email</p>
              <p id='email'>rafisetiadipura@gmail.com</p>
            </div>
            <div class="desc-profile">
              <p>Date of birth</p>
              <p id='dob'>07/03/1998</p>
            </div>
            <div class="desc-profile">
              <p>Passport Number</p>
              <p id='p-number'>A0577321</p>
            </div>
            <div class="desc-profile">
              <p>Country</p>
              <p id='country'>Indonesia</p>
            </div>
            <div class="desc-profile">
              <p>Nationality</p>
              <p id='nationality'>Indonesian</p>
            </div>
            <div class="desc-profile">
              <p>Phone Number</p>
              <p id='phone'>085122134412</p>
            </div>
            <div class="desc-profile">
              <p>Occupation</p>
              <p id='occupation'>Student</p>
            </div>
            <div class="desc-profile">
              <p>Address</p>
              <p id='address'>Ciumbuleuit no 11, Bandung City, West Java, Indonesia</p>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="gap: 10px">
          <form action='accept-customer' method='POST'>
            <input type='hidden' id='acc-id' name='userid'>
            <button id='btn-acc' class="customBtn" style='background-color:green'>Accept</button>
          </form>
          <button id='btn-close' class="customBtn" data-dismiss="modal">Close</button>
          <form action='reject-customer' method='POST'>
            <input type='hidden' id='reject-id' name='userid'>
            <button id='btn-reject' class="customBtn" style='background-color: red'>Reject</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  const p_name = document.getElementById('name');
  const p_email = document.getElementById('email');
  const p_dob = document.getElementById('dob');
  const p_pnumber = document.getElementById('p-number');
  const p_country = document.getElementById('country');
  const p_nationality = document.getElementById('nationality');
  const p_phone = document.getElementById('phone');
  const p_occupation = document.getElementById('occupation');
  const p_address = document.getElementById('address');

  const btn_acc = document.getElementById('btn-acc');
  btn_acc.addEventListener('click', acceptCustomer);
  const id_acc = document.getElementById('acc-id');
  const btn_close = document.getElementById('btn-close');
  const btn_reject = document.getElementById('btn-reject');
  btn_reject.addEventListener('click', rejectCustomer);
  const id_reject = document.getElementById('reject-id');
  
  function acceptCustomer(e){
    e.preventDefault();
    let form1 = btn_acc.parentElement;
    form1.submit();
  }

  function rejectCustomer(e){
    e.preventDefault();
    console.log(btn_reject.parentElement);
  }

  function openModal(id){
    fetch('customer-detail?id='+id)
    .then(function(response){
      return response.json();
    }).then(function(data){
      p_name.innerHTML = data.name;
      p_email.innerHTML = data.email;
      p_dob.innerHTML = data.birth_date;
      p_pnumber.innerHTML = data.passport_number;
      p_country.innerHTML = data.country;
      p_nationality.innerHTML = data.nationality;
      p_phone.innerHTML = data.phone;
      p_occupation.innerHTML = data.occupation;
      p_address.innerHTML = data.address;

      id_acc.value = data.id;
      id_reject.value = data.id;
      
      hideAllModalButtons();
      if(data.status == 0){
        //customer baru dikasih emailnya, belom diisi detail
        btn_close.style.display = 'block';
      }else if(data.status == 1){
        //udah isi, harus di verifikasi
        btn_acc.style.display = 'block';
        btn_reject.style.display = 'block';
      }else{
        //udah ke verified
        btn_close.style.display = 'block';
      }
    });
    $('#detail').modal('show');
  }

  function hideAllModalButtons(){
    btn_acc.style.display = 'none';
    btn_close.style.display = 'none';
    btn_reject.style.display = 'none';
  }
</script>