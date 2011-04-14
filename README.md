# FacebookCanvasAppBundle

## Installation

    $ git clone git@github.com:caefer/FacebookCanvasAppBundle.git src/Caefer/FacebookCanvasAppBundle
    $ git clone https://github.com/facebook/php-sdk.git vendor/facebook

In your `app/config/config.yml` add this to the top to import the default firewall setup.

    imports:
        - { resource: "../../src/Caefer/FacebookCanvasAppBundle/Resources/config/firewall.yml" }

In the same file add access control patterns as it first your requirements. Note that these match from the top.

    security:
        access_control:
            - { path: /secure-1/, role: [FACEBOOK_PERMISSION_READ_STREAM,FACEBOOK_PERMISSION_PUBLISH_STREAM] }
            - { path: /secure-2/, role: [FACEBOOK_PERMISSION_READ_STREAM,FACEBOOK_PERMISSION_CREATE_EVENT] }
            - { path: .*,         role: [IS_AUTHENTICATED_ANONYMOUSLY] }

Then specify where your Facebook PHP-SDK is located and your app id and secret.

    caefer_facebook_canvas_app:
        api:
            file:   "%kernel.root_dir%/../vendor/facebook/src/facebook.php"
            app_id: xxxxx
            secret: xxxxx

In your application you can get a service instance of that app like this.

    <?php

    $fb = $container->get('caefer_facebook_canvas_app.api');

If you need to access multiple Facebook apps in your project you can define them like this.

    caefer_facebook_canvas_app:
        file:   "%kernel.root_dir%/../vendor/facebook/src/facebook.php"
        apps:
            app_1:
                app_id: xxxxx
                secret: xxxxx
            app_2:
                app_id: yyyyy
                secret: yyyyy

You can then get your services like this.

    <?php

    $app_1 = $container->get('caefer_facebook_canvas_app.app.app_1');
    $app_2 = $container->get('caefer_facebook_canvas_app.app.app_2');

    // this will still work and act as an alias to the first app configured (app_1)
    $fb = $container->get('caefer_facebook_canvas_app.api');

Each Facebook app will automatically get its own session cookie ('fbs_' + <app_id>).

Also add the following to your `app/config/routing.yml`.

    caefer:
        resource: "@CaeferFacebookCanvasAppBundle/Resources/config/routing.xml"


## Demonstration

To see a bried demonstration also add the following to your `app/config/routing.yml`.

    caefer_demo:
        resource: "@CaeferFacebookCanvasAppBundle/Resources/config/routing_demo.xml"


