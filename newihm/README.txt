Post To Your Page's Wall Example
-----------------------------------------------
This example uses a session to maintain state, which I apologize for.  It could be written in
a far more stateless fashion.  In any case, outlined below are the important parts of this tutorial.

initiate.php
-----------------------------------------------
This page will initialize the Facebook helper object, save it to a session and then redirect
the client to Facebook for authentication and authorization.  Facebook will then send the
user's response back to the "redirect_uri" path set in the helper object.

redirect_uri.php
-----------------------------------------------
This page should be set to handle Facebook's response from the access code request sent by the initiate.php page.
If the user accepts authorization for your application, an access code will be appended to the response's querystring,
otherwise, you will see an error appended to it.  This page will also publish to your page's wall with the
returned access code.

FacebookService.php
-----------------------------------------------
Facebook helper class.