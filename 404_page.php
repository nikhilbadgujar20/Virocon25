<?php include 'INCLUDE/header.php' ?>

<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #1a1a1a;
    color: #fff;
    /* display: flex; */
    justify-content: center;
    align-items: center;
    /* height: 100vh; */
    text-align: center;
  }

  /* .container {
      max-width: 600px;
      padding: 20px;
    } */

  h1 {
    font-size: 3em;
    margin-bottom: 0.5em;
    color: #f39c12;
  }

  p {
    font-size: 1.2em;
    line-height: 1.6;
  }

  .gear {
    font-size: 5em;
    margin-bottom: 0.3em;
    animation: spin 4s linear infinite;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }
</style>
<div class="container-fluid mt-5 pt-5">
  <div class="gear">⚙️</div>
  <h1>Under Maintenance</h1>
  <p style="color: white";>We're currently working on something awesome.<br>
    Please check back soon!</p>
</div>
<?php include 'INCLUDE/footer.php' ?>