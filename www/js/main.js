/*
    8888888b. 888b    888Y88b   d88PY88b   d88P 
    888   Y88b8888b   888 Y88b d88P  Y88b d88P  
    888    88888888b  888  Y88o88P    Y88o88P   
    888   d88P888Y88b 888   Y888P      Y888P    
    8888888P" 888 Y88b888    888       d888b    
    888       888  Y88888    888      d88888b   
    888       888   Y8888    888     d88P Y88b  
    888       888    Y888    888    d88P   Y88b
 
    PNYX: The KCSU Policy Database
    ==============================

    @url       http://github.com/gfarrell/Pnyx
    @license   GNU General Public License v3.0 http://opensource.org/licenses/GPL-3.0

    Copyright (C) 2012 Gideon Farrell

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    Javascript Entry Point
    ----------------------

    This file defines all the paths for the application, and bootstraps it.

    @file    main.js
    @package js
    @author  Gideon Farrell <me@gideonfarrell.co.uk>
 */



// Basic configuration
require.config({
    baseUrl: '/js',
    paths: {
        'underscore': 'lib/underscore/underscore',
        'jquery':     'lib/jquery/jquery-1.8.3',
        'bootstrap':  'lib/bootstrap'
    }
});

// Initialise application
require(
    ['jquery', 'underscore', 'bootstrap/dropdown', 'bootstrap/alert'],
    function() {
        
    }
);