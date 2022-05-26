<?php
  $NewDate=Date('d-m-Y', strtotime('+3 days'));
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap');
      *{
        font-family: 'Open Sans';
      }
      body{
        margin: 0px;
      }
      div{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        height: 100vh;
      }
      h3, p{
        margin-bottom: 4px;
      }
    </style>
    <title>Customer Registration</title>
  </head>
  <body>
    <div>
      <img src="src/done.png">
      <h3>Your Document is Under Review</h3>
      <p>Thank you for filling the form. You will receive an email after verification is done.</p>
      <p>70% of accounts are verified within a day, but users may experience delays up to three days.</p>
    </div>
  </body>
</html>