<form class="form-signin" action="" method="post">
    {{ flash.output() }}
    <div class="login-wrap">
        <input type="text" class="form-control" placeholder="User ID" name="username" autofocus>
        <input type="password" class="form-control" placeholder="Password" name="password">
        <button class="btn btn-lg btn-success btn-block" type="submit">LOGIN</button>
    </div>


</form>