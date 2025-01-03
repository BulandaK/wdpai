<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../Public/css/sign-up.css" />
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
          <h2>Create account</h2>
          <form method="POST" action="/signUp">
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
              type="text"
              id="name"
              name="name"
              required
              placeholder="name"
            />

            <input
              type="text"
              id="surname"
              name="surname"
              required
              placeholder="surname"
            />

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

            <button type="submit" class="create-account-button">
              Create account
            </button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
