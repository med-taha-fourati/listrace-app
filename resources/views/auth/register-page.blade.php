<style>
  form {
    margin: 50px;
  }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="nofollow" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<form action="{{ route('auth.register') }}" method="post">
    @csrf
    @method('POST')

    @if (session('success'))
    				<div class="alert alert-success">
       					{{ session('success') }}
    				</div>
				@elseif (session('error'))
    				<div class="alert alert-danger">
        				{{ session('error') }}
    				</div>
				@endif
    <!-- User input -->
  <div data-mdb-input-init class="form-outline mb-4">
    <input type="text" id="form2Example1" name="name" class="form-control" />
    <label class="form-label" for="form2Example1">Username</label>
  </div>

  <!-- Email input -->
  <div data-mdb-input-init class="form-outline mb-4">
    <input type="email" id="form2Example1" name="email" class="form-control" />
    <label class="form-label" for="form2Example1">Email address</label>
  </div>

  <!-- Password input -->
  <div data-mdb-input-init class="form-outline mb-4">
    <input type="password" id="form2Example2" name="password" class="form-control" />
    <label class="form-label" for="form2Example2">Password</label>
  </div>

  <!-- Submit button -->
  <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Register</button>

  <!-- Register buttons -->
  <div class="text-center">
    <p>Already a member? <a href="{{ route('auth.login') }}">Login</a></p>
  </div>
</form>
</body>
</html>