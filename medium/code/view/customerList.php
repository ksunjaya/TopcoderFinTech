<div class="menu-content">
  <div class="menu-container">
    <div class="menu-detail">
      <!-- Title Menu -->
      <p>Customer List</p>

      <div class="input-search">
        <input type="search" placeholder="Search Customer..">
        <img src="src/search.png" alt="">
      </div>
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

        echo '
          <td class="td-table">'.($i+1).'</td> 
          <td class="td-table">'.$customer_list[$i]->name.'</td>
          <td class="td-table">'.$customer_list[$i]->email.'</td>
          <td class="img-thumbnail"><img src="src/thumbnail.png" alt=""></td>
          <td class="status">
            <p>'.$status.'</p>
          </td>
          <td class="action">
            <button data-toggle="modal" data-target="#detail">
              Detail
            </button>
          </td>
        ';
      }
    ?>
    <!-- <tr>
      <td class="td-table">1</td>
      <td class="td-table">Rafi</td>
      <td class="td-table">rafisetiadipura@gmail.com</td>
      <td class="img-thumbnail"><img src="src/thumbnail.png" alt=""></td>
      <td class="status">
        <p>Pending</p>
      </td>
      <td class="action">
        <button data-toggle="modal" data-target="#detail">
          Detail
        </button>
      </td>
    </tr>
    <tr>
      <td class="td-table">2</td>
      <td class="td-table">Erick Saputra</td>
      <td class="td-table">ericksaputra@gmail.com</td>
      <td class="img-thumbnail"><img src="src/thumbnail.png" alt=""></td>
      <td class="status">
        <p>Pending</p>
      </td>
      <td class="action">
        <button data-toggle="modal" data-target="#detail">
          Detail
        </button>
      </td>
    </tr> -->
  </tbody>
</table>
<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
              <p>Moch Rafi Adnan Setiadipura</p>
            </div>
            <div class="desc-profile">
              <p>Email</p>
              <p>rafisetiadipura@gmail.com</p>
            </div>
            <div class="desc-profile">
              <p>Date of birth</p>
              <p>07/03/1998</p>
            </div>
            <div class="desc-Profile">
              <p>Passport Number</p>
              <p>A0577321</p>
            </div>
            <div class="desc-profile">
              <p>Country</p>
              <p>Indonesia</p>
            </div>
            <div class="desc-profile">
              <p>Nationality</p>
              <p>Indonesian</p>
            </div>
            <div class="desc-profile">
              <p>Phone Number</p>
              <p>085122134412</p>
            </div>
            <div class="desc-profile">
              <p>Occupation</p>
              <p>Student</p>
            </div>
            <div class="desc-profile">
              <p>Address</p>
              <p>Ciumbuleuit no 11, Bandung City, West Java, Indonesia</p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="customBtn" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>