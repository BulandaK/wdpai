<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../Public/css/login.css" />
    <title>CineReserve</title>
  </head>
  <body>
    <div class="container">
      <div class="left-section">
        <div class="branding">
          <h1>Look for more in CineReserve</h1>
        </div>
        <div class="image">
          <img src="../Public/img/logo.svg" alt="CineReserve visual" />
          <img src="../Public/img/fogs/fog1.svg" alt="" />
          <img src="../Public/img/fogs/fog2.svg" alt="" />
          <img src="../Public/img/fogs/fog3.svg" alt="" />
        </div>
      </div>

      <div class="right-section">
        <div class="form-container">
          <h2>Log in</h2>
          <form method="POST" action="login"  >
            <div>
             <?php if(isset($messages)) 
                {
                  foreach ($messages as $message){
                    echo $message;
                  }

                }
             ?>
            </div>
            <input
              type="email"
              id="email"
              name="email"
              required
              placeholder="email"
            />

            <input
              type="password"
              id="password"
              name="password"
              required
              placeholder="password"
            />

            <button type="submit" class="create-account-button">Sign in</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
