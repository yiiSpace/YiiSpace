<<angularJs by example>>

The advantage of breaking an app into multiple SPAs is that only relevant scripts
related to the app are loaded. For a small app, this may be an overkill but for large
apps, it can improve the app performance.
The challenge with this approach is to identify what parts of an application
can be created as independent SPAs; it totally depends upon the usage pattern
of the application.
For example, assume an application has an admin module and an end consumer/
user module. Creating two SPAs, one for admin and the other for the end customer,
is a great way to keep user-specific features and admin-specific features separate.
A standard user may never transition to the admin section/area, whereas an admin
user can still work on both areas; but transitioning from the admin area to a
user-specific area will require a full page refresh.
If breaking the application into multiple SPAs is not possible, the other option is
to perform the lazy loading of a module.