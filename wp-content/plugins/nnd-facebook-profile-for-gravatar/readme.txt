=== Plugin Name ===
Contributors: NerdNextDoor
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZZJD8LKR2UAE8
Tags: Facebook, Gravatar, Profile Pictures
Requires at least: 3.0.0.1
Tested up to: 3.4.2
Stable tag: 1.9

If a user or commenter's URL field contains link to their Facebook profile this plugin will grab their Profile Picture for use as their Gravatar across the site!

== Description ==

If a user or commenter has a link to their Facebook Profile Page in their URL field(s) this plugin will go to Facebook and grab their profile picture and use it as their Gravatar across the site.  
This will work in comments as well as in the user admin area, and anywhere that Gravatars may be used.
I have also added a few additional user fields that I have found useful but they are not required.

== Installation ==

To install The Nerd Next Door's Facebook Gravatar Grabber: 

1. Extract `nnd-facebook-profile-for-gravatar` directory from the archive `nnd-facebook-profile-for-gravatar.Version#.zip`.
2. Upload `nnd-facebook-profile-for-gravatar` and its contents to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= What program do you use to do your coding? =

Notepad++.  It's absolutely incredible.

= What if I want it to do something else? =

Contact me at CodeMonkey@BostonSuperBlog.com and I'll do my best to get it working

== Screenshots ==

1. Facebook Profile picture as a Gravatar?  Sweet!

== Changelog ==

= 1.9 =

Fixed issues where Facebook had changed API to no longer allow access to "Large" image without Auth.

= 1.8 =

Now works with WordPress Admin Bar
Fixed other various issues with sizing being overridden by CSS

= 1.7 =
Changed the code to allow for higher resolution profile pictures (great for when being used in conjuction with "userphoto" or other plugins that use a gravatar at large sizes)

= 1.6 =
Cleaned up code and streamlined. Modified new user fields such as user->nndurl2, user->nndurl3, user->nndfbook, user->nndtwit, and added them to profile page without modifying core code.

= 1.5 =
Made the additional user fields accessible without modifying core files.

= 1.4 =
Added the ability to use new user fields.  This is optional but useful.

= 1.3 =
Fixed broken code at line 99.  Mising ) on if statement.

= 1.2 =
Added a screenshot

= 1.1 =
I modified the code to accept multiple URLs per user.  It will search $user->user_url, $user->user_url2, and $user->user_url3 for now.

= 1.0 =
First go at this...

== Upgrade Notice ==

= 1.8=

Now works with WordPress Admin Bar, Fixed other various issues with sizing being overridden by CSS, ***UPGRADE IMMEDIATELY TO AVOID ISSUES*

= 1.7 =
Changed the code to allow for higher resolution profile pictures (great for when being used in conjuction with "userphoto" or other plugins that use a gravatar at large sizes)

= 1.6 =
Cleaned up code and streamlined. Modified new user fields such as user->nndurl2, user->nndurl3, user->nndfbook, user->nndtwit, and added them to profile page without modifying core code.

= 1.5 =
Modified new user fields such as user->nndurl2, user->nndurl3, user->nndfbook, user->nndtwit, and added them to profile page without modifying core code.

= 1.4 =
Added new user fields such as user->user_url2, user->user_url3, user->facebook, user->twitter

= 1.3 =
Fixed broken code at line 99.  Mising ) on if statement.

= 1.0 =
Only version out there!