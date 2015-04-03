<?php

return [

    // The model we use to interact with the database.
    'model' => 'Bernardino\EasyAuthenticator\Models\User',

    /**
     * The path to redirect to after successful authentication.
     * By default, after authenticating the user will be
     * redirected to /dashboard.
     */
    'login_redirect' => 'dashboard1',

    /*
     * The route to the login page. By default this is set to
     * be login. Feel free to change this as you wish.
     */
    'login_page' => 'login',

    // Route you want to use when logging out.
    'logout' => 'logout',

    // Where do you want to redirect a user after logout?
    'logout_redirect' => '/',

    /**
     * You can require users who register to activate their account
     * via email. This is useful for many reasons, such as to prevent
     * spam. If you set this value to TRUE, you will then also need
     * to set up mailing as per laravel.com/docs/5.0/mail.
     * Once set up is done easyAuthenticator will take care of the rest.
     */
    'activation' => FALSE,
    // Set a subject line for the email.
    'email_subject' => 'Please activate your account.',

    /**
     * You can set session flash variables for following scenarios
     * 1. When a user logs in.
     * 2. When a user logs out
     *
     * If you wish to disable this functionality set flash_session
     * to FALSE
     */
    'flash_session' => FALSE,
    'flash_session_key' => 'message',
    'flash_session_login' => "Welcome back",
    'flash_session_logout' => 'See you again soon!',
];
