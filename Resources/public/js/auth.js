if (!window.FBApp) {

window.FBApp={
  init: function() {alert(dada)},
  checkPermissions: function(currentPermissions, callbacks)
  {
    if (!callbacks.success) callbacks.success = function(){};
    if (!callbacks.failure) callbacks.failure = function(){};

    currentPermissions = eval('('+currentPermissions+')');
    currentPermissions = [].concat(currentPermissions.extended, currentPermissions.user, currentPermissions.friends);

    for (var i=0; i<FBAppData.requestedPermissions.length; i++) {
      if (-1 == currentPermissions.indexOf(FBAppData.requestedPermissions[i])) {
        callbacks.failure();
        return false;
      }
    }

    callbacks.success();
    return true;
  },
  checkLoginResponse: function(response)
  {
    if (response.session) {
      if (response.perms) {
        // user is logged in and granted some permissions.
        // perms is a comma separated list of granted permissions
        FBApp.resolve(true);
      } else {
        // user is logged in, but did not grant any permissions
        FBApp.resolve(true);
      }
    } else {
      // user is not logged in
      FBApp.resolve(false);
    }
  },
  checkLoginStatusResponse: function(response)
  {
    if (response.session) {
      if (!response.perms) response.perms = '{extended:[],user:[],friends:[]}';
      FBApp.checkPermissions(response.perms, {failure:FBApp.login, success:FBApp.resolve});
    } else {
      FBApp.login();
    }
  },
  login: function()
  {
    FB.login(FBApp.checkLoginResponse, { perms:FBAppData.requestedPermissions.join(',') });
  },
  resolve:function(success)
  {
    if (false != success) {
        img = new Image();
        img.src = 'http://dev.local/app_dev.php/login_check';
        FBApp.reloadWhenAuthorized(img);
    }
  },
  reloadWhenAuthorized: function(img)
  { 
    if(!img.complete){ 
      imgWait=setTimeout('FBApp.reloadWhenAuthorized(img)', 50); 
    } 
    else
    {
      window.location.reload();
    }
  } 
}

}

window.fbAsyncInit = function() {
  FB.init({appId:FBAppData.appId, session:FBAppData.session, status:true, cookie:true});
  FB.getLoginStatus(FBApp.checkLoginStatusResponse);
};

(function() {
  var e = document.createElement('script');
  e.src = document.location.protocol + '//connect.facebook.net/de_DE/all.js';
  e.async = true;
  document.getElementById('fb-root').appendChild(e);
}());
