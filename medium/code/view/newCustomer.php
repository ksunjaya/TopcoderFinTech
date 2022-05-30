<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="view/style/newCustomer.css">
        <title>Customer Registration</title>
    </head>
    <body>
        <div class="container">
            <header>
                <h3>SET UP YOUR FINTECH ACCOUNT</h3>
        
                <p>Takes less than 10 minutes to fill out all the information needed to register your account.</p>
                
            </header>

            <div class="content">
                <form id="form1" action="" method="POST">
                    <label for="">Personal Identity Document</label>
                    <p id="info">Passport only</p>
                    <div class="upload-container">
                        <input type="file" id="passport_upload" name="passport_img" required>
                    </div>
                    <!-- <button class="upload-btn" onclick="uploadFile()">Upload</button> -->
                    

                    <label for="">Record a 5 second selfie video</label>
                    <p id="info">Make sure your face isn't covered up with glasses, mask, or any other objects</p>
                    <div class="upload-container">
                        <input type="file" id="video_upload" name="video" required>
                    </div>
                    <!-- <button class="upload-btn" onclick="uploadFile()">Upload</button> -->
                    
                    <div class="wrapper">
                        <label for="passport-number">Passport Number</label>
                        <label for="dob">Date of Birth</label>
                        <input type="text" name="passport-number" id='passport-number' required>
                        <input type="date" name="dob" id='dob' required> 

                        <label for="nationality">Nationality</label>
                        <label for="cor">Country of Residence</label>
                        <input type="text" name="nationality" id="nationality" required>
                        <input type="text" name="cor" id="cor" required>

                        <label for="phone-number">Phone Number</label>
                        <label for="occupation">Occupation</label>
                        <input type="text" name="phone-number" id="phone-number" required>
                        <input type="text" name="occupation" id="occupation" required>
                    </div>
                    <br>
                    <label for="current-address">Current Address</label><br>
                    <input type="text" name="current-address" id="curr-addr">
                    <div class="submit-btn">
                        <input type="submit" class="submit-btn" id="submitform-btn" value="Submit Form">
                    </div>
                    
                </form>
            </div>
        </div>
        
        
    </body>
    <script>
        function uploadFiles(e) {
          e.preventDefault();
          var files = document.getElementById('passport_upload').files;
          if(files.length==0){
            alert("Please first choose or drop any file(s)...");
            return;
          }
          var filenames="";
          for(var i=0;i<files.length;i++){
            filenames+=files[i].name+"\n";
          }
          alert("Selected file(s) :\n____________________\n"+filenames);
        }
    
        function init(){
            let field = Array.from(document.querySelectorAll("input:not(.submit-btn)"));
            field.forEach(item => {
                item.addEventListener('input', function(e){
                    item.style.backgroundColor = '#F6F6FB';
                });
            });
            let btnSubmit = document.getElementById('submitform-btn');
            btnSubmit.addEventListener('click', onSubmit);
        }

        function onSubmit(e){
            e.preventDefault();
            let form1 = document.getElementById('form1');
            form1.checkValidity();

            let formData = new FormData();
            let fileField = Array.from(document.querySelectorAll("input[type='file']"));
            formData.append('passport-img', fileField[0].files[0]);
            formData.append('video', fileField[1].files[0]);
            formData.append('passport-number', document.getElementById('passport-number').value);
            formData.append('dob', document.getElementById('dob').value);
            formData.append('nationality', document.getElementById('nationality').value);
            formData.append('cor', document.getElementById('cor').value);
            formData.append('phone-number', document.getElementById('phone-number').value);
            formData.append('occupation', document.getElementById('occupation').value);
            formData.append('curr-addr', document.getElementById('curr-addr').value);
            formData.append('cust-id', '<?php echo $id;?>');

            //debug
            var object = {};
            formData.forEach((value, key) => object[key] = value);
            var json = JSON.stringify(object);
            console.log(json);
            
            if(!checkValidity()) return;
            
            fetch('c-register', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .catch(error => console.error('Error:', error))
            .then(response => {
                console.log(response);
                if(response.status == true){
                    window.location.replace('new-customer-s');
                }else{
                    console.log(response);
                }
            });
        }

        function checkValidity(){
            let field = Array.from(document.querySelectorAll("input:not(.submit-btn)"));
            let res = true;
            field.forEach(item => {
                if(item.value == ""){
                    res = false;
                    item.style.backgroundColor = '#ff6961';
                }
            });
            return res;
        }

        init();
    </script>
</html>