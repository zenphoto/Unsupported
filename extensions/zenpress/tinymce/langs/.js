/*
 * This file is meant to fix a TinyMCE bug: when WP_LANG is not set in Wordpress,
 * TinyMCE tries to load ".js" instead of something default like en.js
 */
tinyMCE.addToLang('',{
zenpress_zenpress : 'ZenPress'
});
