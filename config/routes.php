<?php
use Origin\Http\Router;

Router::add('/user_management/:controller/:action/*', ['plugin'=>'UserManagement']);

Router::add('/login', ['controller'=>'Users','action'=>'login','plugin'=>'UserManagement']);
Router::add('/logout', ['controller'=>'Users','action'=>'logout','plugin'=>'UserManagement']);
Router::add('/forgot_password', ['controller'=>'Users','action'=>'forgot_password','plugin'=>'UserManagement']);
Router::add('/change_password/*', ['controller'=>'Users','action'=>'change_password','plugin'=>'UserManagement']);
Router::add('/profile', ['controller'=>'Users','action'=>'profile','plugin'=>'UserManagement']);
Router::add('/signup', ['controller'=>'Users','action'=>'signup','plugin'=>'UserManagement']);
Router::add('/verify', ['controller'=>'Users','action'=>'verify','plugin'=>'UserManagement']);
