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

Also add the following to your `app/config/routing.yml`.

    caefer:
        resource: "@CaeferFacebookCanvasAppBundle/Resources/config/routing.xml"


## Demonstration

To see a bried demonstration also add the following to your `app/config/routing.yml`.

    caefer_demo:
        resource: "@CaeferFacebookCanvasAppBundle/Resources/config/routing_demo.xml"


