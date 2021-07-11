<?php
use Origin\Http\Router;

/**
 * # # # Important # # #
 *
 * If you have used the user-authentication:install and are copying these, you will need to
 * remove the plugin key and value.
 */

/**
 * Core Routes
 */
Router::add('/login', ['controller'=>'Users','action'=>'login','plugin'=>'UserAuthentication']);
Router::add('/logout', ['controller'=>'Users','action'=>'logout','plugin'=>'UserAuthentication']);
Router::add('/forgot_password', ['controller'=>'Users','action'=>'forgot_password','plugin'=>'UserAuthentication']);
Router::add('/change_password/*', ['controller'=>'Users','action'=>'change_password','plugin'=>'UserAuthentication']);
Router::add('/profile', ['controller'=>'Users','action'=>'profile','plugin'=>'UserAuthentication']);
Router::add('/signup', ['controller'=>'Users','action'=>'signup','plugin'=>'UserAuthentication']);
Router::add('/verify', ['controller'=>'Users','action'=>'verify','plugin'=>'UserAuthentication']);

/**
 * Remove any of these if you don't need them
 */
Router::add('/token', ['controller'=>'Users','action'=>'token','plugin'=>'UserAuthentication']);
