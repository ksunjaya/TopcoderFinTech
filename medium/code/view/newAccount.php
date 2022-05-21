<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/newAccount.css">
        <title>Setup Account</title>
    </head>
    <body>
        <div class="container">
            <header>
                <h3>SET UP YOUR FINTECH ACCOUNT</h3>
        
                <p>Takes less than 10 minutes to fill out all the information needed to register your account.</p>
                
            </header>

            <div class="content">
                <form action="">
                    <label for="">Personal Identity Document</label>
                    <p id="info">Passport only</p>
                    <div class="upload-container">
                        <input type="file" id="passport_upload">
                    </div>
                    <button class="upload-btn" onclick="uploadFile()">Upload</button>
                    

                    <label for="">Record a 5 second selfie video</label>
                    <p id="info">Make sure your face isn't covered up with glasses, mask, or any other objects</p>
                    <div class="upload-container">
                        <input type="file" id="passport_upload">
                    </div>
                    <button class="upload-btn" onclick="uploadFile()">Upload</button>
                    
                    <div class="wrapper">
                        <label for="passport-number">Passport Number</label>
                        <label for="dob">Date of Birth</label>
                        <input type="text" name="passport-number">
                        <input type="date" name="dob">

                        <label for="nationality">Nationality</label>
                        <label for="cor">Country of Residence</label>
                        <input type="text" name="nationality">
                        <input type="text" name="cor">

                        <label for="phone-number">Phone Number</label>
                        <label for="occupation">Occupation</label>
                        <input type="text" name="phone-number">
                        <input type="text" name="occupation">
                    </div>
                    <br>
                    <label for="current-address">Current Address</label><br>
                    <input type="text" name="current-address" id="curr-addr">
                    
                    <div class="submit-btn">
                        <button type="submit" id="submitform-btn">Submit Form</button>
                    </div>
                    
                </form>
            </div>
        </div>
        
        
    </body>
    <script>
        function uploadFiles() {
          var files = document.getElementById('file_upload').files;
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
      </script>
</html>