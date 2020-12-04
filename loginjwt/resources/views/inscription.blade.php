<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>inscription</title>
</head>

<body>

  <h1>REGISTER</h1>


  <div>
    <form method="POST" action="/api/register">
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>

      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" placeholder="Nom" name="name" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" placeholder="Password" name="password" class="form-control" id="password" required>
        <script></script>
        <meter max="4" id="password-strength-meter"></meter>
        <p id="password-strength-text"></p>
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirmation Password</label>
        <input type="password" placeholder="Confirmation Password" name="confirm_password" class="form-control" required>

      </div>

      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <a href="/welcome" role="button" class="btn btn-success">Se connecter</a>





  <!-- https://css-tricks.com/password-strength-meter/ -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>
  <script>
    var strength = {
      0: "Worst",
      1: "Bad",
      2: "Weak",
      3: "Good",
      4: "Strong"
    }
    console.log('l');

    var password = document.getElementById('password');
    var meter = document.getElementById('password-strength-meter');
    var text = document.getElementById('password-strength-text');

    password.addEventListener('input', function() {
      var val = password.value;
      var result = zxcvbn(val);
      // Update the password strength meter
      meter.value = result.score;

      // Update the text indicator
      if (val !== "") {
        text.innerHTML = "Strength: " + strength[result.score];
      } else {
        text.innerHTML = "";
      }
    });
  </script>

</body>

</html>


<style>
  meter {
    /* Reset the default appearance */
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;

    margin: 0 auto 1em;
    width: 100%;
    height: 0.5em;

    /* Applicable only to Firefox */
    background: none;
    background-color: rgba(0, 0, 0, 0.1);
  }

  meter::-webkit-meter-bar {
    background: none;
    background-color: rgba(0, 0, 0, 0.1);
  }

  meter[value="1"]::-webkit-meter-optimum-value {
    background: red;
  }

  meter[value="2"]::-webkit-meter-optimum-value {
    background: yellow;
  }

  meter[value="3"]::-webkit-meter-optimum-value {
    background: orange;
  }

  meter[value="4"]::-webkit-meter-optimum-value {
    background: green;
  }

  /* Gecko based browsers */
  meter[value="1"]::-moz-meter-bar {
    background: red;
  }

  meter[value="2"]::-moz-meter-bar {
    background: yellow;
  }

  meter[value="3"]::-moz-meter-bar {
    background: orange;
  }

  meter[value="4"]::-moz-meter-bar {
    background: green;
  }
</style>