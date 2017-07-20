<div class="container">
   <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
      <div class="panel panel-info" >
         <div class="panel-heading">
            <div class="panel-title">Se connecter</div>
            <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Mot de passe oublié?</a></div>
         </div>
         <div style="padding-top:30px" class="panel-body" >
            <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
            <form id="loginform" class="form-horizontal" role="form">
               <div style="margin-bottom: 25px" class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="adresse email">                                        
               </div>
               <div style="margin-bottom: 25px" class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input id="login-password" type="password" class="form-control" name="password" placeholder="mot de passe">
               </div>
               <div class="input-group">
                  <div class="checkbox">
                     <label>
                     <input id="login-remember" type="checkbox" name="remember" value="1"> Rester connecté
                     </label>
                  </div>
               </div>
               <div style="margin-top:10px" class="form-group">
                  <!-- Button -->
                  <div class="col-sm-12 controls">
                     <a id="btn-login" href="#" class="btn btn-success">Se connecter  </a>
                     <a id="btn-fblogin" href="#" class="btn btn-primary">Se connecter avec Facebook</a>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-md-12 control">
                     <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                        Vous n'avez pas encore de compte? 
                        <a href="#" >
                        Créer un compte
                        </a>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
   </form>
</div>